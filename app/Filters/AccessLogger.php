<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AccessLogModel;

class AccessLogger implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 👉 여기에 setServer/setGlobal 대신 PHP 슈퍼글로벌에 저장
        $_SERVER['ACCESS_LOGGER_START'] = microtime(true);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // 1) 네비게이션(document) 페이지뷰만 기록
        if (
            $request->getMethod() !== 'get' ||
            $request->getServer('HTTP_SEC_FETCH_MODE') !== 'navigate' ||
            $request->getServer('HTTP_SEC_FETCH_DEST') !== 'document'
        ) {
            return;
        }

        $uri = $request->getURI()->getPath();
        // 2) 정적 리소스(.css, .js, .png 등) 제외
        if (preg_match('/\.(?:css|js|png|jpe?g|gif|svg|ico|woff2?)$/i', $uri)) {
            return;
        }

        // 3) 시작 시간 꺼내오기
        $start    = isset($_SERVER['ACCESS_LOGGER_START'])
                  ? (float) $_SERVER['ACCESS_LOGGER_START']
                  : microtime(true);
        $duration = intval(microtime(true) - $start);

        $ua  = $request->getServer('HTTP_USER_AGENT') ?? '';
        $bot = null;

        // 4) 봇 식별
        $signatures = [
            'Googlebot','Naverbot','MJ12bot','Bingbot','YandexBot',
            'AhrefsBot','SemrushBot','Baiduspider','Sogou','DuckDuckBot',
            'Slurp','archive.org_bot','facebot','facebookexternalhit'
        ];
        foreach ($signatures as $sig) {
            if (stripos($ua, $sig) !== false) {
                $bot = $sig;
                break;
            }
        }
        if (!$bot && preg_match('/\b(bot|crawler|spider|crawl|fetch|wget|curl|python-requests)\b/i', $ua)) {
            $bot = 'UnknownBot';
        }

        // 5) 브라우저 UA 패턴 검사
        $isBrowser = preg_match('/\b(Chrome\/|Firefox\/|Safari\/|Edg\/|OPR\/|Trident\/|Mozilla\/)\b/i', $ua);
        $isBot     = $bot ? 1 : 0;

        // 6) 봇도 아니고 브라우저도 아니면 기록 안 함
        if (!$isBot && !$isBrowser) {
            return;
        }

        // 7) 테이블(pongpong_access_logs)에 저장
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
