<?php

namespace App\Controllers;

use App\Models\HairSalonModel;
use CodeIgniter\Controller;

class SitemapController extends Controller
{
    public function index()
    {
        $hairSalonModel = new HairSalonModel(); // HairSalonModel 인스턴스 생성
        $totalSalons = $hairSalonModel->countAllSalons(); // 미용실 총 개수 가져오기
        $itemsPerPage = 50000; // 한 페이지에 50000개의 미용실 항목 포함

        $pages = ceil($totalSalons / $itemsPerPage); // 총 페이지 수 계산

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        
        // 미용실 디테일 페이지 URL을 추가
        $salonPages = $this->getHairSalonPages();
        foreach ($salonPages as $pageUrl) {
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

    // 50,000개씩 묶어 미용실 페이지 URL 목록을 반환하는 함수
    private function getHairSalonPages()
    {
        $hairSalonModel = new HairSalonModel();
        
        // 예시로 페이지 번호를 계산하는 방식 (50000개씩 나누는 방식)
        $totalSalons = $hairSalonModel->countAllSalons(); 
        $itemsPerPage = 50000;
        $pages = ceil($totalSalons / $itemsPerPage);
        
        $urls = [];
        for ($i = 1; $i <= $pages; $i++) {
            $urls[] = base_url("sitemap/page/{$i}"); // 각 미용실 페이지 URL
        }

        return $urls;
    }

    // 페이지 URL을 기반으로 한 사이트맵 생성
    public function page($pageNumber)
    {
        $hairSalonModel = new HairSalonModel();
        $itemsPerPage = 50000; // 한 페이지당 50,000개 미용실
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
}
