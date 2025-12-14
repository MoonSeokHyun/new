<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\HairSalonModel;
use App\Models\InstallationModel;
use App\Models\ClothingCollectionBinModel;
use App\Models\SeminarRoomModel;
use App\Models\CampingModel;
use App\Models\WorldResModel;
use App\Models\SportsFacilityModel;
use App\Models\LibraryInfoModel;
use App\Models\OpenServiceInfoModel;
use App\Models\AnimalHospitalModel;

class SitemapController extends Controller
{
    /**
     * 네이버/구글 공통 안전값:
     * - 한 sitemap urlset에 URL은 최대 50,000이지만
     * - 파일 크기/서버부하 고려해서 10,000 유지
     */
    protected int $perPage = 10000;

    /**
     * 섹션 정의
     * - count: 전체 개수 반환 메서드
     * - fetch: (limit, offset) 인자를 받는 메서드 권장
     * - route: 상세 라우트 prefix
     */
    protected array $sections = [
        'hairSalonPage' => [
            'model' => HairSalonModel::class,
            'count' => 'countAllSalons',
            'fetch' => 'getHairSalons',
            'route' => 'hairsalon/detail',
            'priority' => '0.8',
        ],
        'installationPage' => [
            'model' => InstallationModel::class,
            'count' => 'countAllResults',
            'fetch' => 'findAll',
            'route' => 'installation/show',
            'priority' => '0.6',
        ],
        'clothingCollectionBinPage' => [
            'model' => ClothingCollectionBinModel::class,
            'count' => 'countAllBins',
            'fetch' => 'getAllBins',
            'route' => 'clothingcollectionbin/show',
            'priority' => '0.6',
        ],
        'seminarRoomPage' => [
            'model' => SeminarRoomModel::class,
            'count' => 'countAllResults',
            'fetch' => 'findAll',
            'route' => 'seminar_rooms',
            'priority' => '0.5',
        ],
        'campingPage' => [
            'model' => CampingModel::class,
            'count' => 'countAllCampings',
            'fetch' => 'getCampings',
            'route' => 'camping',
            'priority' => '0.6',
        ],
        'worldResPage' => [
            'model' => WorldResModel::class,
            'count' => 'countAllRestaurants',
            'fetch' => 'getRestaurants',
            'route' => 'world_res',
            'priority' => '0.6',
        ],
        'sportsFacilitiesPage' => [
            'model' => SportsFacilityModel::class,
            'count' => 'countAllFacilities',
            'fetch' => 'getFacilities',
            'route' => 'sports_facilities',
            'priority' => '0.6',
        ],
        'libraryInfoPage' => [
            'model' => LibraryInfoModel::class,
            'count' => 'countAllResults',
            'fetch' => 'findAll',
            'route' => 'LibraryInfo/detail',
            'priority' => '0.5',
        ],
        'shopsPage' => [
            'model' => OpenServiceInfoModel::class,
            'count' => 'countAll',
            'fetch' => 'findAll',
            'route' => 'shops',
            'priority' => '0.5',
        ],
        'animalHospitalPage' => [
            'model' => AnimalHospitalModel::class,
            'count' => 'countAllHospitals',
            'fetch' => 'getHospitalsPagination',
            'route' => 'animal-hospital/detail',
            'priority' => '0.8',
        ],
    ];

    /**
     * sitemap index
     * /sitemap
     */
    public function index()
    {
        helper('url');

        $today = date('Y-m-d');

        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($this->sections as $key => $conf) {
            $model = new $conf['model']();

            // count 메서드가 없으면 fallback
            $total = $this->safeCount($model, $conf['count'] ?? null);
            $pages = max(1, (int) ceil($total / $this->perPage));

            for ($i = 1; $i <= $pages; $i++) {
                // site_url로 통일 (도메인/서브폴더 꼬임 방지)
                $loc = site_url("sitemap/{$key}/{$i}");

                $xml .= "  <sitemap>\n";
                $xml .= "    <loc>" . esc($loc) . "</loc>\n";
                $xml .= "    <lastmod>{$today}</lastmod>\n";
                $xml .= "  </sitemap>\n";
            }
        }

        $xml .= "</sitemapindex>";

        return $this->response
            ->setHeader('Content-Type', 'application/xml; charset=utf-8')
            ->setBody($xml);
    }

    // 섹션별 sitemap urlset 라우팅
    public function hairSalonPage(int $pageNumber)             { return $this->renderUrls('hairSalonPage', $pageNumber); }
    public function installationPage(int $pageNumber)          { return $this->renderUrls('installationPage', $pageNumber); }
    public function clothingCollectionBinPage(int $pageNumber) { return $this->renderUrls('clothingCollectionBinPage', $pageNumber); }
    public function seminarRoomPage(int $pageNumber)           { return $this->renderUrls('seminarRoomPage', $pageNumber); }
    public function campingPage(int $pageNumber)               { return $this->renderUrls('campingPage', $pageNumber); }
    public function worldResPage(int $pageNumber)              { return $this->renderUrls('worldResPage', $pageNumber); }
    public function sportsFacilitiesPage(int $pageNumber)      { return $this->renderUrls('sportsFacilitiesPage', $pageNumber); }
    public function libraryInfoPage(int $pageNumber)           { return $this->renderUrls('libraryInfoPage', $pageNumber); }
    public function shopsPage(int $pageNumber)                 { return $this->renderUrls('shopsPage', $pageNumber); }
    public function animalHospitalPage(int $pageNumber)        { return $this->renderUrls('animalHospitalPage', $pageNumber); }

    /**
     * urlset 렌더
     * /sitemap/{section}/{page}
     */
    protected function renderUrls(string $sectionKey, int $pageNumber)
    {
        helper('url');

        if (!isset($this->sections[$sectionKey])) {
            return $this->response
                ->setStatusCode(404)
                ->setBody('Invalid sitemap section');
        }

        $conf   = $this->sections[$sectionKey];
        $model  = new $conf['model']();

        $pageNumber = max(1, $pageNumber);
        $offset = ($pageNumber - 1) * $this->perPage;

        $items = $this->safeFetch($model, $conf['fetch'] ?? null, $this->perPage, $offset);

        $today = date('Y-m-d'); // ✅ 네이버용 "오늘 고정"
        $changefreq = 'daily';
        $priority = $conf['priority'] ?? '0.5';

        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($items as $item) {
            $id = is_object($item) ? ($item->id ?? null) : ($item['id'] ?? null);
            if (!$id) continue;

            $loc = site_url("{$conf['route']}/{$id}");

            $xml .= "  <url>\n";
            $xml .= "    <loc>" . esc($loc) . "</loc>\n";
            $xml .= "    <lastmod>{$today}</lastmod>\n";
            $xml .= "    <changefreq>{$changefreq}</changefreq>\n";
            $xml .= "    <priority>{$priority}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= "</urlset>";

        return $this->response
            ->setHeader('Content-Type', 'application/xml; charset=utf-8')
            ->setBody($xml);
    }

    /**
     * count 안전 호출
     */
    protected function safeCount($model, ?string $countMethod): int
    {
        try {
            if ($countMethod && method_exists($model, $countMethod)) {
                $v = $model->{$countMethod}();
                return is_numeric($v) ? (int)$v : 0;
            }

            // fallback: CI 기본 countAllResults
            if (method_exists($model, 'countAllResults')) {
                return (int)$model->countAllResults();
            }
        } catch (\Throwable $e) {
            // 실패하면 0
        }
        return 0;
    }

    /**
     * fetch 안전 호출
     * - (limit, offset) 가능한 메서드 우선
     * - findAll 같은 CI 기본 메서드는 limit만 받는 경우도 있어 fallback 처리
     */
    protected function safeFetch($model, ?string $fetchMethod, int $limit, int $offset): array
    {
        try {
            if ($fetchMethod && method_exists($model, $fetchMethod)) {
                $ref = new \ReflectionMethod($model, $fetchMethod);
                $argc = $ref->getNumberOfParameters();

                if ($argc >= 2) {
                    $rows = $model->{$fetchMethod}($limit, $offset);
                    return is_array($rows) ? $rows : [];
                }

                if ($argc === 1) {
                    $rows = $model->{$fetchMethod}($limit);
                    return is_array($rows) ? $rows : [];
                }

                // argc 0 이면 그냥 호출
                $rows = $model->{$fetchMethod}();
                return is_array($rows) ? $rows : [];
            }

            // fallback: query builder로 강제 limit/offset
            if (method_exists($model, 'builder')) {
                $rows = $model->builder()
                    ->select('id')
                    ->orderBy('id', 'ASC')
                    ->limit($limit, $offset)
                    ->get()
                    ->getResultArray();
                return is_array($rows) ? $rows : [];
            }
        } catch (\Throwable $e) {
            // 실패하면 빈 배열
        }

        return [];
    }
}
