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
        $start    = (float) ($request->getServer('start_time') ?? microtime(true));
        $duration = intval(microtime(true) - $start);

        $ua  = $request->getServer('HTTP_USER_AGENT') ?? '';
        $bot = null;

        // 1) 잘 알려진 봇 식별자 리스트
        $botSignatures = [
            'Googlebot','Naverbot','MJ12bot','Bingbot','YandexBot',
            'AhrefsBot','SemrushBot','Baiduspider','Sogou','DuckDuckBot',
            'Slurp','archive.org_bot','facebot','facebookexternalhit'
        ];
        foreach ($botSignatures as $sig) {
            if (stripos($ua, $sig) !== false) {
                $bot = $sig;
                break;
            }
        }

        // 2) 흔한 키워드로 잡아내기
        if (!$bot && preg_match('/(bot|crawler|spider|crawl|fetch|wget|curl|python-requests)/i', $ua)) {
            $bot = 'UnknownBot';
        }

        // 3) 진짜 브라우저만 user 로 판단 (간단화)
        //    - Chrome, Firefox, Safari, Edge, Opera 등
        $isBrowser = preg_match('/(Mozilla\/\d+\.\d+|Chrome\/|Firefox\/|Safari\/|Edge\/|OPR\/)/i', $ua);
        $isBot     = $bot !== null && !$isBrowser ? 1 : ( $bot !== null && $isBrowser ? 1 : 0 );

        // 로그 저장
        $model = new AccessLogModel();
        $model->insert([
            'path'       => $request->getURI()->getPath(),
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
