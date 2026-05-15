<?php

namespace App\Controllers;

use App\Models\PostModel;
use CodeIgniter\Controller;

class Crawler extends Controller
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

    public function crawlAndSave()
    {
        $count = 0;  // 크롤링할 게시물 수

        // 마지막으로 크롤링한 게시물 번호 가져오기
        $lastCrawledPost = $this->db->table('last_crawled_post')
            ->select('post_number')
            ->orderBy('id', 'DESC')
            ->get()
            ->getRow();
        
        // 처음에는 1336105번부터 시작하도록 기본 번호 설정
        $startNumber = $lastCrawledPost ? $lastCrawledPost->post_number + 1 : 1336105;

        // 오늘 날짜에 해당하는 폴더 경로 설정
        $currentDate = date('Y-m-d');
        $uploadPath = $this->uploadBasePath . $currentDate . '/';
        
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
            echo "디렉토리 생성 완료: {$uploadPath}\n";
        }

        while ($count < 1) {
            // 중복 체크: `crawl_logs` 테이블에서 이미 크롤링된 게시물 번호인지 확인
            $logExists = $this->db->table('crawl_logs')->where('post_number', $startNumber)->get()->getRow();
            if ($logExists) {
                echo "Post {$startNumber} 이미 크롤링됨. 다음 번호로 이동.\n";
                $startNumber++;
                continue;
            }

            // URL 설정 및 HTML 가져오기
            $url = "https://m.humoruniv.com/board/read.html?table=pds&number={$startNumber}";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);  // 타임아웃 1분으로 설정
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
            curl_setopt($ch, CURLOPT_REFERER, 'https://m.humoruniv.com/');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            $html = curl_exec($ch);

            if ($html === false || empty($html)) {
                echo "Post {$startNumber} 가져오기 실패. 다음 번호로 이동.\n";
                $startNumber++;
                curl_close($ch);
                continue;
            }

            curl_close($ch);

            $dom = new \DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new \DOMXPath($dom);

            // 제목 추출
            $titleTag = $dom->getElementsByTagName('title')->item(0);
            $title = $titleTag ? $titleTag->nodeValue : 'No Title';

            // 본문 텍스트 추출
            $contentNodes = $xpath->query("//div[contains(@class, 'simple_attach_img_div')]");
            if ($contentNodes->length > 0) {
                $content = trim($contentNodes->item(0)->textContent);
            } else {
                echo "Post {$startNumber} 본문을 찾을 수 없습니다. 다음 번호로 이동.\n";
                $startNumber++;
                continue;
            }

            // 이미지 URL 추출 및 다운로드 (GIF 제외)
            $imageHtml = '';
            $imageNodes = $xpath->query("//div[contains(@class, 'simple_attach_img_div')]//img");
            foreach ($imageNodes as $img) {
                $imageUrl = $img->getAttribute('src');
                if (str_ends_with(strtolower($imageUrl), '.gif')) {
                    continue;
                }

                $localImageUrl = $this->downloadImage($imageUrl, $uploadPath, $startNumber, $currentDate);
                if ($localImageUrl) {
                    // 이미지 경로를 content HTML에 직접 추가
                    $imageHtml .= "<p><img src='{$localImageUrl}' alt='Uploaded Image'></p>";
                }
            }

            // 이미지와 본문을 합쳐 최종 콘텐츠 생성
            $finalContent = "<p>{$content}</p>" . $imageHtml;

            // 데이터베이스에 데이터 삽입
            $this->postModel->insert([
                'post_number' => $startNumber,
                'title' => $title,
                'nickname' => '자료셔틀',
                'content' => $finalContent,
                'category' => 7,
                'password' => password_hash('147258', PASSWORD_BCRYPT),
                'is_deleted' => 'N'
            ]);

            // 크롤링 완료 기록을 `crawl_logs`에 추가
            $this->db->table('crawl_logs')->insert([
                'post_number' => $startNumber,
                'completed_at' => date('Y-m-d H:i:s')
            ]);

            // `last_crawled_post` 테이블 업데이트
            $this->db->table('last_crawled_post')->replace(['id' => 1, 'post_number' => $startNumber]);

            echo "Post {$startNumber} 크롤링 완료.\n";

            // 다음 게시물로 이동
            $startNumber++;
            $count++;
        }
    }

    private function downloadImage($imageUrl, $uploadPath, $postNumber, $currentDate)
    {
        if (strpos($imageUrl, '//') === 0) {
            $imageUrl = 'https:' . $imageUrl;
        } elseif (strpos($imageUrl, '/') === 0) {
            $imageUrl = 'https://m.humoruniv.com' . $imageUrl;
        }

        $context = stream_context_create([
            "http" => [
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
                "Referer" => "https://m.humoruniv.com/"
            ],
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ]
        ]);

        $imageData = file_get_contents($imageUrl, false, $context);

        if ($imageData === false) {
            echo "이미지 다운로드 실패: {$imageUrl}\n";
            return null;
        }

        $imageFileName = "post_{$postNumber}_" . uniqid() . '.png';
        $imagePath = "{$uploadPath}{$imageFileName}";

        file_put_contents($imagePath, $imageData);

        echo "이미지 저장 완료: {$imagePath}\n";
        return "/uploads/{$currentDate}/{$imageFileName}";
    }
}
