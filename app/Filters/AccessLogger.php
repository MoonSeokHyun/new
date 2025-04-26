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
        if (stripos($ua, 'Googlebot') !== false) {
            $bot = 'Googlebot';
        } elseif (stripos($ua, 'Naverbot') !== false || stripos($ua, 'NaverBot') !== false) {
            $bot = 'NaverBot';
        }
        $isBot = $bot ? 1 : 0;

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
