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

        // ✅ 지오코딩 (원문 주소 -> 실패하면 정리 주소로 1회 더)
        $lat = null;
        $lng = null;

        if ($address !== '') {
            $geo = $this->naverGeocode($address);

            if (!$geo) {
                $clean = $this->cleanAddressForGeocode($address);
                if ($clean !== $address) {
                    $geo = $this->naverGeocode($clean);
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
        $apiKeyId = getenv('NAVER_MAPS_API_KEY_ID'); // x-ncp-apigw-api-key-id
        $apiKey   = getenv('NAVER_MAPS_API_KEY');    // x-ncp-apigw-api-key

        if (!$apiKeyId || !$apiKey) {
            return null; // ✅ 키 없으면 좌표 못 나오는 게 정상
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
     * - 괄호 안 제거
     * - 쉼표 뒤 부가설명 제거
     * - 층/호/지상/지하 같은 토큰 제거(과하면 안 돼서 최소만)
     * ========================= */
    private function cleanAddressForGeocode(string $address): string
    {
        $a = trim($address);

        // 괄호 내용 제거: "(삼성동)" 같은 거
        $a = preg_replace('/\([^)]*\)/u', '', $a);

        // 쉼표 뒤는 부가정보인 경우가 많음: ", 삼예빌딩 지상2층" 등
        // 단, 도로명 주소에 쉼표가 없으면 영향 없음
        $a = preg_replace('/,.*$/u', '', $a);

        // "지상2층", "지하1층", "2층", "201호" 등 과한 정보 제거(가볍게)
        $a = preg_replace('/\s+(지상|지하)\s*\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*호/u', '', $a);

        // 공백 정리
        $a = preg_replace('/\s+/u', ' ', trim($a));

        return $a;
    }
}
