<?php

namespace App\Controllers;

use App\Models\AnimalHospitalModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AnimalHospitalController extends BaseController
{
    public function index()
    {
        helper('url');

        $model  = new AnimalHospitalModel();
        $search = trim((string)$this->request->getGet('search'));

        $builder = $model;

        if ($search !== '') {
            $builder = $builder->groupStart()
                ->like('b_name', $search)
                ->orLike('new_address', $search)
                ->orLike('old_address', $search)
                ->groupEnd();
        }

        // ✅ paginate group name은 'hospitals'로 통일
        $hospitals = $builder->orderBy('id', 'ASC')->paginate(12, 'hospitals');

        return view('animal_hospital/index', [
            'hospitals' => $hospitals,
            'pager'     => $model->pager,
            'search'    => $search,
        ]);
    }

    public function detail($id)
    {
        helper('url');

        $model    = new AnimalHospitalModel();
        $hospital = $model->find($id);

        if (!$hospital) {
            throw new PageNotFoundException('동물병원을 찾을 수 없습니다.');
        }

        // ✅ 주소 우선순위: 도로명 -> 지번
        $address = trim((string)($hospital['new_address'] ?? ''));
        if ($address === '') $address = trim((string)($hospital['old_address'] ?? ''));

        // ✅ 구/읍/면 추출
        $district = $this->extractDistrict($address);

        // ✅ 1) DB x/y 우선 사용 (x=경도, y=위도) + 범위 체크
        $lat = null;
        $lng = null;

        $dbX = $hospital['x_value'] ?? null; // 경도일 가능성
        $dbY = $hospital['y_value'] ?? null; // 위도일 가능성

        if (is_numeric($dbX) && is_numeric($dbY)) {
            $candLng = (float)$dbX;
            $candLat = (float)$dbY;

            // WGS84 정상 범위면 그대로 사용
            if ($candLat >= -90 && $candLat <= 90 && $candLng >= -180 && $candLng <= 180) {
                $lat = $candLat;
                $lng = $candLng;
            }
        }

        // ✅ 2) DB좌표가 이상하면 주소 지오코딩으로 보정
        if (($lat === null || $lng === null) && $address !== '') {
            $geo = $this->naverGeocodeCached($address);
            if ($geo) {
                $lat = $geo['lat'];
                $lng = $geo['lng'];
            }
        }

        // ✅ 근처 병원: 같은 구/읍/면 텍스트 기준 6개
        $nearby = [];
        if ($district) {
            $nearby = $model
                ->groupStart()
                    ->like('new_address', $district)
                    ->orLike('old_address', $district)
                ->groupEnd()
                ->where('id !=', (int)$id)
                ->orderBy('id', 'ASC')
                ->limit(6)
                ->findAll();

            foreach ($nearby as &$n) {
                $n['url'] = site_url('animal-hospital/detail/' . $n['id']);
            }
            unset($n);
        }

        return view('animal_hospital/detail', [
            'hospital'         => $hospital,
            'latitude'         => $lat,
            'longitude'        => $lng,
            'district'         => $district,
            'nearby_hospitals' => $nearby,
        ]);
    }

    // -----------------------------
    // Helpers
    // -----------------------------

    private function extractDistrict(string $address): ?string
    {
        if ($address === '') return null;
        preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $address, $m);
        return $m[0] ?? null;
    }

    /**
     * ✅ 캐시 키 ':' 때문에 터지던 문제 해결:
     * - CI 캐시 키는 {}()/\@: 같은 예약문자 금지
     * - 그래서 geocode_ + sha1() 형태로 저장
     */
    private function naverGeocodeCached(string $query): ?array
    {
        $query = trim($query);
        if ($query === '') return null;

        $key = 'geocode_' . sha1($query); // ✅ 안전

        try {
            $cache = cache();
            $cached = $cache->get($key);
            if (is_array($cached) && isset($cached['lat'], $cached['lng'])) {
                return $cached;
            }

            $geo = $this->naverGeocode($query);
            if ($geo) {
                // 30일 캐시
                $cache->save($key, $geo, 60 * 60 * 24 * 30);
            }
            return $geo;
        } catch (\Throwable $e) {
            // 캐시 설정이 없거나 파일권한 이슈여도 지오코딩은 동작하게
            return $this->naverGeocode($query);
        }
    }

    /**
     * 네이버 Geocoding REST
     * ENV:
     * - NAVER_MAPS_API_KEY_ID
     * - NAVER_MAPS_API_KEY
     */
    private function naverGeocode(string $query): ?array
    {
        // 환경변수가 있으면 사용, 없으면 기본값 사용 (서버에서 .env 없을 때 대비)
        $apiKeyId = getenv('NAVER_MAPS_API_KEY_ID') ?: 'c3hsihbnx3';
        $apiKey   = getenv('NAVER_MAPS_API_KEY') ?: 'iyBYir1BVYhy4bW5XWB1wHGfUNyOit2Pz4g413ce';

        if (!$apiKey) return null;

        $url = 'https://maps.apigw.ntruss.com/map-geocode/v2/geocode?' . http_build_query([
            'query' => $query,
            'count' => 1,
        ]);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 6,
            CURLOPT_HTTPHEADER     => [
                'Accept: application/json',
                'x-ncp-apigw-api-key-id: ' . $apiKeyId,
                'x-ncp-apigw-api-key: ' . $apiKey,
            ],
        ]);

        $raw  = curl_exec($ch);
        $http = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$raw || $http !== 200) return null;

        $json = json_decode($raw, true);
        if (!is_array($json)) return null;
        if (($json['status'] ?? '') !== 'OK') return null;

        $a = $json['addresses'][0] ?? null;
        if (!is_array($a)) return null;

        $x = isset($a['x']) ? (float)$a['x'] : null; // 경도
        $y = isset($a['y']) ? (float)$a['y'] : null; // 위도
        if ($x === null || $y === null) return null;

        return ['lat' => $y, 'lng' => $x];
    }
}
