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
        
        // 업로드 기본 경로 설정 (배포와 로컬환경에서 모두 사용 가능)
        $this->uploadBasePath = FCPATH . 'uploads/';
        
        // 최대 실행 시간을 200초로 설정
        ini_set('max_execution_time', 200);
    }

    public function crawlDCInside($postNumber)
    {
        // 오늘 날짜에 해당하는 폴더 경로 설정
        $currentDate = date('Y-m-d');
        $uploadPath = $this->uploadBasePath . $currentDate . '/';
        
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
            echo "디렉토리 생성 완료: {$uploadPath}\n";
        }

        // 중복 확인: `crawl_logs` 테이블에서 이미 크롤링된 게시물 번호인지 확인
        $logExists = $this->db->table('crawl_logs')->where('post_number', $postNumber)->get()->getRow();
        if ($logExists) {
            echo "Post {$postNumber} 이미 크롤링됨. 다음 번호로 이동.\n";
            return;
        }

        // URL 설정 및 HTML 가져오기
        $url = "https://gall.dcinside.com/board/view/?id=neostock&no={$postNumber}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);  // 타임아웃 1분으로 설정
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
        curl_setopt($ch, CURLOPT_REFERER, 'https://gall.dcinside.com/');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $html = curl_exec($ch);

        if ($html === false || empty($html)) {
            echo "Post {$postNumber} 가져오기 실패.\n";
            curl_close($ch);
            return;
        }

        curl_close($ch);

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        // 제목 크롤링
        $titleNode = $xpath->query("//span[@class='title_subject']");
        $title = $titleNode->length > 0 ? $titleNode->item(0)->textContent : '제목 없음';

        // 본문 크롤링
        $contentNode = $xpath->query("//div[contains(@class, 'write_div')]");
        if ($contentNode->length > 0) {
            $content = trim($contentNode->item(0)->textContent);
        } else {
            echo "Post {$postNumber} 본문을 찾을 수 없습니다.\n";
            return;
        }

        // 이미지 URL 추출 및 다운로드 (GIF 제외)
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

        // 이미지와 본문을 합쳐 최종 콘텐츠 생성
        $finalContent = "<p>{$content}</p>" . $imageHtml;

        // 데이터베이스에 데이터 삽입
        $this->postModel->insert([
            'post_number' => $postNumber,
            'title' => $title,
            'nickname' => '자료셔틀',
            'content' => $finalContent,
            'category' => 8,  // 카테고리를 8로 고정
            'password' => password_hash('147258', PASSWORD_BCRYPT),
            'is_deleted' => 'N'
        ]);

        // 크롤링 완료 기록을 `crawl_logs`에 추가
        $this->db->table('crawl_logs')->insert([
            'post_number' => $postNumber,
            'completed_at' => date('Y-m-d H:i:s')
        ]);

        echo "Post {$postNumber} 크롤링 완료.\n";
    }

    private function downloadImage($imageUrl, $uploadPath, $postNumber, $currentDate)
    {
        if (strpos($imageUrl, '//') === 0) {
            $imageUrl = 'https:' . $imageUrl;
        } elseif (strpos($imageUrl, '/') === 0) {
            $imageUrl = 'https://gall.dcinside.com' . $imageUrl;
        }

        $context = stream_context_create([
            "http" => [
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
                "Referer" => "https://gall.dcinside.com/"
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
