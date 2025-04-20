<?php
// 폐의류 수거함의 도로명 주소 예시
$road_address = esc($bin['Street Address'] ?? '');

// 구 이름이나 읍 이름을 추출하기 위한 정규 표현식
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/', $road_address, $matches);

// 구 또는 읍 이름을 추출
$district_name = isset($matches[0]) ? $matches[0] : '지역';

// 'Detailed Location'도 추가하여 타이틀을 더욱 구체적으로 작성
$detailedLocation = esc($bin['Detailed Location'] ?? '');

// 타이틀 생성 (사람들이 클릭하고 싶게끔 유도)
$seoTitle = esc("{$detailedLocation}폐의류 수거함 - {$district_name}에 위치한 수거함 정보, 위치, 세부 위치, 전화번호, 관리기관 확인!");

// SEO 설명 추가
$seoDescription = esc("폐의류 수거함 상세 정보 - 위치, 세부 위치, 전화번호, 관리기관, 제공기관 정보 등 확인해보세요.");
$seoKeywords = esc("폐의류 수거함, {$district_name}, 수거함, 위치, 세부위치, 전화번호, 제공기관");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title><?= esc($seoTitle) ?></title>
  <meta name="description" content="<?= esc($seoDescription) ?>" />
  <meta name="keywords" content="<?= esc($seoKeywords) ?>" />
  <meta name="author" content="편잇 팀" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Open Graph & Twitter Card -->
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= esc($seoTitle) ?>" />
  <meta property="og:description" content="<?= esc($seoDescription) ?>" />
  <meta property="og:url" content="<?= current_url() ?>" />
  <meta property="og:locale" content="ko_KR" />
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:title" content="<?= esc($seoTitle) ?>" />
  <meta name="twitter:description" content="<?= esc($seoDescription) ?>" />

  <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>

  <style>
    body { background: #f5f5f5; font-family: 'Noto Sans KR', sans-serif; color: #333; margin:0; padding:0; }
    a { color:#0078ff; text-decoration:none; }
    .container{ max-width:800px; margin:2rem auto; padding:0 1rem; }
    .content-title{ font-size:2rem; margin-bottom:.5rem; border-bottom:2px solid #0078ff; padding-bottom:.3rem; }
    .breadcrumb{ font-size:.9rem; color:#555; margin-bottom:1.5rem; }
    .ad-box{ margin:1.5rem 0; text-align:center; }
    .detail-card, .section{ background:#fff; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.1); margin-bottom:1.5rem; padding:1.5rem; }
    .detail-card h3, .section h2{ font-size:1.5rem; color:#0078ff; margin-bottom:1rem; border-left:4px solid #0078ff; padding-left:.5rem; }
    .detail-card p, .section p, .section ul, .section ol{ margin:.5rem 0; }
    .section ul, .section ol{ margin-left:1.2rem; }
    .detail-card p strong, .section p strong{ color:#333; }
    .info-table{ width:100%; border-collapse:collapse; margin-top:1rem; }
    .info-table th, .info-table td{ padding:.75rem; text-align:left; border-bottom:1px solid #eee; }
    .info-table th{ background:#f5f5f5; font-weight:600; }
    .main-button{ display:inline-block; margin-top:1rem; padding:.75rem 1.25rem; background:#62D491; color:#fff; border-radius:5px; }
    .main-button:hover{ background:#4db67d; }
    #map{ width:100%; height:300px; border-radius:8px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.1); margin-top:1.5rem; }
    @media (max-width:768px){ .container{ padding:0 1rem; } #map{ height:200px; } }
  </style>
</head>
<body>

  <?php include APPPATH . 'Views/includes/header.php'; ?>

  <div class="container">
    <h1 class="content-title"><?= esc($bin['Clothing Collection Bin Location Name']) ?> 수거함 위치 정보</h1>
    <div class="breadcrumb">
      <a href="<?= site_url() ?>">홈</a> &gt;
      <a href="<?= site_url('clothing_bins') ?>">폐의류 수거함</a> &gt;
      상세정보
    </div>

    <div class="ad-box">
      <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-6686738239613464" data-ad-slot="1204098626" data-ad-format="auto" data-full-width-responsive="true"></ins>
      <script>(adsbygoogle=window.adsbygoogle||[]).push({});</script>
    </div>

    <!-- 상세 카드 -->
    <div class="detail-card">
      <h3><?= esc($bin['Clothing Collection Bin Location Name']) ?> 🚪</h3>
      <p><strong>주소:</strong> <?= esc($bin['Street Address']) ?></p>
      <p><strong>세부 위치:</strong> <?= esc($bin['Detailed Location']) ?></p>
      <p><strong>관리 기관:</strong> <?= esc($bin['Managing Institution Name']) ?></p>
      <p><strong>전화번호:</strong> <?= esc($bin['Managing Institution Phone Number']) ?></p>
      <p><strong>데이터 기준일자:</strong> <?= esc($bin['Data Reference Date']) ?></p>

      <table class="info-table">
        <tr><th>제공기관명</th><td><?= esc($bin['Provider Institution Name']) ?></td></tr>
        <tr><th>제공기관 코드</th><td><?= esc($bin['Provider Institution Code']) ?></td></tr>
        <tr><th>취급 품목</th><td>헌옷, 신발, 가방, 침대커버, 인형, 홑이불, 가정용 카펫, 커튼, 담요</td></tr>
      </table>

      <a href="<?= site_url('clothing_bins') ?>" class="main-button">목록으로 돌아가기</a>
    </div>

    <!-- 수거 안내 섹션 -->
    <div class="section">
      <h2>수거 안내</h2>
      <ul>
        <li>깨끗하게 세탁된 의류만 배출해 주세요.</li>
        <li>오염 심한 의류나 침구류는 수거가 제한될 수 있습니다.</li>
        <li>대형 가전이나 전자제품은 별도 전용 수거함을 이용해 주세요.</li>
        <li>분리수거를 위해 옷 종류별로 지퍼백에 담아 가져오시면 편리합니다.</li>
        <li>수거함이 가득 찼을 경우, 관리자에게 문의 바랍니다.</li>
      </ul>
    </div>

    <!-- 수거 가능 품목 섹션 -->
    <div class="section">
      <h2>수거 가능 품목</h2>
      <ul>
        <li>헌 옷: 셔츠, 바지, 코트, 드레스 등</li>
        <li>신발: 운동화, 구두 (끈을 묶거나 한 짝씩 분리하여 배출)</li>
        <li>가방: 백팩, 토트백, 지갑 등</li>
        <li>침구류: 홑이불, 배개커버 (작은 크기로 접어 배출)</li>
        <li>커튼, 담요, 카펫 등 가정용 섬유류</li>
      </ul>
    </div>

    <!-- 이용 방법 섹션 -->
    <div class="section">
      <h2>이용 방법</h2>
      <ol>
        <li>운영 시간 확인: 방문 전 운영 시간과 휴일을 확인합니다.</li>
        <li>품목 분류: 수거 가능 품목을 종류별로 분류합니다.</li>
        <li>포장 준비: 비닐 봉투나 상자에 담아 밀봉합니다.</li>
        <li>배출: 수거함 입구에 정해진 방법대로 넣습니다.</li>
        <li>문의: 문제가 있을 경우 전화번호로 연락합니다.</li>
      </ol>
    </div>

    <!-- 자주 묻는 질문 섹션 -->
    <div class="section">
      <h2>자주 묻는 질문(FAQ)</h2>
      <ul>
        <li><strong>Q:</strong> 오염된 옷은 어떻게 하나요?<br><strong>A:</strong> 오염이 심할 경우 별도 폐기물로 처리해 주세요.</li>
        <li><strong>Q:</strong> 큰 가방도 수거 가능한가요?<br><strong>A:</strong> 크기가 너무 클 경우 관리자에게 문의 바랍니다.</li>
        <li><strong>Q:</strong> 비닐에 담지 않고 배출해도 되나요?<br><strong>A:</strong> 환경 보호를 위해 봉투에 담아 배출하시는 것을 권장합니다.</li>
        <li><strong>Q:</strong> 옷 개수 제한이 있나요?<br><strong>A:</strong> 일일 배출량에 제한은 없으나, 과도한 경우 관리자에게 알려주세요.</li>
        <li><strong>Q:</strong> 전자제품은 함께 배출 가능한가요?<br><strong>A:</strong> 전자제품 전용 수거함을 이용해 주세요.</li>
      </ul>
    </div>

    <!-- 주의 사항 섹션 -->
    <div class="section">
      <h2>주의 사항</h2>
      <ul>
        <li>수거함 문을 막거나 파손하지 마세요.</li>
        <li>생활 폐기물이나 음식물은 섞어 배출하지 마세요.</li>
        <li>야간이나 운영 시간 외에는 물품을 놓지 마세요.</li>
        <li>화재 위험 물질은 절대 배출하지 마세요.</li>
        <li>문의 시 전화: <?= esc($bin['Managing Institution Phone Number']) ?>.</li>
      </ul>
    </div>

    <!-- 지도 섹션 -->
    <div id="map"></div>
  </div>

  <?php include APPPATH . 'Views/includes/footer.php'; ?>

  <script>
    (function(){
      var lat = parseFloat("<?= esc($bin['Latitude']) ?>");
      var lng = parseFloat("<?= esc($bin['Longitude']) ?>");
      var map = new naver.maps.Map('map', { center: new naver.maps.LatLng(lat, lng), zoom:16 });
      new naver.maps.Marker({ position: map.getCenter(), map: map, title: "<?= esc($bin['Clothing Collection Bin Location Name']) ?>" });
    })();
  </script>
</body>
</html>
