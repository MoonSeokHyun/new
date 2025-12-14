<?php namespace App\Controllers;

use App\Models\HairSalonModel;
use CodeIgniter\Controller;

class HairSalonController extends Controller
{
    public function index()
    {
        $model  = new HairSalonModel();

        $search   = trim((string)$this->request->getVar('search'));
        $page     = (int)($this->request->getVar('page') ?: 1);

        // ✅ 허브 필터 파라미터(신규)
        $region   = trim((string)$this->request->getVar('region'));   // 예: 경기도
        $sigungu  = trim((string)$this->request->getVar('sigungu'));  // 예: 성남시
        $district = trim((string)$this->request->getVar('district')); // 예: 분당구
        $dong     = trim((string)$this->request->getVar('dong'));     // 예: 정자동

        // ✅ 쿼리 빌드
        $builder = $model;

        // 검색어
        if ($search !== '') {
            $builder = $builder->groupStart()
                ->like('business_name', $search)
                ->orLike('road_name_address', $search)
                ->orLike('full_address', $search)
                ->groupEnd();
        }

        // 허브 필터(주소 텍스트 기반)
        // - full_address / road_name_address 둘 다 섞여있을 수 있으니 OR로 안전하게 잡음
        if ($region !== '') {
            $builder = $builder->groupStart()
                ->like('full_address', $region, 'after')
                ->orLike('road_name_address', $region, 'after')
                ->groupEnd();
        }

        if ($sigungu !== '') {
            $builder = $builder->groupStart()
                ->like('full_address', $sigungu)
                ->orLike('road_name_address', $sigungu)
                ->groupEnd();
        }

        if ($district !== '') {
            $builder = $builder->groupStart()
                ->like('full_address', $district)
                ->orLike('road_name_address', $district)
                ->groupEnd();
        }

        if ($dong !== '') {
            $builder = $builder->groupStart()
                ->like('full_address', $dong)
                ->orLike('road_name_address', $dong)
                ->groupEnd();
        }

        $salons = $builder->paginate(12, 'salons');

        return view('hair/hairsalon_list', [
            'salons'   => $salons,
            'pager'    => $model->pager,
            'search'   => $search,
            'region'   => $region,
            'sigungu'  => $sigungu,
            'district' => $district,
            'dong'     => $dong,
        ]);
    }

    public function detail($id)
    {
        $model = new HairSalonModel();
        $salon = $model->find($id);

        if (!$salon) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('미용실을 찾을 수 없습니다.');
        }

        // ✅ 좌표: DB값이 WGS84(위도/경도)라고 가정하고 1순위 사용
        $lat = null;
        $lng = null;

        if (is_numeric($salon['y_coordinate'] ?? null) && is_numeric($salon['x_coordinate'] ?? null)) {
            $lat = (float)$salon['y_coordinate'];
            $lng = (float)$salon['x_coordinate'];
        }

        // ✅ 좌표 없으면 네이버 REST 지오코딩(서버)
        if (!$lat || !$lng) {
            $query = trim((string)($salon['road_name_address'] ?: $salon['full_address'] ?: ''));
            if ($query) {
                $geo = $this->naverGeocode($query);
                if ($geo) {
                    $lat = $geo['lat'];
                    $lng = $geo['lng'];
                }
            }
        }

        // ✅ 근처 미용실(좌표 있을 때만)
        $nearby = [];
        if ($lat && $lng) {
            $range = 0.01; // 대략 1km
            $nearby = $model
                ->where('id !=', $id)
                ->where('y_coordinate IS NOT NULL', null, false)
                ->where('x_coordinate IS NOT NULL', null, false)
                ->where('y_coordinate >=', $lat - $range)
                ->where('y_coordinate <=', $lat + $range)
                ->where('x_coordinate >=', $lng - $range)
                ->where('x_coordinate <=', $lng + $range)
                ->limit(6)
                ->findAll();

            foreach ($nearby as &$n) {
                $n['url'] = site_url('hairsalon/' . $n['id']);
            }
        }

        return view('hair/hairsalon_detail', [
            'salon'         => $salon,
            'latitude'      => $lat,
            'longitude'     => $lng,
            'nearby_salons' => $nearby,
        ]);
    }

    private function naverGeocode(string $query): ?array
    {
        $keyId  = getenv('NAVER_MAPS_API_KEY_ID');
        $secret = getenv('NAVER_MAPS_API_KEY');

        if (!$keyId || !$secret) return null;

        $url = 'https://maps.apigw.ntruss.com/map-geocode/v2/geocode?'
            . http_build_query(['query' => $query, 'count' => 1]);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'x-ncp-apigw-api-key-id: ' . $keyId,
                'x-ncp-apigw-api-key: ' . $secret,
            ],
        ]);

        $res = curl_exec($ch);
        curl_close($ch);

        if (!$res) return null;

        $json = json_decode($res, true);
        $addr = $json['addresses'][0] ?? null;
        if (!$addr) return null;

        return [
            'lat' => (float)$addr['y'],
            'lng' => (float)$addr['x'],
        ];
    }
}
