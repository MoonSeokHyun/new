<?php
// 안전 초기화
$facilityName    = esc($camping['FCLTY_NM']           ?? '캠핑장');
$manageBy        = esc($camping['MANAGE_MBY_NM']      ?? '');
$lastUpdated     = esc($camping['LAST_UPDT_DE']       ?? '');
$category        = esc("{$camping['CTGRY_ONE_NM']} / {$camping['CTGRY_TWO_NM']} / {$camping['CTGRY_THREE_NM']}");
$prov            = esc($camping['CTPRVN_NM']          ?? '');
$sigungu         = esc($camping['SIGNGU_NM']          ?? '');
$legalDong       = esc($camping['LEGALDONG_NM']       ?? '');
$li              = esc($camping['LI_NM']              ?? '');
$lotNo           = esc($camping['LNBR_NO']           ?? '');
$road            = esc($camping['ROAD_NM']            ?? '');
$buldNo          = esc($camping['BULD_NO']           ?? '');
$zip             = esc($camping['ZIP_NO']             ?? '');
$roadAddr        = esc($camping['RDNMADR_NM']         ?? '');
$lotAddr         = esc($camping['LNM_ADDR']           ?? '');
$tel             = esc($camping['TEL_NO']             ?? '');
$url             = esc($camping['HMPG_URL']           ?? '');
$lat             = esc($camping['LC_LA']              ?? '0');
$lng             = esc($camping['LC_LO']              ?? '0');

// 구·읍·면 추출
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/', $lotAddr, $m);
$district        = $m[0] ?? '지역';

// SEO용 메타
$seoTitle   = "{$facilityName} 캠핑장 – {$district} {$roadAddr} | 편의시설·운영정보";
$seoDesc    = "{$facilityName} 캠핑장의 위치({$district} {$roadAddr}), 카테고리({$category}), 편의시설 및 운영정보를 확인하세요.";
$canonical  = current_url();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title><?= esc($seoTitle) ?></title>
  <meta name="description" content="<?= esc($seoDesc) ?>">
  <meta name="keywords" content="캠핑장, <?= esc($facilityName) ?>, <?= esc($district) ?>, <?= esc($category) ?>">
  <meta name="robots" content="index,follow">
  <link rel="canonical" href="<?= esc($canonical) ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Open Graph -->
  <meta property="og:type"        content="website">
  <meta property="og:title"       content="<?= esc($seoTitle) ?>">
  <meta property="og:description" content="<?= esc($seoDesc) ?>">
  <meta property="og:url"         content="<?= esc($canonical) ?>">
  <meta property="og:locale"      content="ko_KR">

  <!-- Twitter Card -->
  <meta name="twitter:card"        content="summary">
  <meta name="twitter:title"       content="<?= esc($seoTitle) ?>">
  <meta name="twitter:description" content="<?= esc($seoDesc) ?>">

  <!-- 구조화된 데이터 (JSON‑LD) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Campground",
    "name": "<?= esc($facilityName) ?>",
    "description": "<?= esc($seoDesc) ?>",
    "url": "<?= esc($canonical) ?>",
    "telephone": "<?= esc($tel) ?>",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "<?= esc($district) ?>",
      "streetAddress": "<?= esc($roadAddr) ?> <?= esc($lotAddr) ?>"
    },
    "geo": {
      "@type": "GeoCoordinates",
      "latitude": "<?= esc($lat) ?>",
      "longitude": "<?= esc($lng) ?>"
    },
    "openingHoursSpecification": [
      <?php
        $days = ['Mo','Tu','We','Th','Fr','Sa','Su'];
        $fields = ['WORKDAY_OPER_AT','WORKDAY_OPER_AT','WORKDAY_OPER_AT','WORKDAY_OPER_AT','WORKDAY_OPER_AT','WKEND_OPER_AT','WKEND_OPER_AT'];
        $specs = [];
        foreach($days as $i=>$day) {
          if( esc($camping[$fields[$i]]) === 'Y' ) {
            $specs[] = [
              "@type"=>"OpeningHoursSpecification",
              "dayOfWeek"=>"https://schema.org/{$day}",
              "opens"=>"00:00",
              "closes"=>"24:00"
            ];
          }
        }
        echo implode(",", array_map(function($s){ return json_encode($s,JSON_UNESCAPED_UNICODE); }, $specs));
      ?>
    ]
  }
  </script>

  <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
  <style>
    body { background:#f5f5f5; font-family:'Noto Sans KR',sans-serif; margin:0; padding:0; color:#333; }
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
    .label{ font-weight:600; }
    .value{ color:#555; text-align:right; }
    #map{ width:100%; height:300px; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.1); }
  </style>
</head>
<body>

<?php include APPPATH.'Views/includes/header.php'; ?>

<div class="container">
  <h1 class="content-title"><?= $facilityName ?></h1>
  <div class="breadcrumb">
    <a href="<?= site_url() ?>">홈</a> &gt;
    <a href="<?= site_url('camping') ?>">캠핑장 목록</a> &gt;
    상세정보
  </div>

  <div class="ad-box">
    <ins class="adsbygoogle" style="display:block"
         data-ad-client="ca-pub-6686738239613464"
         data-ad-slot="1204098626"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>(adsbygoogle=window.adsbygoogle||[]).push({});</script>
  </div>

  <!-- 기본 -->
  <div class="section">
    <h2>기본 정보</h2>
    <div class="detail-list">
      <div class="detail-item"><div class="label">시설명</div><div class="value"><?= $facilityName ?></div></div>
      <div class="detail-item"><div class="label">관리주체</div><div class="value"><?= $manageBy ?></div></div>
      <div class="detail-item"><div class="label">카테고리</div><div class="value"><?= $category ?></div></div>
      <div class="detail-item"><div class="label">최종 업데이트</div><div class="value"><?= $lastUpdated ?></div></div>
    </div>
  </div>

  <!-- 주소 -->
  <div class="section">
    <h2>주소 및 위치</h2>
    <div class="detail-list">
      <div class="detail-item"><div class="label">시도·시군구</div><div class="value"><?= "{$prov} {$sigungu}" ?></div></div>
      <div class="detail-item"><div class="label">법정동·리</div><div class="value"><?= "{$legalDong} {$li}" ?></div></div>
      <div class="detail-item"><div class="label">지번</div><div class="value"><?= "{$lotNo} ({$lotAddr})" ?></div></div>
      <div class="detail-item"><div class="label">도로명</div><div class="value"><?= "{$road} {$buldNo} ({$roadAddr})" ?></div></div>
      <div class="detail-item"><div class="label">우편번호</div><div class="value"><?= $zip ?></div></div>
    </div>
  </div>

  <!-- 연락 -->
  <div class="section">
    <h2>연락처</h2>
    <div class="detail-list">
      <div class="detail-item"><div class="label">전화번호</div><div class="value"><?= $tel ?></div></div>
      <div class="detail-item"><div class="label">홈페이지</div><div class="value"><a href="<?= $url ?>" target="_blank"><?= $url ?></a></div></div>
    </div>
  </div>

  <!-- 운영 -->
  <div class="section">
    <h2>운영 정보</h2>
    <div class="detail-list">
      <div class="detail-item"><div class="label">주중운영</div><div class="value"><?= esc($camping['WORKDAY_OPER_AT']) ?></div></div>
      <div class="detail-item"><div class="label">주말운영</div><div class="value"><?= esc($camping['WKEND_OPER_AT']) ?></div></div>
      <div class="detail-item"><div class="label">봄운영</div><div class="value"><?= esc($camping['SPR_OPER_AT']) ?></div></div>
      <div class="detail-item"><div class="label">여름운영</div><div class="value"><?= esc($camping['SUMR_OPER_AT']) ?></div></div>
      <div class="detail-item"><div class="label">가을운영</div><div class="value"><?= esc($camping['FALL_OPER_AT']) ?></div></div>
      <div class="detail-item"><div class="label">겨울운영</div><div class="value"><?= esc($camping['WNT_OPER_AT']) ?></div></div>
    </div>
  </div>

  <!-- 편의 -->
  <div class="section">
    <h2>편의 시설</h2>
    <div class="detail-list">
      <?php 
      $amen = [
        '전기제공'=>$camping['ELECT_PROVD_AT'],
        '온수제공'=>$camping['HWATER_PROVD_AT'],
        'WiFi'=>$camping['WIFI_HOLD_AT'],
        '장작판매'=>$camping['FWOOD_SLE_AT'],
        '산책로'=>$camping['WLK_ROAD_AT'],
        '물놀이장'=>$camping['WATERPARK_HOLD_AT'],
        '놀이시설'=>$camping['PLY_FCLTY_HOLD_AT'],
        '매점'=>$camping['MART_HOLD_AT'],
      ];
      foreach($amen as $lbl=>$fld): ?>
        <div class="detail-item"><div class="label"><?= $lbl ?></div><div class="value"><?= esc($fld) ?></div></div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- 개수 -->
  <div class="section">
    <h2>시설 개수</h2>
    <div class="detail-list">
      <div class="detail-item"><div class="label">화장실 수</div><div class="value"><?= esc($camping['TOILET_CO']) ?></div></div>
      <div class="detail-item"><div class="label">샤워실 수</div><div class="value"><?= esc($camping['SHWERRM_CO']) ?></div></div>
      <div class="detail-item"><div class="label">개수대 수</div><div class="value"><?= esc($camping['SINK_CO']) ?></div></div>
      <div class="detail-item"><div class="label">페트병 수거함 수</div><div class="value"><?= esc($camping['FETGS_CO']) ?></div></div>
    </div>
  </div>

  <!-- 기타시설 -->
  <div class="section">
    <h2>기타 시설</h2>
    <div class="detail-list">
      <?php 
      $other = [
        '낚시터'=>$camping['CFR_FSHNG_FCLTY_AT'],
        '산책로시설'=>$camping['CFR_WLK_ROAD_FCLTY_AT'],
        '해수욕장'=>$camping['CFR_BEACH_FCLTY_AT'],
        '유원시설'=>$camping['CFR_PRIZE_LSR_FCLTY_AT'],
        '물놀이장'=>$camping['CFR_VALL_FCLTY_AT'],
        '하천'=>$camping['CFR_RIVER_FCLTY_AT'],
        '수영장'=>$camping['CFR_POOL_FCLTY_AT'],
        '어린이체험'=>$camping['CFR_YNGBGS_EXPRN_FCLTY_AT'],
        '가족체험'=>$camping['CFR_FAFV_EXPRN_FCLTY_AT'],
        '어린이놀이'=>$camping['CFR_CHILD_PLY_FCLTY_AT'],
      ];
      foreach($other as $lbl=>$fld): ?>
        <div class="detail-item"><div class="label"><?= $lbl ?></div><div class="value"><?= esc($fld) ?></div></div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- 글램핑 -->
  <div class="section">
    <h2>글램핑 옵션</h2>
    <div class="detail-list">
      <?php 
      $glamp = [
        '침대'=>$camping['GLAMPING_BED_HOLD_AT'],
        'TV'=>$camping['GLAMPING_TV_HOLD_AT'],
        '냉장고'=>$camping['GLAMPING_FRIDGE_HOLD_AT'],
        'WiFi'=>$camping['GLAMPING_WIFI_HOLD_AT'],
        '실내화장실'=>$camping['GLAMPING_IN_TOILET_HOLD_AT'],
        '에어컨'=>$camping['GLAMPING_AC_HOLD_AT'],
        '난방'=>$camping['GLAMPING_HEATER_HOLD_AT'],
        '취사도구'=>$camping['GLAMPING_CKNG_TOOL_HOLD_AT'],
      ];
      foreach($glamp as $lbl=>$fld): ?>
        <div class="detail-item"><div class="label"><?= $lbl ?></div><div class="value"><?= esc($fld) ?></div></div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- 설명 -->
  <div class="section">
    <h2>추가 정보</h2>
    <div class="detail-list">
      <div class="detail-item"><div class="label">기타 편의시설</div><div class="value"><?= nl2br(esc($camping['ETC_FCLTY_DC'])) ?></div></div>
      <div class="detail-item"><div class="label">시설 소개</div><div class="value"><?= nl2br(esc($camping['FCLTY_INTRCN_CN'])) ?></div></div>
    </div>
  </div>

  <!-- 지도 -->
  <div class="section">
    <h2>지도</h2>
    <div id="map"></div>
  </div>
</div>

<?php include APPPATH.'Views/includes/footer.php'; ?>

<script>
  (function(){
    var map = new naver.maps.Map('map', {
      center: new naver.maps.LatLng(parseFloat("<?= $lat ?>"), parseFloat("<?= $lng ?>")),
      zoom: 16
    });
    new naver.maps.Marker({
      position: map.getCenter(),
      map: map,
      title: "<?= $facilityName ?>"
    });
  })();
</script>
</body>
</html>
