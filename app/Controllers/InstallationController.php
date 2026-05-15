<?php

namespace App\Controllers;

use App\Models\InstallationModel;
use App\Traits\NaverGeocodeTrait;

class InstallationController extends BaseController
{
    use NaverGeocodeTrait;

    public function index()
    {
        helper('url');
        
        $model = new InstallationModel();
        
        // Get search query from URL
        $query = trim((string)($this->request->getGet('search') ?? ''));
        $perPage = 12;

        // If search query exists, filter by Name or Address with pagination
        if ($query !== '') {
            // 공백이 있는 컬럼명은 where()에 SQL 문자열을 직접 사용
            $db = \Config\Database::connect();
            $builder = $db->table($model->table);
            $escapedQuery = $db->escapeLikeString($query);
            $escapedQueryValue = $db->escape('%' . $escapedQuery . '%');
            $builder->groupStart()
                ->where('`Installation Location Name` LIKE ' . $escapedQueryValue, null, false)
                ->orWhere('`Street Address` LIKE ' . $escapedQueryValue, null, false)
                ->orWhere('`Land Lot Address` LIKE ' . $escapedQueryValue, null, false)
                ->orWhere('`District Name` LIKE ' . $escapedQueryValue, null, false)
                ->orWhere('`Managing Institution Name` LIKE ' . $escapedQueryValue, null, false)
            ->groupEnd();
            
            // 페이징을 위해 Model의 paginate를 사용
            $total = $builder->countAllResults(false);
            $page = (int)($this->request->getGet('page') ?? 1);
            $offset = ($page - 1) * $perPage;
            
            $installations = $builder->orderBy('id', 'ASC')->limit($perPage, $offset)->get()->getResultArray();
            
            // Pager 설정
            $pager = \Config\Services::pager();
            $pager->store('installations', $page, $perPage, $total);
            $model->pager = $pager;
        } else {
            // If no search query, fetch all installations with pagination
            $installations = $model->orderBy('id', 'ASC')->paginate($perPage, 'installations');
        }

        // Ensure all items are arrays (not objects)
        if (!empty($installations)) {
            foreach ($installations as &$inst) {
                if (is_object($inst)) {
                    $inst = (array)$inst;
                }
            }
            unset($inst);
        }

        // Prepare data to send to the view
        $data = [
            'installations' => $installations,
            'pager' => $model->pager,
            'search' => $query
        ];

        // Return the view with data
        return view('installation/index', $data);
    }

    public function show($id)
    {
        helper('url');
        
        $model = new InstallationModel();
        $installation = $model->find($id);
        
        if (empty($installation)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Cannot find the installation data.");
        }
        
        // Ensure installation is an array
        if (is_object($installation)) {
            $installation = (array)$installation;
        }

        // ✅ 주소 우선순위: 도로명 -> 지번
        $road = trim((string)($installation['Street Address'] ?? ''));
        $lot = trim((string)($installation['Land Lot Address'] ?? ''));
        $address = $road !== '' ? $road : $lot;

        $dbLat = isset($installation['Latitude']) ? (float) $installation['Latitude'] : null;
        $dbLng = isset($installation['Longitude']) ? (float) $installation['Longitude'] : null;
        $coords = $this->latLngFromDbOrGeocode($address, $dbLat, $dbLng);
        if (($coords['lat'] === null || $coords['lng'] === null) && $lot !== '' && $lot !== $road) {
            $coords = $this->latLngFromDbOrGeocode($lot, null, null);
        }
        $lat = $coords['lat'];
        $lng = $coords['lng'];

        // ✅ 근처 설치장소: "같은 구/읍/면" 기준 6개
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

            // Ensure all nearby items are arrays
            foreach ($nearbyResults as $n) {
                $item = is_object($n) ? (array)$n : $n;
                $item['url'] = site_url('installation/show/' . ($item['id'] ?? 0));
                $nearby[] = $item;
            }
        }
        
        $blogPosts = $this->naverBlogSearch($installation['Installation Location Name'] ?? '');

        return view('installation/detail', [
            'installation' => $installation,
            'latitude' => $lat,
            'longitude' => $lng,
            'nearby_installations' => $nearby,
            'district' => $district,
            'blog_posts' => $blogPosts,
        ]);
    }
}
