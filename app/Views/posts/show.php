<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex,follow">
  <title>서비스 종료된 게시판 | 퐁퐁코리아</title>
  <meta name="description" content="요청하신 게시글이 포함된 게시판은 종료되었습니다. 아래 메뉴에서 생활 정보를 이용해 주세요.">
  <style>
    body { font-family: 'Pretendard','Segoe UI',Arial,sans-serif; background:#fff8e1; margin:0; padding:20px; color:#333; text-align:center; }
    .gone-wrap { max-width:720px; margin:60px auto; padding:32px 24px; background:#fff; border-radius:16px; box-shadow:0 6px 18px rgba(0,0,0,.06); }
    .gone-wrap h1 { font-size:1.8rem; color:#f57c00; margin:0 0 8px; }
    .gone-wrap p  { color:#666; margin:6px 0; line-height:1.6; }
    .shortcut { margin-top:28px; display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:10px; }
    .shortcut a { display:block; padding:12px 14px; background:#fff3c4; color:#333; border-radius:10px; text-decoration:none; font-weight:600; transition:background .2s; }
    .shortcut a:hover { background:#ffd966; }
  </style>
</head>
<body>
  <div class="gone-wrap">
    <h1>게시판 서비스가 종료되었습니다</h1>
    <p>요청하신 게시글이 포함된 커뮤니티 게시판은 더 이상 운영되지 않습니다.</p>
    <p>아래 카테고리에서 필요한 생활 정보를 바로 확인해 보세요.</p>

    <div class="shortcut">
      <a href="/">🏠 홈</a>
      <a href="/hairsalon">💇 미용실</a>
      <a href="/library-info">📚 도서관</a>
      <a href="/open-service-info">👓 안경점</a>
      <a href="/animal-hospital">🐶 동물병원</a>
      <a href="/camping">🏕️ 캠핑장</a>
      <a href="/sports-facility">🏟️ 체육시설</a>
      <a href="/world-res">🌍 세계음식</a>
      <a href="/seminar-rooms">🏢 공유회의실</a>
      <a href="/installation">💊 폐의약품 수거함</a>
      <a href="/clothing-collection-bin">👕 의류 수거함</a>
    </div>
  </div>

  <?php include APPPATH . 'Views/includes/footer.php'; ?>
</body>
</html>
