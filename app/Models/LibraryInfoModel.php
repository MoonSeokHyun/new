<?php

namespace App\Models;

use CodeIgniter\Model;

class LibraryInfoModel extends Model
{
    protected $table = 'LibraryInfo';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'Library Name', 'Province/City', 'City/County/District', 'Library Type', 
        'Closed Days', 'Weekday Opening Time', 'Weekday Closing Time', 
        'Saturday Opening Time', 'Saturday Closing Time', 'Holiday Opening Time', 
        'Holiday Closing Time', 'Number of Reading Seats', 'Number of Materials (Books)', 
        'Number of Materials (Serials)', 'Number of Materials (Non-Book)', 
        'Number of Lending Items Allowed', 'Lending Period (Days)', 
        'Address (Road Name)', 'Operating Organization', 'Library Phone Number', 
        'Land Area', 'Building Area', 'Website URL', 'Latitude', 'Longitude', 
        'Data Reference Date', 'Providing Organization Code', 'Providing Organization Name'
    ];

    protected $useTimestamps = false;

    /**
     * 사이트맵 URL 생성
     */
    public function generateSitemap()
    {
        // 사이트맵 XML을 생성할 기본 형식
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // 라이브러리 정보를 가져와서 사이트맵에 추가
        $libraries = $this->findAll();
        foreach ($libraries as $library) {
            $url = site_url('LibraryInfo/detail/' . $library['id']);
            $lastModified = date('Y-m-d', strtotime($library['Data Reference Date'])); // 데이터 참조 날짜 사용

            // URL 항목 추가
            $sitemap .= "<url>\n";
            $sitemap .= "<loc>" . esc($url) . "</loc>\n";
            $sitemap .= "<lastmod>" . esc($lastModified) . "</lastmod>\n";
            $sitemap .= "<changefreq>weekly</changefreq>\n";
            $sitemap .= "<priority>0.8</priority>\n";
            $sitemap .= "</url>\n";
        }

        $sitemap .= '</urlset>';

        return $sitemap;
    }
}
