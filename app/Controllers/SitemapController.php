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

class SitemapController extends Controller
{
    protected $sections = [
        'hairSalonPage'             => ['model' => HairSalonModel::class,             'count' => 'countAllSalons',       'fetch' => 'getHairSalons',          'route' => 'hairsalon/detail'],
        'installationPage'          => ['model' => InstallationModel::class,          'count' => 'countAllResults',     'fetch' => 'findAll',                'route' => 'installation/show'],
        'clothingCollectionBinPage' => ['model' => ClothingCollectionBinModel::class, 'count' => 'countAllBins',        'fetch' => 'getAllBins',             'route' => 'clothingcollectionbin/show'],
        'seminarRoomPage'           => ['model' => SeminarRoomModel::class,            'count' => 'countAllResults',     'fetch' => 'findAll',                'route' => 'seminar_rooms'],
        'campingPage'               => ['model' => CampingModel::class,                'count' => 'countAllCampings',    'fetch' => 'getCampings',            'route' => 'camping'],
        'worldResPage'              => ['model' => WorldResModel::class,               'count' => 'countAllRestaurants', 'fetch' => 'getRestaurants',         'route' => 'world_res'],
        'sportsFacilitiesPage'      => ['model' => SportsFacilityModel::class,         'count' => 'countAllFacilities',  'fetch' => 'getFacilities',          'route' => 'sports_facilities'],
    ];

    protected $perPage = 10000;

    public function index()
    {
        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($this->sections as $key => $conf) {
            $model = new $conf['model']();
            $total = $model->{$conf['count']}();
            $pages = (int) ceil($total / $this->perPage);

            for ($i = 1; $i <= $pages; $i++) {
                $loc  = base_url("sitemap/{$key}/{$i}");
                $xml .= "  <sitemap>\n";
                $xml .= "    <loc>{$loc}</loc>\n";
                $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
                $xml .= "  </sitemap>\n";
            }
        }

        $xml .= "</sitemapindex>";

        return $this->response
                    ->setHeader('Content-Type', 'application/xml; charset=utf-8')
                    ->setBody($xml);
    }

    public function hairSalonPage(int $pageNumber)            { return $this->renderUrls('hairSalonPage',            $pageNumber); }
    public function installationPage(int $pageNumber)         { return $this->renderUrls('installationPage',         $pageNumber); }
    public function clothingCollectionBinPage(int $pageNumber){ return $this->renderUrls('clothingCollectionBinPage',$pageNumber); }
    public function seminarRoomPage(int $pageNumber)          { return $this->renderUrls('seminarRoomPage',          $pageNumber); }
    public function campingPage(int $pageNumber)              { return $this->renderUrls('campingPage',              $pageNumber); }
    public function worldResPage(int $pageNumber)             { return $this->renderUrls('worldResPage',             $pageNumber); }
    public function sportsFacilitiesPage(int $pageNumber)     { return $this->renderUrls('sportsFacilitiesPage',     $pageNumber); }

    protected function renderUrls(string $sectionKey, int $pageNumber)
    {
        $conf   = $this->sections[$sectionKey];
        $model  = new $conf['model']();
        $offset = ($pageNumber - 1) * $this->perPage;
        $items  = $model->{$conf['fetch']}($this->perPage, $offset);

        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($items as $item) {
            $id       = is_object($item) ? $item->id : $item['id'];
            $lastDate = $item->LAST_UPDT_DE ?? ($item->last_modification_time ?? '');
            $loc      = base_url("{$conf['route']}/{$id}");
            $lastmod  = $lastDate ? date('Y-m-d', strtotime($lastDate)) : date('Y-m-d');

            $xml .= "  <url>\n";
            $xml .= "    <loc>{$loc}</loc>\n";
            $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= "</urlset>";

        return $this->response
                    ->setHeader('Content-Type', 'application/xml; charset=utf-8')
                    ->setBody($xml);
    }
}
