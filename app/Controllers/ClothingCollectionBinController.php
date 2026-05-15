<?php

namespace App\Controllers;

use App\Models\ClothingCollectionBinModel;
use App\Traits\NaverGeocodeTrait;

class ClothingCollectionBinController extends BaseController
{
    use NaverGeocodeTrait;

    // 인덱스 페이지
    public function index()
    {
        helper('url');
        
        $model = new ClothingCollectionBinModel();
        $query = trim((string)($this->request->getGet('search') ?? ''));
        $perPage = 12;

        // 검색 시에도 페이징 지원
        if ($query !== '') {
            // 공백이 있는 컬럼명은 where()에 SQL 문자열을 직접 사용
            $db = \Config\Database::connect();
            $builder = $db->table($model->table);
            $escapedQuery = $db->escapeLikeString($query);
            $escapedQueryValue = $db->escape('%' . $escapedQuery . '%');
            $builder->groupStart()
                ->where('`Clothing Collection Bin Location Name` LIKE ' . $escapedQueryValue, null, false)
                ->orWhere('`Street Address` LIKE ' . $escapedQueryValue, null, false)
                ->orWhere('`Land Lot Address` LIKE ' . $escapedQueryValue, null, false)
                ->orWhere('`District Name` LIKE ' . $escapedQueryValue, null, false)
                ->orWhere('`Managing Institution Name` LIKE ' . $escapedQueryValue, null, false)
            ->groupEnd();
            
            // 페이징을 위해 Model의 paginate를 사용
            $total = $builder->countAllResults(false);
            $page = (int)($this->request->getGet('page') ?? 1);
            $offset = ($page - 1) * $perPage;
            
            $bins = $builder->orderBy('id', 'ASC')->limit($perPage, $offset)->get()->getResultArray();
            
            // Pager 설정
            $pager = \Config\Services::pager();
            $pager->store('bins', $page, $perPage, $total);
            $model->pager = $pager;
        } else {
            $bins = $model->orderBy('id', 'ASC')->paginate($perPage, 'bins');
        }

        // Ensure all items are arrays
        if (!empty($bins)) {
            foreach ($bins as &$bin) {
                if (is_object($bin)) {
                    $bin = (array)$bin;
                }
            }
            unset($bin);
        }

        return view('clothing_collection_bin/index', [
            'bins' => $bins,
            'pager' => $model->pager,
            'search' => $query,
        ]);
    }

    // 디테일 페이지
    public function show($id)
    {
        $model = new ClothingCollectionBinModel();
        
        // ID로 해당 수거함 데이터를 찾기
        $bin = $model->find($id);

        // 수거함이 없다면 404 에러 발생
        if (!$bin) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Collection Bin with ID $id not found");
        }
        
        // Ensure bin is an array
        if (is_object($bin)) {
            $bin = (array)$bin;
        }

        // ✅ 주소 우선순위: 도로명 -> 지번
        $road = trim((string)($bin['Street Address'] ?? ''));
        $lot = trim((string)($bin['Land Lot Address'] ?? ''));
        $address = $road !== '' ? $road : $lot;

        $dbLat = isset($bin['Latitude']) ? (float) $bin['Latitude'] : null;
        $dbLng = isset($bin['Longitude']) ? (float) $bin['Longitude'] : null;
        $coords = $this->latLngFromDbOrGeocode($address, $dbLat, $dbLng);
        if (($coords['lat'] === null || $coords['lng'] === null) && $lot !== '' && $lot !== $road) {
            $coords = $this->latLngFromDbOrGeocode($lot, null, null);
        }
        $lat = $coords['lat'];
        $lng = $coords['lng'];

        // ✅ 근처 수거함: "같은 구/읍/면" 기준 6개
        $district = null;
        if ($address !== '') {
            preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $address, $m);
            $district = $m[0] ?? null;
        }

        $nearby = [];
        if ($district) {
            // 공백이 있는 컬럼명은 where()에 SQL 문자열을 직접 사용
            $db = \Config\Database::connect();
            $builder = $db->table($model->table);
            $escapedDistrict = $db->escapeLikeString($district);
            $escapedDistrictValue = $db->escape('%' . $escapedDistrict . '%');
            $nearbyResults = $builder
                ->groupStart()
                    ->where('`Street Address` LIKE ' . $escapedDistrictValue, null, false)
                    ->orWhere('`Land Lot Address` LIKE ' . $escapedDistrictValue, null, false)
                ->groupEnd()
                ->where('id !=', $id)
                ->limit(6)
                ->get()
                ->getResultArray();

            foreach ($nearbyResults as $n) {
                $item = is_object($n) ? (array)$n : $n;
                $item['url'] = site_url('clothing-collection-bin/show/' . ($item['id'] ?? 0));
                $nearby[] = $item;
            }
        }

        $blogPosts = $this->naverBlogSearch($bin['Clothing Collection Bin Location Name'] ?? '');

        return view('clothing_collection_bin/detail', [
            'bin' => $bin,
            'latitude' => $lat,
            'longitude' => $lng,
            'nearby_bins' => $nearby,
            'district' => $district,
            'blog_posts' => $blogPosts,
        ]);
    }
}
