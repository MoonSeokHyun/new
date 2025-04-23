<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>페이지 삭제 안내</title>
  <style>
    body {
      font-family: '돋움', Arial, sans-serif;
      background-color: #fff8e1;
      margin: 0;
      padding: 20px;
      text-align: center;
    }
    .message {
      margin: 60px 0;
    }
    .message h1 {
      font-size: 2em;
      color: #f57c00;
      margin-bottom: 10px;
    }
    .message p {
      font-size: 1em;
      color: #9e9e9e;
    }
    .main-nav {
      margin-top: 40px;
    }
    .main-nav ul.top-menu {
      list-style: none;
      padding: 0;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
    }
    .main-nav .menu-group {
      position: relative;
    }
    .main-nav .menu-group > a {
      display: inline-block;
      padding: 10px 15px;
      background-color: #f57c00;
      color: #ffeb3b;
      border-radius: 4px;
      text-decoration: none;
      font-weight: bold;
      transition: background-color .2s;
    }
    .main-nav .menu-group > a:hover {
      background-color: #ff5722;
    }
    .main-nav .sub-menu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      margin-top: 5px;
      padding: 0;
      background-color: #333;
      border-radius: 4px;
      overflow: hidden;
      z-index: 10;
    }
    .main-nav .sub-menu li a {
      display: block;
      padding: 8px 12px;
      color: #ddd;
      text-decoration: none;
      font-size: 0.9em;
      white-space: nowrap;
    }
    .main-nav .sub-menu li a:hover {
      background-color: #444;
    }
    .main-nav .menu-group:hover .sub-menu {
      display: block;
    }
    @media (max-width: 600px) {
      .main-nav ul.top-menu {
        flex-direction: column;
        gap: 8px;
      }
      .message h1 { font-size: 1.5em; }
    }
  </style>
</head>
<body>

  <div class="message">
    <h1>이 페이지는 현재 삭제되었습니다</h1>
    <p>요청하신 게시글은 더 이상 존재하지 않습니다.</p>
    <p>아래의 메뉴에서 선택해서 새롭게 사이트를 이용해주세요!</p>
  </div>

  <nav class="main-nav">
    <ul class="top-menu">
      <li class="menu-group">
        <a href="#">🛠️ 서비스 ▾</a>
        <ul class="sub-menu">
          <li><a href="/hairsalon">💇 미용실</a></li>
          <li><a href="/seminar_rooms">🏢 공유회의실</a></li>
        </ul>
      </li>
      <li class="menu-group">
        <a href="#">♻️ 재활용 ▾</a>
        <ul class="sub-menu">
          <li><a href="/installation">💊 폐의약품</a></li>
          <li><a href="/clothingcollectionbin">👕 폐의류</a></li>
        </ul>
      </li>
      <li class="menu-group">
        <a href="#">🌳 야외활동 ▾</a>
        <ul class="sub-menu">
          <li><a href="/camping">🏕️ 캠핑장</a></li>
          <li><a href="/sports_facilities">🏟️ 체육시설</a></li>
        </ul>
      </li>
      <li class="menu-group">
        <a href="#">🍽️ 맛집 ▾</a>
        <ul class="sub-menu">
          <li><a href="/world_res">🌍 세계음식</a></li>
        </ul>
      </li>
    </ul>
  </nav>

  <?php include APPPATH . 'Views/includes/footer.php'; ?>

</body>
</html>
