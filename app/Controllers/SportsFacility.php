<?php
namespace App\Controllers;

use App\Models\SportsFacilityModel;
use App\Traits\NaverGeocodeTrait;
use CodeIgniter\Exceptions\PageNotFoundException;

class SportsFacility extends BaseController
{
    use NaverGeocodeTrait;

    public function index()
    {
        $model = new SportsFacilityModel();
        // 최신 12개
        $data['facilities'] = $model
            ->orderBy('id', 'DESC')
            ->findAll(12);
        return view('sports_facilities/index', $data);
    }

    public function detail($id = null)
    {
        $model = new SportsFacilityModel();
        $facility = $model->find($id);

        if (!$facility) {
            throw new PageNotFoundException("존재하지 않는 체육시설입니다: {$id}");
        }

        // ✅ 객체를 배열로 변환 (필요한 경우)
        if (is_object($facility)) {
            $facility = (array)$facility;
        }

        // ✅ 주소
        $address = trim((string)($facility['RDNMADR_NM'] ?? ''));

        $dbLat = isset($facility['FCLTY_LA']) ? (float) $facility['FCLTY_LA'] : null;
        $dbLng = isset($facility['FCLTY_LO']) ? (float) $facility['FCLTY_LO'] : null;
        $coords = $this->latLngFromDbOrGeocode($address, $dbLat, $dbLng);
        $lat    = $coords['lat'];
        $lng    = $coords['lng'];

        // ✅ 근처 체육시설
        $district = null;
        if ($address !== '') {
            preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $address, $m);
            $district = $m[0] ?? null;
        }

        $nearby = [];
        if ($district) {
            $nearby = $model
                ->like('RDNMADR_NM', $district)
                ->where('id !=', $id)
                ->limit(6)
                ->findAll();

            foreach ($nearby as &$n) {
                // 객체를 배열로 변환
                if (is_object($n)) {
                    $n = (array)$n;
                }
                $n['url'] = site_url('sports-facility/detail/' . ($n['id'] ?? $n->id ?? ''));
            }
            unset($n);
        }

        $blogPosts = $this->naverBlogSearch($facility['FCLTY_NM'] ?? '');

        return view('sports_facilities/detail', [
            'facility' => $facility,
            'latitude' => $lat,
            'longitude' => $lng,
            'nearby_facilities' => $nearby,
            'district' => $district,
            'blog_posts' => $blogPosts,
        ]);
    }
}
