<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AccessLogModel;

class AccessLogger implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 타이밍 기록 생략
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $path = $request->getURI()->getPath();
        $ua   = $request->getServer('HTTP_USER_AGENT') ?? '';
        $ref  = $request->getServer('HTTP_REFERER') ?? '';

        // 1) 봇 감지: 주요 시그니처 + Yeti 추가
        $bot = null;
        foreach ([
            'Googlebot','Yeti','Naverbot','MJ12bot','Bingbot','YandexBot',
            'AhrefsBot','SemrushBot','Baiduspider','Sogou','DuckDuckBot',
            'Slurp','archive.org_bot','facebot','facebookexternalhit'
        ] as $sig) {
            if (stripos($ua, $sig) !== false) {
                $bot = $sig;
                break;
            }
        }
        if (!$bot && preg_match('/\b(bot|crawler|spider|crawl|fetch|wget|curl|python-requests)\b/i', $ua)) {
            $bot = 'UnknownBot';
        }
        $isBot = $bot ? 1 : 0;

        // 2) 리퍼러 구분
        if (empty($ref)) {
            $source = 'Direct';
        } elseif (stripos($ref, 'naver.') !== false) {
            $source = 'Naver';
        } elseif (stripos($ref, 'google.') !== false) {
            $source = 'Google';
        } else {
            $source = 'Other';
        }

        // 3) 로그 저장
        (new AccessLogModel())->insert([
            'path'        => $path,
            'referrer'    => $source,
            'user_agent'  => $ua,
            'ip_address'  => $request->getIPAddress(),
            'session_id'  => $isBot ? null : session_id(),
            'duration'    => 0,
            'is_bot'      => $isBot,
            'bot_name'    => $bot,
        ]);
    }
}
