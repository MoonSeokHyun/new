<?php namespace App\Controllers;

use App\Models\HairSalonModel;
use App\Traits\CoupangNaverBannerTrait;
use App\Traits\NaverGeocodeTrait;

class HairSalonController extends BaseController
{
    use CoupangNaverBannerTrait;
    use NaverGeocodeTrait;

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

        $coords = $this->latLngFromDbOrGeocode($address, null, null);
        if (($coords['lat'] === null || $coords['lng'] === null) && $full !== '' && $full !== $road) {
            $coords = $this->latLngFromDbOrGeocode($full, null, null);
        }
        $lat = $coords['lat'];
        $lng = $coords['lng'];

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
                $s['url'] = site_url('hairsalon/detail/' . $s['id']);
            }
            unset($s);
        }

        $blogPosts = $this->naverBlogSearch($salon['business_name'] ?? '');

        $coupang = $this->resolveCoupangNaverSwipeBanner();

        return view('hair/hairsalon_detail', [
            'salon'         => $salon,
            'latitude'      => $lat,
            'longitude'     => $lng,
            'nearby_salons' => $nearby,
            'geocode_query' => $address,
            'blog_posts'    => $blogPosts,
            'coupang_first_naver'    => $coupang['coupang_first_naver'],
            'coupang_swipe_distance'   => $coupang['coupang_swipe_distance'],
        ]);
    }
}
