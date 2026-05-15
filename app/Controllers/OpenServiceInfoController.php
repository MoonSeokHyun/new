<?php
namespace App\Controllers;
use App\Models\OpenServiceInfoModel;
use App\Traits\NaverGeocodeTrait;

class OpenServiceInfoController extends BaseController
{
    use NaverGeocodeTrait;

    public function index()
    {
        $model = new OpenServiceInfoModel();
        $data['shops'] = $model->findAll(12);
        return view('open_service_info/index', $data);
    }

    public function detail($id = null)
    {
        $model = new OpenServiceInfoModel();
        $shop = $model->find($id);

        if (empty($shop)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find shop with id ' . $id);
        }

        // ✅ 주소 우선순위: 도로명 -> 전체주소
        $road = trim((string)($shop['RoadAddress'] ?? ''));
        $full = trim((string)($shop['FullAddress'] ?? ''));
        $address = $road !== '' ? $road : $full;

        // DB: CoordinateY=위도, CoordinateX=경도
        $dbLat = isset($shop['CoordinateY']) ? (float) $shop['CoordinateY'] : null;
        $dbLng = isset($shop['CoordinateX']) ? (float) $shop['CoordinateX'] : null;
        $coords = $this->latLngFromDbOrGeocode($address, $dbLat, $dbLng);
        if (($coords['lat'] === null || $coords['lng'] === null) && $full !== '' && $full !== $road) {
            $coords = $this->latLngFromDbOrGeocode($full, null, null);
        }
        $lat = $coords['lat'];
        $lng = $coords['lng'];

        // ✅ 근처 안경점
        $district = null;
        if ($address !== '') {
            preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $address, $m);
            $district = $m[0] ?? null;
        }

        $nearby = [];
        if ($district) {
            $nearby = $model
                ->groupStart()
                    ->like('RoadAddress', $district)
                    ->orLike('FullAddress', $district)
                ->groupEnd()
                ->where('id !=', $id)
                ->limit(6)
                ->findAll();

            foreach ($nearby as &$n) {
                $n['url'] = site_url('open-service-info/detail/' . $n['id']);
            }
            unset($n);
        }

        $blogPosts = $this->naverBlogSearch($shop['BusinessName'] ?? '');

        return view('open_service_info/detail', [
            'shop' => $shop,
            'latitude' => $lat,
            'longitude' => $lng,
            'nearby_shops' => $nearby,
            'district' => $district,
            'blog_posts' => $blogPosts,
        ]);
    }
}
