<?php namespace App\Controllers;

use App\Models\HairSalonModel;
use CodeIgniter\Controller;

class HairSalonController extends Controller
{
    public function index()
    {
        $model = new HairSalonModel();

        $search = $this->request->getVar('search');
        $page   = $this->request->getVar('page') ?: 1;

        if ($search) {
            $salons = $model
                ->groupStart()
                    ->like('business_name', $search)
                    ->orLike('road_name_address', $search)
                ->groupEnd()
                ->paginate(12, 'salons');
        } else {
            $salons = $model->paginate(12, 'salons');
        }

        return view('hair/hairsalon_list', [
            'salons' => $salons,
            'pager'  => $model->pager,
            'search' => $search,
        ]);
    }

    public function detail($id)
    {
        $model = new HairSalonModel();
        $salon = $model->find($id);

        if (!$salon) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('미용실을 찾을 수 없습니다.');
        }

        // -------------------------
        // ✅ 좌표 처리 (중요)
        // -------------------------
        $lat = null;
        $lng = null;

        // 1️⃣ DB 좌표 우선 사용 (이미 WGS84라고 가정)
        if (
            is_numeric($salon['y_coordinate'] ?? null) &&
            is_numeric($salon['x_coordinate'] ?? null)
        ) {
            $lat = (float)$salon['y_coordinate'];
            $lng = (float)$salon['x_coordinate'];
        }

        // -------------------------
        // 2️⃣ DB 좌표 없으면 네이버 REST 지오코딩
        // -------------------------
        if (!$lat || !$lng) {
            $query = trim(
                $salon['road_name_address']
                ?: $salon['full_address']
                ?: ''
            );

            if ($query) {
                $geo = $this->naverGeocode($query);
                if ($geo) {
                    $lat = $geo['lat'];
                    $lng = $geo['lng'];
                }
            }
        }

        // -------------------------
        // 3️⃣ 근처 미용실 (좌표 있을 때만)
        // -------------------------
        $nearby = [];
        if ($lat && $lng) {
            $range = 0.01; // 약 1km
            $nearby = $model
                ->where('id !=', $id)
                ->where('y_coordinate >=', $lat - $range)
                ->where('y_coordinate <=', $lat + $range)
                ->where('x_coordinate >=', $lng - $range)
                ->where('x_coordinate <=', $lng + $range)
                ->limit(6)
                ->findAll();

            // URL 보강
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

    /**
     * ✅ 네이버 REST 지오코딩
     */
    private function naverGeocode(string $query): ?array
    {
        $keyId  = getenv('NAVER_MAPS_API_KEY_ID');
        $secret = getenv('NAVER_MAPS_API_KEY');

        if (!$keyId || !$secret) return null;

        $url = 'https://maps.apigw.ntruss.com/map-geocode/v2/geocode?'
             . http_build_query([
                 'query' => $query,
                 'count' => 1,
             ]);

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
