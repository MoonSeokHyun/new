<?php

namespace App\Controllers;

use App\Models\LibraryInfoModel;
use App\Traits\NaverGeocodeTrait;

class LibraryInfoController extends BaseController
{
    use NaverGeocodeTrait;

    public function index()
    {
        $model = new LibraryInfoModel();
        $data['libraries'] = $model->findAll(12); // 최대 12개만 가져옴
        return view('LibraryInfo/index', $data);
    }

    public function detail($id)
    {
        $model = new LibraryInfoModel();
        $library = $model->find($id);
        if (!$library) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('도서관을 찾을 수 없습니다.');
        }

        // ✅ 주소
        $address = trim((string)($library['Address (Road Name)'] ?? ''));

        $dbLat = isset($library['Latitude']) ? (float) $library['Latitude'] : null;
        $dbLng = isset($library['Longitude']) ? (float) $library['Longitude'] : null;
        $coords = $this->latLngFromDbOrGeocode($address, $dbLat, $dbLng);
        $lat    = $coords['lat'];
        $lng    = $coords['lng'];

        // ✅ 근처 도서관
        $district = null;
        if ($address !== '') {
            preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $address, $m);
            $district = $m[0] ?? null;
        }

        $nearby = [];
        if ($district) {
            $nearby = $model
                ->where('`Address (Road Name)` LIKE', '%' . $district . '%')
                ->where('id !=', $id)
                ->limit(6)
                ->findAll();

            foreach ($nearby as &$n) {
                $n['url'] = site_url('library-info/detail/' . $n['id']);
            }
            unset($n);
        }

        $blogPosts = $this->naverBlogSearch($library['Library Name'] ?? '');

        return view('LibraryInfo/detail', [
            'library' => $library,
            'latitude' => $lat,
            'longitude' => $lng,
            'nearby_libraries' => $nearby,
            'district' => $district,
            'blog_posts' => $blogPosts,
        ]);
    }
}
