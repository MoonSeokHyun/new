<?php
// 안전한 변수 초기화
$installationName = esc($installation['Installation Location Name'] ?? '기본 설치장소');
$fullAddress = esc($installation['Street Address'] ?? '');

// District Name을 안전하게 처리하고 기본값 설정
$districtName = esc($installation['District Name'] ?? '');  // District Name을 안전하게 처리
$districtNameForTitle = $districtName ?: '인근';  // 타이틀에 사용할 값 설정 (빈 값이면 '인근'으로 대체)

// SEO 최적화용 타이틀과 설명 설정
$seoTitle = esc("{$installationName} {$districtNameForTitle} 폐의약품수거장소");
$seoDescription = esc("{$installationName}의 설치장소 상세 정보와 위치, 전화번호, 관리 기관 등을 확인해보세요. {$districtNameForTitle}에 위치한 설치장소입니다.");
$seoKeywords = esc("설치장소, {$installationName}, 폐의약품, {$districtNameForTitle}, {$fullAddress}");
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
    .section{ background:#fff; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.1); margin-bottom:1.5rem; padding:1.5rem; }
    .section h2{ font-size:1.2rem; margin-bottom:1rem; color:#0078ff; border-left:4px solid #0078ff; padding-left:.5rem; }
    .detail-list{ margin:0; padding:0; }
    .detail-item{ display:flex; justify-content:space-between; padding:.75rem 0; border-bottom:1px solid #eee; }
    .detail-item:last-child{ border-bottom:none; }
    .label{ font-weight:600; color:#333; }
    .value{ color:#555; text-align:right; }
    #map{ width:100%; height:300px; border-radius:8px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.1); }
    ul { margin-left:1.2rem; }
    @media (max-width: 768px) {
      .container{ padding:0 1rem; }
      #map{ height:200px; }
    }
  </style>
</head>
<body>

  <?php include APPPATH . 'Views/includes/header.php'; ?>

  <div class="container">
    <h1 class="content-title"><?= esc($installationName) ?> <?= esc($districtNameForTitle) ?> 폐의약품수거장소</h1>
    <div class="breadcrumb">
      <a href="<?= site_url() ?>">홈</a> &gt;
      <a href="<?= site_url('installations') ?>">수거장소 목록</a> &gt;
      상세정보
    </div>

    <div class="ad-box">
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-6686738239613464"
           data-ad-slot="1204098626"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
      <script>(adsbygoogle=window.adsbygoogle||[]).push({});</script>
    </div>

    <!-- 기본 정보 -->
    <div class="section">
      <h2>기본 정보</h2>
      <div class="detail-list">
        <div class="detail-item"><div class="label">설치장소명</div><div class="value"><?= esc($installation['Installation Location Name']) ?></div></div>
        <div class="detail-item"><div class="label">구·읍·면</div><div class="value"><?= esc($districtName ?: '인근') ?></div></div>
        <div class="detail-item"><div class="label">도로명 주소</div><div class="value"><?= esc($installation['Street Address']) ?></div></div>
        <div class="detail-item"><div class="label">지번 주소</div><div class="value"><?= esc($installation['Land Lot Address']) ?></div></div>
        <div class="detail-item"><div class="label">전화번호</div><div class="value"><?= esc($installation['Managing Institution Phone Number']) ?></div></div>
        <div class="detail-item"><div class="label">관리 기관명</div><div class="value"><?= esc($installation['Managing Institution Name']) ?></div></div>
        <div class="detail-item"><div class="label">데이터 기준일자</div><div class="value"><?= esc($installation['Data Reference Date']) ?></div></div>
      </div>
    </div>

    <!-- 수거 안내 섹션 -->
    <div class="section">
      <h2>폐의약품 수거 안내</h2>
      <ul>
        <li>유효기간 경과 약품, 복용 후 남은 약, 사용 중 변경된 처방약은 모두 폐의약품입니다.</li>
        <li>일반 쓰레기와 섞이지 않도록 용기에 담아 반납해 주세요.</li>
        <li>약봉지나 겉포장에 개인정보가 있을 경우, 미리 가린 후 배출해 주세요.</li>
        <li>가루약, 시럽약 등 종류별로 분리하여 밀봉하여 주시면 수거 및 처리 과정에 도움이 됩니다.</li>
        <li>수거함이 가득 찼을 경우, 가까운 다른 수거장소를 이용해 주세요.</li>
      </ul>
    </div>

    <!-- 수거 가능 품목 -->
    <div class="section">
      <h2>수거 가능 품목</h2>
      <ul>
        <li>정제(알약), 캡슐 형태 약품</li>
        <li>시럽형, 액상형 약품</li>
        <li>가루약, 분말형 약품</li>
        <li>안약, 점안액</li>
        <li>연고, 크림, 패치형 약품</li>
      </ul>
    </div>

    <!-- 이용 방법 -->
    <div class="section">
      <h2>이용 방법</h2>
      <ol>
        <li>운영시간 확인: 운영 시간과 휴무일을 사전에 확인합니다.</li>
        <li>포장 준비: 원래 용기 혹은 밀봉 가능한 비닐에 담아 준비합니다.</li>
        <li>장소 방문: 해당 수거함 앞에 약품을 넣고, 문을 닫아 주세요.</li>
        <li>리뷰 작성: 필요시 관리자 연락처로 문의하거나 피드백을 남길 수 있습니다.</li>
        <li>다음 이용: 주기적으로 집에 남은 약을 정리하여 재방문합니다.</li>
      </ol>
    </div>

    <!-- 자주 묻는 질문 -->
    <div class="section">
      <h2>자주 묻는 질문(FAQ)</h2>
      <ul>
        <li><strong>Q:</strong> 처방전도 함께 버려도 되나요?<br><strong>A:</strong> 처방전은 개인정보 보호를 위해 버리지 말고 폐의약품과 분리해 주세요.</li>
        <li><strong>Q:</strong> 알약을 으깨서 버려도 되나요?<br><strong>A:</strong> 가능하면 원형 그대로 배출해 주시고, 부득이하게 분쇄 시 밀봉을 철저히 해 주세요.</li>
        <li><strong>Q:</strong> 주말에도 이용할 수 있나요?<br><strong>A:</strong> 운영 시간은 설치 기관별로 상이하니 반드시 확인 후 방문하세요.</li>
        <li><strong>Q:</strong> 유리병 약품은 어떻게 처리하나요?<br><strong>A:</strong> 유리 용기는 깨지지 않도록 포장해 주시고, 수거함 내 지정된 구역에 배출해 주세요.</li>
        <li><strong>Q:</strong> 사용 중인 약도 반납 가능한가요?<br><strong>A:</strong> 남은 약을 반납하는 용도로만 사용하며, 개봉 후 사용 중인 약도 가능하나 안전하게 포장해 주세요.</li>
      </ul>
    </div>

    <!-- 주의 사항 -->
    <div class="section">
      <h2>주의 사항</h2>
      <ul>
        <li>운영 시간 외에 약품을 가져다 놓지 말아 주세요.</li>
        <li>수거함 문을 강제로 열거나 파손하지 마세요.</li>
        <li>약품 외 다른 물품(전자레인지식품, 음식물 등)은 버리지 마세요.</li>
        <li>어린이의 손이 닿지 않는 위치에서 이용해 주세요.</li>
        <li>비상 시 관리 기관에 즉시 연락해 주세요: <?= esc($installation['Managing Institution Phone Number']) ?>.</li>
      </ul>
    </div>

    <!-- 참고 자료 -->
    <div class="section">
      <h2>참고 자료</h2>
      <ul>
        <li><a href="https://www.env.go.kr/" target="_blank">환경부 폐의약품 관리 지침</a></li>
        <li><a href="https://www.korea.kr/" target="_blank">정부24 생활폐기물 정보</a></li>
        <li><a href="https://www.who.int/" target="_blank">WHO 약품 폐기 가이드</a></li>
        <li><a href="https://www.pharm.or.kr/" target="_blank">대한약사회 자료실</a></li>
        <li><a href="https://www.nih.go.kr/" target="_blank">국립보건연구원 연구보고서</a></li>
      </ul>
    </div>

    <!-- 지도 -->
    <div class="section">
      <h2>지도</h2>
      <div id="map"></div>
    </div>
  </div><!-- /.container -->

  <?php include APPPATH . 'Views/includes/footer.php'; ?>

  <script>
    (function(){
      var lat = parseFloat("<?= esc($installation['Latitude']) ?>");
      var lng = parseFloat("<?= esc($installation['Longitude']) ?>");
//       var map = new naver.maps.Map('map', {
//         center: new naver.maps.LatLng(lat, lng),
//         zoom: 16
//       });
//       new naver.maps.Marker({
//         position: map.getCenter(),
//         map: map,
//         title: "<?= esc($installation['Installation Location Name']) ?>"
//       });
    })();
  </script>
</body>
</html>