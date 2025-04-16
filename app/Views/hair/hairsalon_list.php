<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Installation Data List</title>
    <!-- 네이버 지도 API -->
    <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
  
  <!-- 광고 스크립트 (선택사항) -->
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

  <style>
    :root {
      --theme-color: #3eaf7c;  /* 새로운 색상 */
      --theme-text: #333;
      --card-bg-1: #FFF8E1;
      --card-bg-2: #FFF3E0;
      --card-bg-3: #FFFDE7;
      --hover-bg: #FFF0B2;
      --badge-bg: #81C784;  /* 톤을 맞춰서 변경 */
      --font: 'Segoe UI', sans-serif;
      --pagination-bg: #fff8e1;
      --pagination-hover: #ffecb3;
      --pagination-active: #ffcc80;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: var(--font);
      background-color: #fffef7;
      color: var(--theme-text);
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    /* 제목 스타일 */
    .page-title {
      text-align: center;
      font-size: 28px;
      font-weight: bold;
      color: #333;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .hero {
      max-width: 100%;
      margin: 60px auto 40px auto;
      padding: 20px;
      text-align: center;
      border-radius: 12px;
      background: var(--card-bg-1);
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .hero h2 {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 16px;
    }

    .hero p {
      font-size: 16px;
      line-height: 1.6;
    }

    /* 검색 창 */
    .search-box {
      display: flex;
      width: 50%; /* 화면 너비의 50%로 확장 */
      margin: 40px auto;
      background: white;
      border-radius: 999px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 8px 16px;
    }

    .search-box input {
      flex-grow: 1; /* input이 버튼과 동일한 높이를 가지도록 */
      padding: 16px 20px;
      border: 1px solid #ccc;
      border-radius: 999px 0 0 999px; /* 왼쪽 테두리만 둥글게 */
      font-size: 18px;
      outline: none;
      height: 100%;
    }

    .search-box button {
      padding: 16px 20px;
      background-color: var(--theme-color); /* 새로운 색상 */
      border-radius: 0 999px 999px 0; /* 오른쪽 테두리만 둥글게 */
      font-weight: bold;
      cursor: pointer;
      font-size: 18px;
      border: none;
      height: 100%;
    }

    /* 모바일에서 두 줄로 나누어지지 않도록 설정 */
    @media (max-width: 768px) {
      .search-box {
        width: 80%; /* 모바일에서 너비를 80%로 설정 */
      }

      .page-title {
        font-size: 24px; /* 모바일에서 제목 폰트 크기 조정 */
        margin-top: 10px;
      }
    }

    /* 아이콘 카드 및 기타 스타일 */
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      max-width: 1200px;
      margin: 40px auto;
    }

    .icon-card {
      background-color: var(--card-bg-2);
      padding: 24px;
      border-radius: 16px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .icon-card:nth-child(3n+2) { background-color: var(--card-bg-3); }
    .icon-card:nth-child(3n) { background-color: var(--card-bg-1); }

    .icon-card:hover {
      transform: translateY(-5px);
      background-color: var(--hover-bg);
    }

    .card-info h2 {
      font-size: 20px;
      margin-bottom: 12px;
      background-color: var(--theme-color); /* 새로운 색상 */
      padding: 8px;
      border-radius: 8px;
      text-align: center;
      color: #000;
    }

    .card-info p {
      font-size: 14px;
      margin: 6px 0;
      display: flex;
      align-items: center;
    }

    .card-info p.address::before {
      content: '📍';
      margin-right: 6px;
    }

    .card-info p.phone::before {
      content: '📞';
      margin-right: 6px;
    }

    .badge {
      display: inline-block;
      margin-top: 12px;
      background-color: var(--badge-bg); /* 톤에 맞춘 배지 색상 */
      color: #222;
      font-size: 13px;
      padding: 6px 12px;
      border-radius: 50px;
      text-align: center;
    }

    .pagination {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      margin: 30px auto;
      list-style: none;
      padding-left: 0;
    }

    .pagination a, .pagination span {
      padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x);
      font-size: var(--bs-pagination-font-size);
      background-color: var(--bs-pagination-bg);
      border: var(--bs-pagination-border-width) solid var(--bs-pagination-border-color);
      border-radius: var(--bs-pagination-border-radius);
      margin: 4px;
      text-decoration: none;
      color: var(--bs-pagination-color);
      transition: 0.2s ease;
    }

    .pagination a:hover {
      background-color: var(--bs-pagination-hover-bg);
      border-color: var(--bs-pagination-hover-border-color);
      color: var(--bs-pagination-hover-color);
    }

    .pagination .active span {
      background-color: var(--bs-pagination-active-bg);
      color: var(--bs-pagination-active-color);
      border-color: var(--bs-pagination-active-border-color);
      font-weight: bold;
    }
  </style>
</head>
<body>
  <?php include APPPATH . 'Views/includes/header.php'; ?>
  <ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6686738239613464"
     data-ad-slot="1204098626"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
  <main>
    <!-- 제목 -->
    <h1 class="page-title">미용실 정보를 확인해 보세요!</h1>

    <div class="grid">
      <?php foreach ($salons as $salon): ?>
      <div class="icon-card">
        <a href="/hairsalon/detail/<?= esc($salon['id']) ?>">
          <div class="card-info">
            <h2><?= esc($salon['business_name']) ?></h2>
            <p class="address"><?= esc($salon['full_address']) ?></p>
            <p class="phone"><?= esc($salon['contact_phone_number']) ?></p>
            <div class="badge">업태: <?= esc($salon['business_type_name']) ?></div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="pagination">
      <?= $pager->links('salons', 'default_full') ?>
    </div>
  </main>
  <?php include APPPATH . 'Views/includes/footer.php'; ?>
</body>
</html>
