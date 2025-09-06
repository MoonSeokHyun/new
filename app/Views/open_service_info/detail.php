<!-- app/Views/open_service_info/detail.php -->
<?php
// 안전 초기화
$shopName      = esc($shop['BusinessName'] ?? '안경점');
$area          = esc($shop['Area'] ?? '');
$roadAddress   = esc($shop['RoadAddress'] ?? '');
$fullAddress   = esc($shop['FullAddress'] ?? '');

// 구·읍·면 추출 (주소에서 구/읍/면 단위 추출)
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/', $fullAddress, $m);
$district      = $m[0] ?? '지역';

// SEO용 메타
$seoTitle       = esc("{$shopName} {$district} 안경점 상세정보 | 위치・서비스・시설");
$seoDescription = esc("{$shopName} 안경점의 위치 ({$district} {$fullAddress}), 제공 서비스 및 장비 목록을 확인하세요.");
$seoKeywords    = esc("안경점, {$shopName}, {$district}, {$fullAddress}, 서비스, 장비");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $seoTitle ?></title>

    <!-- SEO 메타 태그 -->
    <meta name="description" content="<?= $seoDescription ?>" />
    <meta name="keywords" content="<?= $seoKeywords ?>" />
    <meta name="author" content="안경점 정보 제공" />

    <!-- Open Graph -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= $seoTitle ?>" />
    <meta property="og:description" content="<?= $seoDescription ?>" />
    <meta property="og:url" content="<?= current_url() ?>" />
    <meta property="og:locale" content="ko_KR" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?= $seoTitle ?>" />
    <meta name="twitter:description" content="<?= $seoDescription ?>" />

    <!-- 네이버 지도 API -->
    <!-- <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script> -->

    <style>
        body { background: #f5f5f5; font-family: 'Noto Sans KR', sans-serif; color: #333; margin: 0; padding: 0; }
        a { color: #0078ff; text-decoration: none; }
        .container { max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .content-title { font-size: 2rem; margin-bottom: .5rem; border-bottom: 2px solid #0078ff; padding-bottom: .3rem; }
        .breadcrumb { font-size: .9rem; color: #555; margin-bottom: 1.5rem; }
        .ad-box { margin: 1.5rem 0; text-align: center; }
        .section { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); margin-bottom: 1.5rem; padding: 1.5rem; }
        .section h2 { font-size: 1.2rem; margin-bottom: 1rem; color: #0078ff; border-left: 4px solid #0078ff; padding-left: .5rem; }
        .detail-list { margin: 0; padding: 0; }
        .detail-item { display: flex; justify-content: space-between; padding: .75rem 0; border-bottom: 1px solid #eee; }
        .detail-item:last-child { border-bottom: none; }
        .label { font-weight: 600; color: #333; }
        .value { color: #555; text-align: right; }
        #map { width: 100%; height: 300px; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); }
        @media (max-width: 768px) {
            .content-title { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

  <?php include APPPATH . 'Views/includes/header.php'; ?>

  <div class="container">
    <h1 class="content-title"><?= $shopName ?> 👓</h1>

    <div class="breadcrumb">
      <a href="<?= site_url() ?>">홈</a> &gt;
      <a href="<?= site_url('shops') ?>">안경점 목록</a> &gt;
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
        <div class="detail-item"><div class="label">안경점 이름</div><div class="value"><?= $shopName ?></div></div>
        <div class="detail-item"><div class="label">지역</div><div class="value"><?= $area ?></div></div>
        <div class="detail-item"><div class="label">도로명 주소</div><div class="value"><?= $roadAddress ?></div></div>
        <div class="detail-item"><div class="label">지번 주소</div><div class="value"><?= $fullAddress ?></div></div>
        <div class="detail-item"><div class="label">전화번호</div><div class="value"><?= esc($shop['PhoneNumber']) ?></div></div>
        <div class="detail-item"><div class="label">업종</div><div class="value"><?= esc($shop['BusinessTypeName']) ?></div></div>
      </div>
    </div>

    <!-- 장비 및 시설 -->
    <div class="section">
      <h2>장비 및 시설</h2>
      <div class="detail-list">
        <div class="detail-item"><div class="label">시력표 수</div><div class="value"><?= esc($shop['EyeChartCount']) ?></div></div>
        <div class="detail-item"><div class="label">렌즈 샘플 수</div><div class="value"><?= esc($shop['LensSampleCount']) ?></div></div>
        <div class="detail-item"><div class="label">측정 의자 수</div><div class="value"><?= esc($shop['MeasurementChairCount']) ?></div></div>
        <div class="detail-item"><div class="label">동공거리 측정기 수</div><div class="value"><?= esc($shop['PupilDistanceMeterCount']) ?></div></div>
        <div class="detail-item"><div class="label">자동굴절계 수</div><div class="value"><?= esc($shop['AutoRefractometerCount']) ?></div></div>
        <div class="detail-item"><div class="label">연마기 수</div><div class="value"><?= esc($shop['LensGrinderCount']) ?></div></div>
        <div class="detail-item"><div class="label">커터 수</div><div class="value"><?= esc($shop['LensCutterCount']) ?></div></div>
        <div class="detail-item"><div class="label">히터 수</div><div class="value"><?= esc($shop['HeaterCount']) ?></div></div>
        <div class="detail-item"><div class="label">안경 세척기 수</div><div class="value"><?= esc($shop['EyeglassCleanerCount']) ?></div></div>
        <div class="detail-item"><div class="label">총 면적 (㎡)</div><div class="value"><?= esc($shop['TotalArea']) ?></div></div>
      </div>
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
    <!-- Q&A 섹션 -->
    <div class="section">
      <h2>자주 묻는 질문 (Q&A)</h2>
      <div class="detail-list">
        <div class="detail-item"><div class="label">Q1. 안경 맞추는 데 소요 시간은?</div><div class="value">약 30분 내외</div></div>
        <div class="detail-item"><div class="label">Q2. 예약이 필요한가요?</div><div class="value">예약 없이 방문 가능</div></div>
        <div class="detail-item"><div class="label">Q3. 렌즈 교체 서비스 있나요?</div><div class="value">네, 유료 서비스로 제공</div></div>
      </div>
    </div>

    <!-- 이용 후기 섹션 -->
    <div class="section">
      <h2>고객 이용 후기</h2>
      <div class="detail-list">
        <div class="detail-item"><div class="label">이**님</div><div class="value">“친절한 상담과 빠른 작업 감사합니다!”</div></div>
        <div class="detail-item"><div class="label">박**님</div><div class="value">“가격도 합리적이고 만족스러워요.”</div></div>
      </div>
    </div>

    <!-- 추천 제품 섹션 -->
    <div class="section">
      <h2>추천 제품</h2>
      <ul>
        <li>블루라이트 차단 렌즈 👓</li>
        <li>초경량 티타늄 프레임 안경테 🛠️</li>
        <li>프로페셔널 코팅 서비스 ✨</li>
      </ul>
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
    <!-- 지도 -->
    <div class="section">
      <h2>위치 지도</h2>
      <div id="map"></div>
    </div>
  </div><!-- /.container -->
  <div class="ad-box">
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-6686738239613464"
           data-ad-slot="1204098626"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
      <script>(adsbygoogle=window.adsbygoogle||[]).push({});</script>
    </div>
  <?php include APPPATH . 'Views/includes/footer.php'; ?>

  <script>
    (function(){
      var lat = parseFloat("<?= esc($shop['Latitude'] ?? '0') ?>");
      var lng = parseFloat("<?= esc($shop['Longitude'] ?? '0') ?>");
//       var map = new naver.maps.Map('map', {
//         center: new naver.maps.LatLng(lat, lng),
//         zoom: 16
//       });
//       new naver.maps.Marker({
//         position: map.getCenter(),
//         map: map,
//         title: "<?= $shopName ?>"
//       });
    })();
  </script>

</body>
</html>
