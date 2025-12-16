<?php

namespace App\Controllers;

use App\Models\ClothingCollectionBinModel;
use CodeIgniter\Controller;

class ClothingCollectionBinController extends Controller
{
    // 인덱스 페이지
    public function index()
    {
        $model = new ClothingCollectionBinModel();

        // 검색 기능 (선택적)
        $query = $this->request->getVar('search');
        
        // 검색 시, 해당 query로 데이터 검색
        if ($query) {
            $bins = $model->search($query); // search 메서드를 통해 데이터 검색
        } else {
            // 페이징 처리
            $page = $this->request->getVar('page') ?? 1; // 현재 페이지
            $perPage = 12; // 한 페이지에 표시할 항목 수
            $offset = ($page - 1) * $perPage; // 페이지에 맞는 offset 계산

            // 해당 페이지에 맞는 수거함 데이터 가져오기
            $bins = $model->getAllBins($perPage, $offset);
        }

        // 전체 데이터 개수 (페이징을 위해)
        $totalBins = $model->countAllBins();
        
        // Pager 설정
        $pager = \Config\Services::pager();

        // 인덱스 페이지에 필요한 데이터 뷰로 전달
        return view('clothing_collection_bin/index', [
            'bins' => $bins,    // 수거함 목록
            'pager' => $pager,  // 페이징
            'totalBins' => $totalBins,  // 전체 데이터 개수
            'search' => $query, // 검색어 전달
        ]);
    }

    // 디테일 페이지
    public function show($id)
    {
        $model = new ClothingCollectionBinModel();
        
        // ID로 해당 수거함 데이터를 찾기
        $bin = $model->find($id);

        // 수거함이 없다면 404 에러 발생
        if (!$bin) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Collection Bin with ID $id not found");
        }

        // ✅ 주소 우선순위: 도로명 -> 지번
        $road = trim((string)($bin['Street Address'] ?? ''));
        $lot = trim((string)($bin['Land Lot Address'] ?? ''));
        $address = $road !== '' ? $road : $lot;

        // ✅ 지오코딩 (원문 주소 -> 실패하면 정리 주소로 여러 번 시도)
        $lat = null;
        $lng = null;

        // DB에 좌표가 있으면 우선 사용
        if (isset($bin['Latitude']) && isset($bin['Longitude'])) {
            $dbLat = (float)($bin['Latitude'] ?? 0);
            $dbLng = (float)($bin['Longitude'] ?? 0);
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

        // ✅ 근처 수거함: "같은 구/읍/면" 기준 6개
        $district = null;
        if ($address !== '') {
            preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $address, $m);
            $district = $m[0] ?? null;
        }

        $nearby = [];
        if ($district) {
            $nearby = $model
                ->groupStart()
                    ->like('`Street Address`', $district)
                    ->orLike('`Land Lot Address`', $district)
                ->groupEnd()
                ->where('id !=', $id)
                ->limit(6)
                ->findAll();

            foreach ($nearby as &$n) {
                $n['url'] = site_url('clothing-collection-bin/show/' . $n['id']);
            }
            unset($n);
        }

        return view('clothing_collection_bin/detail', [
            'bin' => $bin,
            'latitude' => $lat,
            'longitude' => $lng,
            'nearby_bins' => $nearby,
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
