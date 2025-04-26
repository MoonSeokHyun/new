<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AccessLogModel;

class AccessLogger implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 요청 시작 시간 기록
        $request->setGlobal('start_time', microtime(true));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // 1) GET+네비게이션(document) 요청만
        if ($request->getMethod() !== 'get'
         || $request->getServer('HTTP_SEC_FETCH_MODE')   !== 'navigate'
         || $request->getServer('HTTP_SEC_FETCH_DEST')   !== 'document'
        ) {
            return;
        }

        $uri = $request->getURI()->getPath();
        // 2) 정적 리소스 파일 제외
        if (preg_match('/\.(?:css|js|png|jpe?g|gif|svg|ico|woff2?)$/i', $uri)) {
            return;
        }

        $start    = (float) ($request->getServer('start_time') ?? microtime(true));
        $duration = intval(microtime(true) - $start);
        $ua       = $request->getServer('HTTP_USER_AGENT') ?? '';

        // 3) 봇 감지
        $botSignatures = [
            'Googlebot','Naverbot','MJ12bot','Bingbot','YandexBot',
            'AhrefsBot','SemrushBot','Baiduspider','Sogou','DuckDuckBot',
            'Slurp','archive.org_bot','facebot','facebookexternalhit'
        ];
        $bot = null;
        foreach ($botSignatures as $sig) {
            if (stripos($ua, $sig) !== false) {
                $bot = $sig;
                break;
            }
        }
        if (!$bot && preg_match('/\b(bot|crawler|spider|crawl|fetch|wget|curl|python-requests)\b/i', $ua)) {
            $bot = 'UnknownBot';
        }

        // 4) 브라우저 UA 패턴 확인
        $isBrowser = preg_match('/\b(Chrome\/|Firefox\/|Safari\/|Edg\/|OPR\/|Trident\/|Mozilla\/)\b/i', $ua);
        $isBot     = $bot ? 1 : 0;

        // 5) 실제 유저·봇만 기록
        if (!$isBot && !$isBrowser) {
            return; // 봇도 아니고, 브라우저도 아니면 스킵
        }

        // 6) 로그 저장
        (new AccessLogModel())->insert([
            'path'       => $uri,
            'referrer'   => $request->getServer('HTTP_REFERER'),
            'user_agent' => $ua,
            'ip_address' => $request->getIPAddress(),
            'session_id' => $isBot ? null : session_id(),
            'duration'   => $isBot ? 0 : $duration,
            'is_bot'     => $isBot,
            'bot_name'   => $bot,
        ]);
    }
}
