<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AccessLogModel;

class Analytics extends Controller
{
    public function index()
    {
        $log      = new AccessLogModel();
        $today    = date('Y-m-d');
        $sevenAgo = date('Y-m-d', strtotime('-6 days'));
        $year     = (int) date('Y');

        $data = [
          // 사용자 통계
          'userTodayVisits'    => $log->getTodayVisits(0),
          'userTodayAvgDur'    => $log->getTodayAvgDuration(),
          'userDailyTraffic'   => $log->getDailyTraffic($sevenAgo, $today, 0),
          'userMonthlyTraffic' => $log->getMonthlyTraffic($year, 0),
          'userYearlyTraffic'  => $log->getYearlyTraffic(0),
          'userUrlTraffic'     => $log->getTrafficByUrlSegment(0),

          // 봇 통계
          'botDailyTraffic'    => $log->getDailyTraffic($sevenAgo, $today, 1),
          'botMonthlyTraffic'  => $log->getMonthlyTraffic($year, 1),
          'botYearlyTraffic'   => $log->getYearlyTraffic(1),
          'botUrlTraffic'      => $log->getTrafficByUrlSegment(1),
          'recentBotCrawls'    => $log->getRecentBotCrawls(10),
        ];

        return view('analytics/dashboard', $data);
    }
}
