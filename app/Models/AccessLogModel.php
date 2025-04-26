<?php namespace App\Models;

use CodeIgniter\Model;

class AccessLogModel extends Model
{
    // 테이블명을 pongpong_access_logs 로 변경
    protected $table         = 'pongpong_access_logs';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'path','referrer','user_agent','ip_address',
        'session_id','duration','is_bot','bot_name','created_at'
    ];

    // 사용자·봇 구분 없이 일별 집계
    public function getDailyTraffic(string $start, string $end, int $bot=0): array
    {
        return $this->select("DATE(created_at) AS period, COUNT(*) AS visits")
                    ->where('is_bot', $bot)
                    ->where('created_at >=', $start)
                    ->where('created_at <=', $end)
                    ->groupBy('period')
                    ->orderBy('period','ASC')
                    ->findAll();
    }

    // 월별 집계
    public function getMonthlyTraffic(int $year, int $bot=0): array
    {
        return $this->select("MONTH(created_at) AS period, COUNT(*) AS visits")
                    ->where('is_bot', $bot)
                    ->where('YEAR(created_at)', $year)
                    ->groupBy('period')
                    ->orderBy('period','ASC')
                    ->findAll();
    }

    // 연도별 집계
    public function getYearlyTraffic(int $bot=0): array
    {
        return $this->select("YEAR(created_at) AS period, COUNT(*) AS visits")
                    ->where('is_bot', $bot)
                    ->groupBy('period')
                    ->orderBy('period','ASC')
                    ->findAll();
    }

    // URL 첫 세그먼트별 집계
    public function getTrafficByUrlSegment(int $bot=0): array
    {
        $sql = "
          SELECT IF(seg='', '/', seg) AS category, COUNT(*) AS visits
          FROM (
            SELECT LOWER(SUBSTRING_INDEX(path, '/', 2)) AS seg
            FROM pongpong_access_logs
            WHERE is_bot = ?
          ) t
          GROUP BY category
          ORDER BY visits DESC
        ";
        return $this->db->query($sql, [$bot])->getResultArray();
    }

    // 오늘 방문 수
    public function getTodayVisits(int $bot=0): int
    {
        return $this->where('is_bot', $bot)
                    ->where('DATE(created_at)', date('Y-m-d'))
                    ->countAllResults();
    }

    // 오늘 평균 체류시간 (사용자만)
    public function getTodayAvgDuration(): float
    {
        $row = $this->select('AVG(duration) AS avg_sec')
                    ->where('is_bot', 0)
                    ->where('DATE(created_at)', date('Y-m-d'))
                    ->get()
                    ->getRow();
        return round($row->avg_sec, 1);
    }

    // 최근 봇 크롤링 (is_bot=1)
    public function getRecentBotCrawls(int $limit = 10): array
    {
        return $this->where('is_bot',1)
                    ->orderBy('created_at','DESC')
                    ->findAll($limit);
    }
}
