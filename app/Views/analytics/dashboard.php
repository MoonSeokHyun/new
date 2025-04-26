<!doctype html>
<html><head><meta charset="utf-8">
  <title>Analytics</title>
  <style>
    body { font-family:sans-serif; padding:1rem; }
    table{border-collapse:collapse; width:100%; margin-bottom:1.5rem;}
    th,td{padding:.5rem; border:1px solid #ddd; text-align:center;}
    h2,h3{margin-top:2rem;}
  </style>
</head><body>

  <h2>👤 사용자 트래픽</h2>
  <ul>
    <li>오늘 방문: <?= esc($userTodayVisits) ?> 건</li>
    <li>오늘 평균 체류: <?= esc($userTodayAvgDur) ?> 초</li>
  </ul>

  <h3>일별 방문 (지난 7일)</h3>
  <table><tr><th>날짜</th><th>방문</th></tr>
    <?php foreach($userDailyTraffic as $r): ?>
      <tr><td><?= esc($r['period']) ?></td><td><?= esc($r['visits']) ?></td></tr>
    <?php endforeach ?>
  </table>

  <h3>월별 방문 (<?= date('Y') ?>년)</h3>
  <table><tr><th>월</th><th>방문</th></tr>
    <?php foreach($userMonthlyTraffic as $r): ?>
      <tr><td><?= esc($r['period']) ?>월</td><td><?= esc($r['visits']) ?></td></tr>
    <?php endforeach ?>
  </table>

  <h3>연도별 방문</h3>
  <table><tr><th>연도</th><th>방문</th></tr>
    <?php foreach($userYearlyTraffic as $r): ?>
      <tr><td><?= esc($r['period']) ?>년</td><td><?= esc($r['visits']) ?></td></tr>
    <?php endforeach ?>
  </table>

  <h3>URL 세그먼트별 방문</h3>
  <table><tr><th>URL</th><th>방문</th></tr>
    <?php foreach($userUrlTraffic as $r): ?>
      <tr><td><?= esc($r['category']) ?></td><td><?= esc($r['visits']) ?></td></tr>
    <?php endforeach ?>
  </table>


  <h2>🤖 봇 크롤링</h2>

  <h3>일별 크롤 (지난 7일)</h3>
  <table><tr><th>날짜</th><th>크롤 수</th></tr>
    <?php foreach($botDailyTraffic as $r): ?>
      <tr><td><?= esc($r['period']) ?></td><td><?= esc($r['visits']) ?></td></tr>
    <?php endforeach ?>
  </table>

  <h3>월별 크롤 (<?= date('Y') ?>년)</h3>
  <table><tr><th>월</th><th>크롤 수</th></tr>
    <?php foreach($botMonthlyTraffic as $r): ?>
      <tr><td><?= esc($r['period']) ?>월</td><td><?= esc($r['visits']) ?></td></tr>
    <?php endforeach ?>
  </table>

  <h3>연도별 크롤</h3>
  <table><tr><th>연도</th><th>크롤 수</th></tr>
    <?php foreach($botYearlyTraffic as $r): ?>
      <tr><td><?= esc($r['period']) ?>년</td><td><?= esc($r['visits']) ?></td></tr>
    <?php endforeach ?>
  </table>

  <h3>URL 세그먼트별 크롤</h3>
  <table><tr><th>URL</th><th>크롤 수</th></tr>
    <?php foreach($botUrlTraffic as $r): ?>
      <tr><td><?= esc($r['category']) ?></td><td><?= esc($r['visits']) ?></td></tr>
    <?php endforeach ?>
  </table>

  <h3>최근 10건 크롤 로그</h3>
  <table><tr><th>시간</th><th>경로</th><th>봇</th></tr>
    <?php foreach($recentBotCrawls as $log): ?>
      <tr>
        <td><?= esc($log['created_at']) ?></td>
        <td><?= esc($log['path']) ?></td>
        <td><?= esc($log['bot_name']) ?></td>
      </tr>
    <?php endforeach ?>
  </table>

</body></html>
