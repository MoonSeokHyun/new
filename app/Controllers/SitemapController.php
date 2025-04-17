<?php

namespace App\Controllers;

use App\Models\HairSalonModel;
use App\Models\InstallationModel;
use App\Models\ClothingCollectionBinModel;
use App\Models\SeminarRoomModel;
use App\Models\CampingModel;
use CodeIgniter\Controller;

class SitemapController extends Controller
{
    public function index()
    {
        $hairSalonPages             = $this->getHairSalonPages();
        $installationPages          = $this->getInstallationPages();
        $clothingCollectionBinPages = $this->getClothingCollectionBinPages();
        $seminarRoomPages           = $this->getSeminarRoomPages();
        $campingPages               = $this->getCampingPages();

        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($hairSalonPages as $url) {
            $xml .= "  <sitemap>\n";
            $xml .= "    <loc>{$url}</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "  </sitemap>\n";
        }

        foreach ($installationPages as $url) {
            $xml .= "  <sitemap>\n";
            $xml .= "    <loc>{$url}</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "  </sitemap>\n";
        }

        foreach ($clothingCollectionBinPages as $url) {
            $xml .= "  <sitemap>\n";
            $xml .= "    <loc>{$url}</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "  </sitemap>\n";
        }

        foreach ($seminarRoomPages as $url) {
            $xml .= "  <sitemap>\n";
            $xml .= "    <loc>{$url}</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "  </sitemap>\n";
        }

        foreach ($campingPages as $url) {
            $xml .= "  <sitemap>\n";
            $xml .= "    <loc>{$url}</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "  </sitemap>\n";
        }

        $xml .= "</sitemapindex>";

        return $this->response
                    ->setHeader('Content-Type', 'application/xml; charset=utf-8')
                    ->setBody($xml);
    }

    private function getHairSalonPages(): array
    {
        $model   = new HairSalonModel();
        $total   = $model->countAllSalons();
        $perPage = 10000;
        $pages   = (int) ceil($total / $perPage);
        $urls    = [];

        for ($i = 1; $i <= $pages; $i++) {
            $urls[] = base_url("sitemap/hairSalonPage/{$i}");
        }

        return $urls;
    }

    private function getInstallationPages(): array
    {
        $model   = new InstallationModel();
        $total   = $model->countAllResults();
        $perPage = 10000;
        $pages   = (int) ceil($total / $perPage);
        $urls    = [];

        for ($i = 1; $i <= $pages; $i++) {
            $urls[] = base_url("sitemap/installationPage/{$i}");
        }

        return $urls;
    }

    private function getClothingCollectionBinPages(): array
    {
        $model   = new ClothingCollectionBinModel();
        $total   = $model->countAllBins();
        $perPage = 10000;
        $pages   = (int) ceil($total / $perPage);
        $urls    = [];

        for ($i = 1; $i <= $pages; $i++) {
            $urls[] = base_url("sitemap/clothingCollectionBinPage/{$i}");
        }

        return $urls;
    }

    private function getSeminarRoomPages(): array
    {
        $model   = new SeminarRoomModel();
        $total   = $model->countAllResults();
        $perPage = 10000;
        $pages   = (int) ceil($total / $perPage);
        $urls    = [];

        for ($i = 1; $i <= $pages; $i++) {
            $urls[] = base_url("sitemap/seminarRoomPage/{$i}");
        }

        return $urls;
    }

    private function getCampingPages(): array
    {
        $model   = new CampingModel();
        $total   = $model->countAllCampings();
        $perPage = 10000;
        $pages   = (int) ceil($total / $perPage);
        $urls    = [];

        for ($i = 1; $i <= $pages; $i++) {
            $urls[] = base_url("sitemap/campingPage/{$i}");
        }

        return $urls;
    }

    public function hairSalonPage(int $pageNumber)
    {
        $model   = new HairSalonModel();
        $limit   = 10000;
        $offset  = ($pageNumber - 1) * $limit;
        $salons  = $model->getHairSalons($limit, $offset);

        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($salons as $salon) {
            $loc     = base_url("hairsalon/detail/{$salon->id}");
            $lastmod = date('Y-m-d', strtotime($salon->last_modification_time));
            $xml    .= "  <url>\n";
            $xml    .= "    <loc>{$loc}</loc>\n";
            $xml    .= "    <lastmod>{$lastmod}</lastmod>\n";
            $xml    .= "    <changefreq>monthly</changefreq>\n";
            $xml    .= "    <priority>0.8</priority>\n";
            $xml    .= "  </url>\n";
        }

        $xml .= "</urlset>";

        return $this->response
                    ->setHeader('Content-Type', 'application/xml; charset=utf-8')
                    ->setBody($xml);
    }

    public function installationPage(int $pageNumber)
    {
        $model         = new InstallationModel();
        $limit         = 10000;
        $offset        = ($pageNumber - 1) * $limit;
        $installations = $model->findAll($limit, $offset);

        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($installations as $inst) {
            $loc     = base_url("installation/show/{$inst['id']}");
            $lastmod = date('Y-m-d', strtotime($inst['Data Reference Date']));
            $xml    .= "  <url>\n";
            $xml    .= "    <loc>{$loc}</loc>\n";
            $xml    .= "    <lastmod>{$lastmod}</lastmod>\n";
            $xml    .= "    <changefreq>monthly</changefreq>\n";
            $xml    .= "    <priority>0.8</priority>\n";
            $xml    .= "  </url>\n";
        }

        $xml .= "</urlset>";

        return $this->response
                    ->setHeader('Content-Type', 'application/xml; charset=utf-8')
                    ->setBody($xml);
    }

    public function clothingCollectionBinPage(int $pageNumber)
    {
        $model  = new ClothingCollectionBinModel();
        $limit  = 10000;
        $offset = ($pageNumber - 1) * $limit;
        $bins   = $model->getAllBins($limit, $offset);

        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($bins as $bin) {
            $loc     = base_url("clothingcollectionbin/show/{$bin['id']}");
            $lastmod = date('Y-m-d', strtotime($bin['Data Reference Date']));
            $xml    .= "  <url>\n";
            $xml    .= "    <loc>{$loc}</loc>\n";
            $xml    .= "    <lastmod>{$lastmod}</lastmod>\n";
            $xml    .= "    <changefreq>monthly</changefreq>\n";
            $xml    .= "    <priority>0.8</priority>\n";
            $xml    .= "  </url>\n";
        }

        $xml .= "</urlset>";

        return $this->response
                    ->setHeader('Content-Type', 'application/xml; charset=utf-8')
                    ->setBody($xml);
    }

    public function seminarRoomPage(int $pageNumber)
    {
        $model  = new SeminarRoomModel();
        $limit  = 10000;
        $offset = ($pageNumber - 1) * $limit;
        $rooms  = $model->orderBy('id', 'ASC')->findAll($limit, $offset);

        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($rooms as $room) {
            $loc     = base_url("seminar_rooms/{$room->id}");
            $lastmod = date('Y-m-d', strtotime($room->LAST_UPDT_DE));
            $xml    .= "  <url>\n";
            $xml    .= "    <loc>{$loc}</loc>\n";
            $xml    .= "    <lastmod>{$lastmod}</lastmod>\n";
            $xml    .= "    <changefreq>monthly</changefreq>\n";
            $xml    .= "    <priority>0.8</priority>\n";
            $xml    .= "  </url>\n";
        }

        $xml .= "</urlset>";

        return $this->response
                    ->setHeader('Content-Type', 'application/xml; charset=utf-8')
                    ->setBody($xml);
    }

    public function campingPage(int $pageNumber)
    {
        $model    = new CampingModel();
        $limit    = 10000;
        $offset   = ($pageNumber - 1) * $limit;
        $campings = $model->getCampings($limit, $offset);

        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($campings as $camp) {
            $loc     = base_url("camping/{$camp['id']}");
            $lastmod = date('Y-m-d', strtotime($camp['LAST_UPDT_DE']));
            $xml    .= "  <url>\n"; 
            $xml    .= "    <loc>{$loc}</loc>\n";
            $xml    .= "    <lastmod>{$lastmod}</lastmod>\n";
            $xml    .= "    <changefreq>monthly</changefreq>\n";
            $xml    .= "    <priority>0.8</priority>\n";
            $xml    .= "  </url>\n";
        }

        $xml .= "</urlset>";

        return $this->response
                    ->setHeader('Content-Type', 'application/xml; charset=utf-8')
                    ->setBody($xml);
    }
}
