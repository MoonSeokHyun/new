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

// ✅ 컨트롤러에서 넘어온 좌표 사용
$latitude  = (is_numeric($latitude)  ? (float)$latitude  : null);
$longitude = (is_numeric($longitude) ? (float)$longitude : null);

// 구·읍·면 추출
$district_name = $district ?? '지역';
preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $lotAddr ?: $roadAddr, $m);
if (!$district_name || $district_name === '지역') {
    $district_name = $m[0] ?? '지역';
}

preg_match('/^(서울|부산|대구|인천|광주|대전|울산|세종|경기|강원|충북|충남|전북|전남|경북|경남|제주)[^\s]*/u', $roadAddr ?: $lotAddr, $m2);
$region_guess = $m2[0] ?? '대한민국';

// SEO용 메타
$seoTitle   = "{$facilityName} | {$district_name} 캠핑장 위치·편의시설·운영정보";
$seoDesc    = "{$district_name}에 위치한 {$facilityName} 캠핑장 정보. {$category} 카테고리, 편의시설 및 운영정보를 확인하고 네이버 지도로 위치도 바로 확인하세요.";
$canonical  = current_url();

// 네이버 지도 Key
$naverMapKeyId = getenv('NAVER_MAPS_API_KEY_ID') ?: 'c3hsihbnx3';

$nearby_campings = $nearby_campings ?? [];
$districtUrl = site_url('camping?district=' . urlencode($district_name));
$campingsUrl = site_url('camping');

// 네이버 지도 검색은 "주소만"
$mapQuery = trim(html_entity_decode($roadAddr ?: $lotAddr));
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
    <?php if ($latitude !== null && $longitude !== null): ?>
    "geo": {
      "@type": "GeoCoordinates",
      "latitude": <?= json_encode($latitude) ?>,
      "longitude": <?= json_encode($longitude) ?>
    },
    <?php endif; ?>
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

  <link rel="preconnect" href="https://oapi.map.naver.com" crossorigin>
  <link rel="preconnect" href="https://pagead2.googlesyndication.com" crossorigin>
  <link rel="preconnect" href="https://googleads.g.doubleclick.net" crossorigin>

  <?php if (!empty($naverMapKeyId)): ?>
  <script>
    window.navermap_authFailure = function () {
      console.error('네이버 지도 인증 실패: ncpKeyId 또는 Web 서비스 URL 등록을 확인하세요.');
    };
  </script>
  <script defer src="https://oapi.map.naver.com/openapi/v3/maps.js?ncpKeyId=<?= esc($naverMapKeyId) ?>"></script>
  <?php endif; ?>

  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>
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
  <div class="section" id="mapSection">
    <h2>지도</h2>
    <?php if ($latitude !== null && $longitude !== null): ?>
      <div id="map"></div>
      <p style="margin-top:.5rem; color:#666; font-size:.9rem;">
        표시 좌표(WGS84): 위도 <?= esc(number_format($latitude, 6)) ?> / 경도 <?= esc(number_format($longitude, 6)) ?>
      </p>
    <?php else: ?>
      <div style="padding:14px; border:1px dashed #cfd8ea; border-radius:12px; background:#fff;">
        <strong>좌표 정보가 없습니다.</strong><br>
        서버 지오코딩(API Key) 설정이 안 됐거나, 주소가 지오코딩 결과가 없는 형태일 수 있습니다.<br>
        <span style="color:#666; font-size:.9rem;">현재 주소: <?= esc($mapQuery ?: '없음') ?></span>
      </div>
    <?php endif; ?>
    <div style="margin-top:.5rem;">
      <a class="btn" id="naverDirections" href="#" target="_blank" rel="nofollow noopener" style="display:inline-flex; align-items:center; gap:.4rem; padding:.6rem .9rem; border-radius:10px; border:1px solid #dbe7ff; background:#fff; color:#0b3d91; font-weight:700; text-decoration:none;">네이버 지도에서 보기</a>
      <a class="btn" href="<?= $districtUrl ?>" style="display:inline-flex; align-items:center; gap:.4rem; padding:.6rem .9rem; border-radius:10px; border:1px solid #dbe7ff; background:#f7f9ff; color:#0b3d91; font-weight:700; text-decoration:none; margin-left:.5rem;">같은 지역 더 보기</a>
    </div>
  </div>

  <!-- 근처 캠핑장 -->
  <?php if (!empty($nearby_campings)): ?>
  <div class="section">
    <h2>근처 캠핑장 보기</h2>
    <div style="display:grid; grid-template-columns:1fr; gap:.6rem;">
      <?php foreach ($nearby_campings as $n): ?>
        <?php
          $nName = esc($n['FCLTY_NM'] ?? '캠핑장');
          $nUrl  = esc($n['url'] ?? '#');
          $nRoad = esc($n['RDNMADR_NM'] ?? '');
          $nLot  = esc($n['LNM_ADDR'] ?? '');
          $addr  = $nRoad ?: $nLot;
        ?>
        <div style="padding:.85rem 1rem; border:1px solid #eee; border-radius:12px; background:#fff;">
          <div style="font-weight:800; font-size:1rem; margin:0 0 .25rem;"><a href="<?= $nUrl ?>" style="color:#333; text-decoration:none;"><?= $nName ?></a></div>
          <div style="color:#666; font-size:.92rem; line-height:1.5;">
            <?php if ($addr): ?>주소: <?= $addr ?><?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
</div>

<?php include APPPATH.'Views/includes/footer.php'; ?>

<script>
(function(){
  // ✅ AdSense: 안전 push
  function pushAdsSafe(){
    try{
      var ins = document.querySelectorAll('ins.adsbygoogle');
      for (var i=0;i<ins.length;i++){
        if (!ins[i].getAttribute('data-adsbygoogle-status')) {
          (adsbygoogle = window.adsbygoogle || []).push({});
        }
      }
    }catch(e){}
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', pushAdsSafe);
  } else {
    pushAdsSafe();
  }

  // ✅ 네이버 지도 링크는 "주소만" 검색
  var qAddr = <?= json_encode($mapQuery) ?>;
  var el = document.getElementById("naverDirections");
  if (el) {
    el.href = "https://map.naver.com/v5/search/" + encodeURIComponent(qAddr || "");
  }

  // 좌표 있으면 지도 렌더
  var lat = <?= $latitude !== null ? json_encode($latitude) : 'null' ?>;
  var lng = <?= $longitude !== null ? json_encode($longitude) : 'null' ?>;

  function waitForNaver(cb, tries){
    tries = tries || 0;
    if (window.naver && naver.maps && naver.maps.Map) return cb();
    if (tries > 120) return;
    setTimeout(function(){ waitForNaver(cb, tries + 1); }, 100);
  }

  if (typeof lat === 'number' && typeof lng === 'number' && isFinite(lat) && isFinite(lng)) {
    waitForNaver(function(){
      var center = new naver.maps.LatLng(lat, lng);
      var map = new naver.maps.Map('map', { center: center, zoom: 16 });

      var marker = new naver.maps.Marker({
        position: center,
        map: map,
        title: <?= json_encode(html_entity_decode($facilityName)) ?>
      });

      var info = new naver.maps.InfoWindow({
        content:
          '<div style="padding:10px 12px; font-size:13px; line-height:1.4;">' +
          '<strong><?= esc($facilityName) ?></strong><br/>' +
          '<?= esc($roadAddr ?: $lotAddr) ?>' +
          '</div>'
      });

      naver.maps.Event.addListener(marker, "click", function(){
        if(info.getMap()) info.close();
        else info.open(map, marker);
      });
    });
  }
})();
</script>
</body>
</html>
