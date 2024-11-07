<?php

namespace App\Controllers;

use App\Models\PostModel;
use CodeIgniter\Controller;

class DCInsideCrawler extends Controller
{
    protected $postModel;
    protected $db;
    protected $uploadBasePath;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->db = \Config\Database::connect();
        
        // 업로드 기본 경로 설정
        $this->uploadBasePath = FCPATH . 'uploads/';
        
        // 최대 실행 시간을 200초로 설정
        ini_set('max_execution_time', 200);
    }

    public function crawl($postNumber = null)
    {
        if (is_null($postNumber)) {
            $lastCrawl = $this->db->table('crawl_logs')->orderBy('post_number', 'DESC')->get()->getRow();
            $postNumber = $lastCrawl ? $lastCrawl->post_number + 1 : 5850163;
        }

        $currentDate = date('Y-m-d');
        $uploadPath = $this->uploadBasePath . $currentDate . '/';
        
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
            echo "디렉토리 생성 완료: {$uploadPath}\n";
        }

        while (true) {
            $url = "https://gall.dcinside.com/board/view/?id=neostock&no={$postNumber}";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
            curl_setopt($ch, CURLOPT_REFERER, 'https://gall.dcinside.com/');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            $html = curl_exec($ch);

            if ($html === false || empty($html)) {
                echo "Post {$postNumber} 가져오기 실패. 다음 번호로 이동.\n";
                curl_close($ch);
                $postNumber++;
                continue;
            }

            curl_close($ch);

            $dom = new \DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new \DOMXPath($dom);

            $titleNode = $xpath->query("//span[@class='title_subject']");
            $title = $titleNode->length > 0 ? $titleNode->item(0)->textContent : '제목 없음';

            $contentNode = $xpath->query("//div[contains(@class, 'write_div')]");
            if ($contentNode->length > 0) {
                $content = trim($contentNode->item(0)->textContent);
            } else {
                echo "Post {$postNumber} 본문을 찾을 수 없습니다. 다음 번호로 이동.\n";
                $postNumber++;
                continue;
            }

            $imageHtml = '';
            $imageNodes = $xpath->query("//div[contains(@class, 'write_div')]//img");
            foreach ($imageNodes as $img) {
                $imageUrl = $img->getAttribute('src');
                if (str_ends_with(strtolower($imageUrl), '.gif')) {
                    continue;
                }

                $localImageUrl = $this->downloadImage($imageUrl, $uploadPath, $postNumber, $currentDate);
                if ($localImageUrl) {
                    $imageHtml .= "<p><img src='{$localImageUrl}' alt='Uploaded Image'></p>";
                }
            }

            $finalContent = "<p>{$content}</p>" . $imageHtml;

            $this->postModel->insert([
                'post_number' => $postNumber,
                'title' => $title,
                'nickname' => '자료셔틀',
                'content' => $finalContent,
                'category' => 8,
                'password' => password_hash('147258', PASSWORD_BCRYPT),
                'is_deleted' => 'N'
            ]);

            $this->db->table('crawl_logs')->insert([
                'post_number' => $postNumber,
                'completed_at' => date('Y-m-d H:i:s')
            ]);

            echo "Post {$postNumber} 크롤링 완료.\n";
            break;
        }
    }

    private function downloadImage($imageUrl, $uploadPath, $postNumber, $currentDate)
    {
        if (strpos($imageUrl, '//') === 0) {
            $imageUrl = 'https:' . $imageUrl;
        } elseif (strpos($imageUrl, '/') === 0) {
            $imageUrl = 'https://gall.dcinside.com' . $imageUrl;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $imageUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
        curl_setopt($ch, CURLOPT_REFERER, 'https://gall.dcinside.com/');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $imageData = curl_exec($ch);

        if ($imageData === false) {
            echo "이미지 다운로드 실패: {$imageUrl} - " . curl_error($ch) . "\n";
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        $imageFileName = "post_{$postNumber}_" . uniqid() . '.png';
        $imagePath = "{$uploadPath}{$imageFileName}";

        file_put_contents($imagePath, $imageData);

        echo "이미지 저장 완료: {$imagePath}\n";
        return "/uploads/{$currentDate}/{$imageFileName}";
    }
}
