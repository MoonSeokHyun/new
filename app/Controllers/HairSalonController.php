<?php namespace App\Controllers;

use App\Models\HairSalonModel;
use CodeIgniter\Controller;

class HairSalonController extends Controller
{
    /* =========================
     * 목록 (그대로 유지)
     * ========================= */
    public function index()
    {
        helper(['url']);

        $model  = new HairSalonModel();

        $search = trim((string)$this->request->getGet('search'));
        $page   = (int)($this->request->getGet('page') ?: 1);

        // ✅ 쿼리 빌드
        $builder = $model;

        if ($search !== '') {
            $builder = $builder->groupStart()
                ->like('business_name', $search)
                ->orLike('road_name_address', $search)
                ->orLike('full_address', $search)
                ->groupEnd();
        }

        // ✅ paginate 그룹명은 "salons"로 고정 (뷰 links도 똑같이!)
        $salons = $builder->paginate(12, 'salons');

        return view('hair/hairsalon_list', [
            'salons' => $salons,
            'pager'  => $model->pager,
            'search' => $search,
            'page'   => $page,
        ]);
    }
    /* =========================
     * 상세
     * ========================= */
    public function detail($id)
    {
        $model = new HairSalonModel();
        $salon = $model->find($id);

        if (!$salon) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('미용실을 찾을 수 없습니다.');
        }

        // ✅ 주소 우선순위: 도로명 -> 지번
        $road = trim((string)($salon['road_name_address'] ?? ''));
        $full = trim((string)($salon['full_address'] ?? ''));
        $address = $road !== '' ? $road : $full;

        // ✅ 지오코딩 (원문 주소 -> 실패하면 정리 주소로 여러 번 시도)
        $lat = null;
        $lng = null;

        if ($address !== '') {
            // 1차 시도: 원문 주소
            $geo = $this->naverGeocode($address);

            // 2차 시도: 기본 정리 주소
            if (!$geo) {
                $clean = $this->cleanAddressForGeocode($address);
                if ($clean !== $address && $clean !== '') {
                    $geo = $this->naverGeocode($clean);
                }
            }

            // 3차 시도: 더 간단하게 정리 (건물명, 층수 등 모두 제거)
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

        // ✅ 근처 미용실: "같은 구/읍/면" 기준 6개
        $district = null;
        if ($address !== '') {
            preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $address, $m);
            $district = $m[0] ?? null;
        }

        $nearby = [];
        if ($district) {
            $nearby = $model
                ->groupStart()
                    ->like('road_name_address', $district)
                    ->orLike('full_address', $district)
                ->groupEnd()
                ->where('id !=', $id)
                ->limit(6)
                ->findAll();

            foreach ($nearby as &$s) {
                $s['url'] = site_url('hairsalon/' . $s['id']);
            }
            unset($s);
        }

        return view('hair/hairsalon_detail', [
            'salon'         => $salon,
            'latitude'      => $lat,
            'longitude'     => $lng,
            'nearby_salons' => $nearby,
            // 디버깅용(원하면 뷰에서 표시 가능)
            'geocode_query' => $address,
        ]);
    }

    /* =========================
     * 네이버 REST 지오코딩
     * ========================= */
    private function naverGeocode(string $query): ?array
    {
        // 환경변수가 있으면 사용, 없으면 기본값 사용 (서버에서 .env 없을 때 대비)
        $apiKeyId = getenv('NAVER_MAPS_API_KEY_ID') ?: 'c3hsihbnx3'; // x-ncp-apigw-api-key-id
        $apiKey   = getenv('NAVER_MAPS_API_KEY') ?: 'YOUR_API_KEY_HERE'; // x-ncp-apigw-api-key

        // API Key는 필수이므로 없으면 실패
        if (!$apiKey || $apiKey === 'YOUR_API_KEY_HERE') {
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

        if ($err !== 0) {
            // CURL 에러 로깅 (개발 환경에서만)
            if (ENVIRONMENT === 'development') {
                log_message('debug', "Naver Geocode CURL Error: {$err} for query: {$query}");
            }
            return null;
        }

        if ($http !== 200) {
            // HTTP 에러 로깅 (개발 환경에서만)
            if (ENVIRONMENT === 'development') {
                log_message('debug', "Naver Geocode HTTP Error: {$http} for query: {$query}, response: " . substr($raw, 0, 200));
            }
            return null;
        }

        if (!$raw) {
            return null;
        }

        $json = json_decode($raw, true);
        if (!is_array($json)) {
            if (ENVIRONMENT === 'development') {
                log_message('debug', "Naver Geocode JSON decode failed for query: {$query}");
            }
            return null;
        }

        $addr = $json['addresses'][0] ?? null;
        if (!$addr) {
            if (ENVIRONMENT === 'development') {
                log_message('debug', "Naver Geocode no addresses found for query: {$query}, response: " . json_encode($json));
            }
            return null;
        }

        // x=경도, y=위도
        if (!isset($addr['x'], $addr['y'])) {
            if (ENVIRONMENT === 'development') {
                log_message('debug', "Naver Geocode missing coordinates for query: {$query}");
            }
            return null;
        }

        return [
            'lng' => (float)$addr['x'],
            'lat' => (float)$addr['y'],
        ];
    }

    /* =========================
     * 주소 정리 (지오코딩 실패 대비)
     * - 괄호 안 제거
     * - 쉼표 뒤 부가설명 제거
     * - 층/호/지상/지하 같은 토큰 제거(과하면 안 돼서 최소만)
     * ========================= */
    private function cleanAddressForGeocode(string $address): string
    {
        $a = trim($address);

        // 괄호 내용 제거: "(삼성동)" 같은 거
        $a = preg_replace('/\s*\([^)]*\)/u', '', $a);

        // 쉼표 뒤는 부가정보인 경우가 많음: ", 삼예빌딩 지상2층" 등
        // 단, 도로명 주소에 쉼표가 없으면 영향 없음
        $a = preg_replace('/\s*,.*$/u', '', $a);

        // "지상2층", "지하1층", "2층", "201호" 등 과한 정보 제거(가볍게)
        $a = preg_replace('/\s+(지상|지하)\s*\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*호/u', '', $a);
        
        // 건물명 제거 (예: "삼예빌딩" 같은 것)
        $a = preg_replace('/\s+[가-힣]+빌딩/u', '', $a);

        // 공백 정리
        $a = preg_replace('/\s+/u', ' ', trim($a));

        return $a;
    }

    /* =========================
     * 주소 더 간단하게 정리 (3차 시도용)
     * - 건물명, 상세 주소 등 모두 제거하고 기본 주소만 남김
     * ========================= */
    private function simplifyAddressForGeocode(string $address): string
    {
        $a = trim($address);

        // 괄호 내용 제거
        $a = preg_replace('/\s*\([^)]*\)/u', '', $a);

        // 쉼표 뒤 모든 내용 제거
        $a = preg_replace('/\s*,.*$/u', '', $a);

        // 건물명, 층수, 호수 등 모든 부가 정보 제거
        $a = preg_replace('/\s+[가-힣]+(빌딩|아파트|타워|센터|플라자|마트|백화점)/u', '', $a);
        $a = preg_replace('/\s+(지상|지하|지하)\s*\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*호/u', '', $a);
        $a = preg_replace('/\s+\d+-\d+/u', '', $a); // "123-45" 같은 번지 제거

        // 공백 정리
        $a = preg_replace('/\s+/u', ' ', trim($a));

        return $a;
    }
}
