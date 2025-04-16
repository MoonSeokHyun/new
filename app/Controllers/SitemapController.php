<?php

namespace App\Controllers;

use App\Models\HairSalonModel;
use App\Models\InstallationModel;
use App\Models\ClothingCollectionBinModel;
use CodeIgniter\Controller;

class SitemapController extends Controller
{
    public function index()
    {
        // 미용실 사이트맵
        $hairSalonPages = $this->getHairSalonPages();
        // 설치장소 사이트맵
        $installationPages = $this->getInstallationPages();
        // 폐의약품 수거함 사이트맵
        $clothingCollectionBinPages = $this->getClothingCollectionBinPages();

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        // 미용실 디테일 페이지 URL 추가
        foreach ($hairSalonPages as $pageUrl) {
            $xml .= "<sitemap>\n";
            $xml .= "<loc>" . $pageUrl . "</loc>\n";
            $xml .= "<lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "</sitemap>\n";
        }

        // 설치장소 디테일 페이지 URL 추가
        foreach ($installationPages as $pageUrl) {
            $xml .= "<sitemap>\n";
            $xml .= "<loc>" . $pageUrl . "</loc>\n";
            $xml .= "<lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "</sitemap>\n";
        }

        // 폐의약품 수거함 디테일 페이지 URL 추가
        foreach ($clothingCollectionBinPages as $pageUrl) {
            $xml .= "<sitemap>\n";
            $xml .= "<loc>" . $pageUrl . "</loc>\n";
            $xml .= "<lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "</sitemap>\n";
        }

        $xml .= "</sitemapindex>";

        return $this->response
            ->setHeader('Content-Type', 'application/xml; charset=utf-8')
            ->setBody($xml);
    }

    // 미용실 페이지 URL 목록을 반환하는 함수
    private function getHairSalonPages()
    {
        $hairSalonModel = new HairSalonModel();
        
        // 페이지 번호 계산
        $totalSalons = $hairSalonModel->countAllSalons(); 
        $itemsPerPage = 10000;
        $pages = ceil($totalSalons / $itemsPerPage);
        
        $urls = [];
        for ($i = 1; $i <= $pages; $i++) {
            $urls[] = base_url("sitemap/hairSalonPage/{$i}"); // 미용실 페이지 URL
        }

        return $urls;
    }

    // 설치장소 페이지 URL 목록을 반환하는 함수
    private function getInstallationPages()
    {
        $installationModel = new InstallationModel();
        
        // 페이지 번호 계산
        $totalInstallations = $installationModel->countAllResults(); 
        $itemsPerPage = 10000;
        $pages = ceil($totalInstallations / $itemsPerPage);
        
        $urls = [];
        for ($i = 1; $i <= $pages; $i++) {
            $urls[] = base_url("sitemap/installationPage/{$i}"); // 설치장소 페이지 URL
        }

        return $urls;
    }

    // 폐의약품 수거함 페이지 URL 목록을 반환하는 함수
    private function getClothingCollectionBinPages()
    {
        $clothingCollectionBinModel = new ClothingCollectionBinModel();
        
        // 페이지 번호 계산
        $totalBins = $clothingCollectionBinModel->countAllBins();
        $itemsPerPage = 10000;
        $pages = ceil($totalBins / $itemsPerPage);
        
        $urls = [];
        for ($i = 1; $i <= $pages; $i++) {
            $urls[] = base_url("sitemap/clothingCollectionBinPage/{$i}"); // 폐의약품 수거함 페이지 URL
        }

        return $urls;
    }

    // 미용실 페이지 URL을 기반으로 한 사이트맵 생성
    public function hairSalonPage($pageNumber)
    {
        $hairSalonModel = new HairSalonModel();
        $itemsPerPage = 10000; // 한 페이지당 10,000개 미용실
        $offset = ($pageNumber - 1) * $itemsPerPage;

        // 페이지에 맞는 미용실 데이터 가져오기
        $salons = $hairSalonModel->getHairSalons($itemsPerPage, $offset);

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($salons as $salon) {
            $url = base_url("hairsalon/detail/{$salon['id']}");
            $lastMod = date('Y-m-d', strtotime($salon['last_modification_time']));
            
            $xml .= "<url>\n";
            $xml .= "<loc>{$url}</loc>\n";
            $xml .= "<lastmod>{$lastMod}</lastmod>\n";
            $xml .= "<changefreq>monthly</changefreq>\n";
            $xml .= "<priority>0.8</priority>\n";
            $xml .= "</url>\n";
        }

        $xml .= "</urlset>";

        return $this->response
            ->setHeader('Content-Type', 'application/xml; charset=utf-8')
            ->setBody($xml);
    }

    // 설치장소 페이지 URL을 기반으로 한 사이트맵 생성
    public function installationPage($pageNumber)
    {
        $installationModel = new InstallationModel();
        $itemsPerPage = 10000; // 한 페이지당 10,000개 설치장소
        $offset = ($pageNumber - 1) * $itemsPerPage;

        // 페이지에 맞는 설치장소 데이터 가져오기
        $installations = $installationModel->findAll($itemsPerPage, $offset);

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($installations as $installation) {
            $url = base_url("installation/show/{$installation['id']}");
            $lastMod = date('Y-m-d', strtotime($installation['Data Reference Date']));
            
            $xml .= "<url>\n";
            $xml .= "<loc>{$url}</loc>\n";
            $xml .= "<lastmod>{$lastMod}</lastmod>\n";
            $xml .= "<changefreq>monthly</changefreq>\n";
            $xml .= "<priority>0.8</priority>\n";
            $xml .= "</url>\n";
        }

        $xml .= "</urlset>";

        return $this->response
            ->setHeader('Content-Type', 'application/xml; charset=utf-8')
            ->setBody($xml);
    }

    // 폐의약품 수거함 페이지 URL을 기반으로 한 사이트맵 생성
    public function clothingCollectionBinPage($pageNumber)
    {
        $clothingCollectionBinModel = new ClothingCollectionBinModel();
        $itemsPerPage = 10000; // 한 페이지당 10,000개 수거함
        $offset = ($pageNumber - 1) * $itemsPerPage;

        // 페이지에 맞는 폐의약품 수거함 데이터 가져오기
        $bins = $clothingCollectionBinModel->getAllBins($itemsPerPage, $offset);

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($bins as $bin) {
            $url = base_url("clothingcollectionbin/show/{$bin['id']}");
            $lastMod = date('Y-m-d', strtotime($bin['Data Reference Date']));
            
            $xml .= "<url>\n";
            $xml .= "<loc>{$url}</loc>\n";
            $xml .= "<lastmod>{$lastMod}</lastmod>\n";
            $xml .= "<changefreq>monthly</changefreq>\n";
            $xml .= "<priority>0.8</priority>\n";
            $xml .= "</url>\n";
        }

        $xml .= "</urlset>";

        return $this->response
            ->setHeader('Content-Type', 'application/xml; charset=utf-8')
            ->setBody($xml);
    }
}
