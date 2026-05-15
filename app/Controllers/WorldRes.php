<?php
namespace App\Controllers;

use App\Models\WorldResModel;
use App\Traits\NaverGeocodeTrait;

class WorldRes extends BaseController
{
    use NaverGeocodeTrait;

    public function index()
    {
        $model = new WorldResModel();
        // 최신 12개 레코드만 조회
        $data['restaurants'] = $model
            ->orderBy('id', 'DESC')  // 최신순으로 가져오려면, 필요 없으면 제거하세요
            ->findAll(12);
        return view('world_res/index', $data);
    }
    
    public function detail($id = null)
    {
        $model = new WorldResModel();
        $restaurant = $model->find($id);
        if (!$restaurant) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find restaurant with id '. $id);
        }

        // ✅ 객체를 배열로 변환 (필요한 경우)
        if (is_object($restaurant)) {
            $restaurant = (array)$restaurant;
        }

        // ✅ 주소 우선순위: 도로명 -> 지번
        $road = trim((string)($restaurant['RDNMADR_NM'] ?? ''));
        $lot = trim((string)($restaurant['LNM_ADDR'] ?? ''));
        $address = $road !== '' ? $road : $lot;

        $dbLat = isset($restaurant['LC_LA']) ? (float) $restaurant['LC_LA'] : null;
        $dbLng = isset($restaurant['LC_LO']) ? (float) $restaurant['LC_LO'] : null;
        $coords = $this->latLngFromDbOrGeocode($address, $dbLat, $dbLng);
        if (($coords['lat'] === null || $coords['lng'] === null) && $lot !== '' && $lot !== $road) {
            $coords = $this->latLngFromDbOrGeocode($lot, null, null);
        }
        $lat = $coords['lat'];
        $lng = $coords['lng'];

        // ✅ 근처 음식점
        $district = null;
        if ($address !== '') {
            preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $address, $m);
            $district = $m[0] ?? null;
        }

        $nearby = [];
        if ($district) {
            $nearby = $model
                ->groupStart()
                    ->like('RDNMADR_NM', $district)
                    ->orLike('LNM_ADDR', $district)
                ->groupEnd()
                ->where('id !=', $id)
                ->limit(6)
                ->findAll();

            foreach ($nearby as &$n) {
                // 객체를 배열로 변환
                if (is_object($n)) {
                    $n = (array)$n;
                }
                $n['url'] = site_url('world-res/detail/' . ($n['id'] ?? $n->id ?? ''));
            }
            unset($n);
        }

        $blogPosts = $this->naverBlogSearch($restaurant['FCLTY_NM'] ?? '', ' 맛집');

        return view('world_res/detail', [
            'restaurant'          => $restaurant,
            'latitude'            => $lat,
            'longitude'           => $lng,
            'nearby_restaurants'  => $nearby,
            'district'            => $district,
            'blog_posts'          => $blogPosts,
        ]);
    }

}
