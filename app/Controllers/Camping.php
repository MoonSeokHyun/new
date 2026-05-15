<?php
namespace App\Controllers;

use App\Models\CampingModel;
use App\Traits\NaverGeocodeTrait;

class Camping extends BaseController
{
    use NaverGeocodeTrait;

    public function index()
    {
        $model = new CampingModel();
        // 최신 12개 레코드만 조회
        $data['campings'] = $model->orderBy('id', 'DESC')->findAll(12);
        return view('camping/index', $data);
    }
    

    public function detail($id = null)
    {
        $model = new CampingModel();
        $camping = $model->find($id);
        if (!$camping) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find camping with id '. $id);
        }

        // ✅ 객체를 배열로 변환 (필요한 경우)
        if (is_object($camping)) {
            $camping = (array)$camping;
        }

        // ✅ 주소 우선순위: 도로명 -> 지번
        $road = trim((string)($camping['RDNMADR_NM'] ?? ''));
        $lot = trim((string)($camping['LNM_ADDR'] ?? ''));
        $address = $road !== '' ? $road : $lot;

        $dbLat = isset($camping['LC_LA']) ? (float) $camping['LC_LA'] : null;
        $dbLng = isset($camping['LC_LO']) ? (float) $camping['LC_LO'] : null;
        $coords = $this->latLngFromDbOrGeocode($address, $dbLat, $dbLng);
        if (($coords['lat'] === null || $coords['lng'] === null) && $lot !== '' && $lot !== $road) {
            $coords = $this->latLngFromDbOrGeocode($lot, null, null);
        }
        $lat = $coords['lat'];
        $lng = $coords['lng'];

        // ✅ 근처 캠핑장: "같은 구/읍/면" 기준 6개
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
                $n['url'] = site_url('camping/' . ($n['id'] ?? $n->id ?? ''));
            }
            unset($n);
        }

        $blogPosts = $this->naverBlogSearch($camping['FCLTY_NM'] ?? '');

        return view('camping/detail', [
            'camping' => $camping,
            'latitude' => $lat,
            'longitude' => $lng,
            'nearby_campings' => $nearby,
            'blog_posts' => $blogPosts,
            'district' => $district,
        ]);
    }
}
