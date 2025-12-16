<?php

namespace App\Controllers;

use App\Models\InstallationModel;

class InstallationController extends BaseController
{
    public function index()
    {
        helper('url');
        
        $model = new InstallationModel();
        
        // Get search query from URL
        $query = trim((string)($this->request->getGet('search') ?? ''));
        $perPage = 12;

        // If search query exists, filter by Name or Address with pagination
        if ($query !== '') {
            // 공백이 있는 컬럼명은 where()에 SQL 문자열을 직접 사용
            $db = \Config\Database::connect();
            $builder = $db->table($model->table);
            $escapedQuery = $db->escapeLikeString($query);
            $escapedQueryValue = $db->escape('%' . $escapedQuery . '%');
            $builder->groupStart()
                ->where('`Installation Location Name` LIKE ' . $escapedQueryValue, null, false)
                ->orWhere('`Street Address` LIKE ' . $escapedQueryValue, null, false)
                ->orWhere('`Land Lot Address` LIKE ' . $escapedQueryValue, null, false)
                ->orWhere('`District Name` LIKE ' . $escapedQueryValue, null, false)
                ->orWhere('`Managing Institution Name` LIKE ' . $escapedQueryValue, null, false)
            ->groupEnd();
            
            // 페이징을 위해 Model의 paginate를 사용
            $total = $builder->countAllResults(false);
            $page = (int)($this->request->getGet('page') ?? 1);
            $offset = ($page - 1) * $perPage;
            
            $installations = $builder->orderBy('id', 'ASC')->limit($perPage, $offset)->get()->getResultArray();
            
            // Pager 설정
            $pager = \Config\Services::pager();
            $pager->store('installations', $page, $perPage, $total);
            $model->pager = $pager;
        } else {
            // If no search query, fetch all installations with pagination
            $installations = $model->orderBy('id', 'ASC')->paginate($perPage, 'installations');
        }

        // Ensure all items are arrays (not objects)
        if (!empty($installations)) {
            foreach ($installations as &$inst) {
                if (is_object($inst)) {
                    $inst = (array)$inst;
                }
            }
            unset($inst);
        }

        // Prepare data to send to the view
        $data = [
            'installations' => $installations,
            'pager' => $model->pager,
            'search' => $query
        ];

        // Return the view with data
        return view('installation/index', $data);
    }

    public function show($id)
    {
        helper('url');
        
        $model = new InstallationModel();
        $installation = $model->find($id);
        
        if (empty($installation)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Cannot find the installation data.");
        }
        
        // Ensure installation is an array
        if (is_object($installation)) {
            $installation = (array)$installation;
        }

        // ✅ 주소 우선순위: 도로명 -> 지번
        $road = trim((string)($installation['Street Address'] ?? ''));
        $lot = trim((string)($installation['Land Lot Address'] ?? ''));
        $address = $road !== '' ? $road : $lot;

        // ✅ 지오코딩 (원문 주소 -> 실패하면 정리 주소로 여러 번 시도)
        $lat = null;
        $lng = null;

        // DB에 좌표가 있으면 우선 사용
        if (isset($installation['Latitude']) && isset($installation['Longitude'])) {
            $dbLat = (float)($installation['Latitude'] ?? 0);
            $dbLng = (float)($installation['Longitude'] ?? 0);
            if ($dbLat >= -90 && $dbLat <= 90 && $dbLng >= -180 && $dbLng <= 180 && $dbLat != 0 && $dbLng != 0) {
                $lat = $dbLat;
                $lng = $dbLng;
            }
        }

        // DB 좌표가 없거나 이상하면 지오코딩 시도
        if (($lat === null || $lng === null) && $address !== '') {
            // 1차 시도: 원문 주소
            $geo = $this->naverGeocode($address);

            // 2차 시도: 기본 정리 주소
            if (!$geo) {
                $clean = $this->cleanAddressForGeocode($address);
                if ($clean !== $address && $clean !== '') {
                    $geo = $this->naverGeocode($clean);
                }
            }

            // 3차 시도: 더 간단하게 정리
            if (!$geo && $address !== '') {
                $simple = $this->simplifyAddressForGeocode($address);
                if ($simple !== $address && $simple !== '') {
                    $geo = $this->naverGeocode($simple);
                }
            }

            if ($geo) {
                $lat = $geo['lat'];
                $lng = $geo['lng'];
            }
        }

        // ✅ 근처 설치장소: "같은 구/읍/면" 기준 6개
        $district = null;
        if ($address !== '') {
            preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $address, $m);
            $district = $m[0] ?? null;
        }

        $nearby = [];
        if ($district) {
            // 공백이 있는 컬럼명은 where()에 SQL 문자열을 직접 사용
            $db = \Config\Database::connect();
            $builder = $db->table($model->table);
            $escapedDistrict = $db->escapeLikeString($district);
            $escapedDistrictValue = $db->escape('%' . $escapedDistrict . '%');
            $nearbyResults = $builder
                ->groupStart()
                    ->where('`Street Address` LIKE ' . $escapedDistrictValue, null, false)
                    ->orWhere('`Land Lot Address` LIKE ' . $escapedDistrictValue, null, false)
                ->groupEnd()
                ->where('id !=', $id)
                ->limit(6)
                ->get()
                ->getResultArray();

            // Ensure all nearby items are arrays
            foreach ($nearbyResults as $n) {
                $item = is_object($n) ? (array)$n : $n;
                $item['url'] = site_url('installation/show/' . ($item['id'] ?? 0));
                $nearby[] = $item;
            }
        }
        
        return view('installation/detail', [
            'installation' => $installation,
            'latitude' => $lat,
            'longitude' => $lng,
            'nearby_installations' => $nearby,
            'district' => $district,
        ]);
    }

    /* =========================
     * 네이버 REST 지오코딩
     * ========================= */
    private function naverGeocode(string $query): ?array
    {
        // 환경변수가 있으면 사용, 없으면 기본값 사용 (서버에서 .env 없을 때 대비)
        $apiKeyId = getenv('NAVER_MAPS_API_KEY_ID') ?: 'c3hsihbnx3';
        $apiKey   = getenv('NAVER_MAPS_API_KEY') ?: 'iyBYir1BVYhy4bW5XWB1wHGfUNyOit2Pz4g413ce';

        if (!$apiKey) {
            return null;
        }

        $base = 'https://maps.apigw.ntruss.com/map-geocode/v2/geocode';
        $url  = $base . '?' . http_build_query([
            'query' => $query,
            'count' => 1,
            'page'  => 1,
            'language' => 'kor',
        ]);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 6,
            CURLOPT_CONNECTTIMEOUT => 4,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'x-ncp-apigw-api-key-id: ' . $apiKeyId,
                'x-ncp-apigw-api-key: ' . $apiKey,
            ],
        ]);

        $raw  = curl_exec($ch);
        $http = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_errno($ch);
        curl_close($ch);

        if ($err !== 0 || $http !== 200 || !$raw) {
            return null;
        }

        $json = json_decode($raw, true);
        if (!is_array($json)) return null;

        $addr = $json['addresses'][0] ?? null;
        if (!$addr) return null;

        // x=경도, y=위도
        if (!isset($addr['x'], $addr['y'])) return null;

        return [
            'lng' => (float)$addr['x'],
            'lat' => (float)$addr['y'],
        ];
    }

    /* =========================
     * 주소 정리 (지오코딩 실패 대비)
     * ========================= */
    private function cleanAddressForGeocode(string $address): string
    {
        $a = trim($address);
        $a = preg_replace('/\s*\([^)]*\)/u', '', $a);
        $a = preg_replace('/\s*,.*$/u', '', $a);
        $a = preg_replace('/\s+(지상|지하)\s*\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*호/u', '', $a);
        $a = preg_replace('/\s+[가-힣]+빌딩/u', '', $a);
        $a = preg_replace('/\s+/u', ' ', trim($a));
        return $a;
    }

    /* =========================
     * 주소 더 간단하게 정리 (3차 시도용)
     * ========================= */
    private function simplifyAddressForGeocode(string $address): string
    {
        $a = trim($address);
        $a = preg_replace('/\s*\([^)]*\)/u', '', $a);
        $a = preg_replace('/\s*,.*$/u', '', $a);
        $a = preg_replace('/\s+[가-힣]+(빌딩|아파트|타워|센터|플라자|마트|백화점)/u', '', $a);
        $a = preg_replace('/\s+(지상|지하|지하)\s*\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*호/u', '', $a);
        $a = preg_replace('/\s+\d+-\d+/u', '', $a);
        $a = preg_replace('/\s+/u', ' ', trim($a));
        return $a;
    }
}
