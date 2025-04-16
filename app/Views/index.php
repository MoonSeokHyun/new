<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>공공데이터 포털 - 퐁퐁코리아</title>
  <link rel="stylesheet" href="/assets/css/main.css">
  <style>
    :root {
      --theme-color: #FADB5F; /* 파스텔 노랑 */
      --theme-text: #333;
      --card-bg: #FFFBEA;
      --hover-bg: #FFF3C4;
      --font: 'Segoe UI', sans-serif;
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

    .hero {
      max-width: 100%;
      margin: 60px auto 40px auto;
      padding: 20px;
      text-align: center;
      border-radius: 12px;
      background: var(--card-bg);
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

    .intro114-cardwrap {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin: 2rem auto;
      max-width: 1200px;
    }

    .intro114-card {
      flex: 1 1 300px;
      background-color: var(--card-bg);
      border-radius: 1rem;
      padding: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: background 0.3s ease;
    }

    .intro114-card:hover {
      background-color: var(--hover-bg);
    }

    .intro114-card .text {
      flex: 1;
    }

    .intro114-card .title {
      font-weight: bold;
      font-size: 1.1rem;
      margin-bottom: 0.3rem;
    }

    .intro114-card .desc {
      font-size: 0.95rem;
      color: #555;
    }

    .intro114-card .emoji {
      font-size: 2rem;
      margin-left: 1rem;
    }

    @media (max-width: 600px) {
      .intro114-card {
        flex-direction: column;
        text-align: center;
      }

      .intro114-card .emoji {
        margin: 1rem 0 0 0;
      }
    }

    .card-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      max-width: 1200px;
      margin: 40px auto;
    }

    .card {
      flex: 1 1 300px;
      background-color: var(--card-bg);
      border-radius: 1rem;
      padding: 1.5rem;
      transition: background 0.3s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      min-height: 140px;
    }

    .card:hover {
      background-color: var(--hover-bg);
    }

    .card h3 {
      font-size: 18px;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 14px;
      color: #444;
      line-height: 1.6;
    }

    @media (max-width: 768px) {
      .card {
        flex: 1 1 100%;
      }
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
    <!-- 서비스 소개 본문 -->
    <div class="hero">
      <h2>💡 누구나 쉽게 생활데이터를 검색해보세요</h2>
      <p>
        원하는 정보를 빠르게 찾고 자유롭게 활용해보세요.
      </p>
    </div>

    <!-- 카드 섹션 1 -->
    <div class="intro114-cardwrap">
      <div class="intro114-card">
        <div class="text">
          <div class="title">편의시설</div>
          <div class="desc">새로운 편의시설을 확인해보세요.</div>
        </div>
        <div class="emoji">📣</div>
      </div>

      <div class="intro114-card">
        <div class="text">
          <div class="title">재미있는 정보</div>
          <div class="desc">심심하신가요 퐁퐁이가 책임져드려요!</div>
        </div>
        <div class="emoji">🌈</div>
      </div>

      <div class="intro114-card">
        <div class="text">
          <div class="title">생활시설 찾기</div>
          <div class="desc">주변의 공공시설을 쉽게 검색!</div>
        </div>
        <div class="emoji">🧭</div>
      </div>
    </div>

    <!-- 카드 섹션 2 -->
    <div class="card-grid">
      <div class="card">
        <h3>🏞️ 주요 공원</h3>
        <p>전국의 주요 공원, 산책로, 체험공간 등의 위치와 운영정보를 제공합니다.</p>
      </div>
      <div class="card">
        <h3>👨‍👩‍👧 복지 서비스</h3>
        <p>노인·장애인·청소년 등을 위한 맞춤형 공공서비스를 한눈에 확인해보세요.</p>
      </div>
      <div class="card">
        <h3>🏛️ 행정기관 정보</h3>
        <p>읍면동 주민센터부터 시청, 구청까지 다양한 기관의 위치와 연락처 제공.</p>
      </div>
    </div>

<!-- 활용 대상 -->
<section style="padding: 2rem 1rem; background-color: #f8fafc;">
  <div style="max-width: 960px; margin: 0 auto;">
    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">👥 활용 대상</h2>
    <div style="display: flex; flex-wrap: wrap; gap: 16px;">
      
      <div style="flex: 1 1 200px; background: #fff; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="font-size: 1.5rem;">🇰🇷</div>
        <div style="margin-top: 8px; font-weight: bold;">대한민국 국민 누구나!</div>
      </div>
      
      <div style="flex: 1 1 200px; background: #fff; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="font-size: 1.5rem;">🏛️</div>
        <div style="margin-top: 8px; font-weight: bold;">공공기관은 정책 자료로</div>
      </div>

      <div style="flex: 1 1 200px; background: #fff; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="font-size: 1.5rem;">📊</div>
        <div style="margin-top: 8px; font-weight: bold;">기업은 입지 선정 및 분석에</div>
      </div>

      <div style="flex: 1 1 200px; background: #fff; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="font-size: 1.5rem;">🙋</div>
        <div style="margin-top: 8px; font-weight: bold;">시민은 정보 검색에 활용</div>
      </div>

    </div>
  </div>
</section>
  </div>
</div>
  </main>
  <?php include APPPATH . 'Views/includes/footer.php'; ?>
</body>
</html>