<?php
helper('url');
$canonical = site_url('camping');
$seoTitle = '캠핑장 목록 | 지역별 캠핑장 정보';
$seoDesc = '전국 캠핑장 주소와 최신 업데이트 정보를 확인하고 상세 페이지에서 위치와 주변 정보를 확인하세요.';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($seoTitle) ?></title>
    <meta name="description" content="<?= esc($seoDesc) ?>" />
    <meta name="robots" content="index,follow,max-image-preview:large" />
    <link rel="canonical" href="<?= esc($canonical) ?>" />
    <link rel="alternate" href="<?= esc($canonical) ?>" hreflang="ko" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= esc($seoTitle) ?>" />
    <meta property="og:description" content="<?= esc($seoDesc) ?>" />
    <meta property="og:url" content="<?= esc($canonical) ?>" />
    <meta property="og:image" content="<?= esc(site_url('assets/og/og-default.jpg')) ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:alt" content="퐁퐁코리아 - 전국 생활시설 정보 검색" />
    <meta name="twitter:image" content="<?= esc(site_url('assets/og/og-default.jpg')) ?>" />
    <meta property="og:locale" content="ko_KR" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= esc($seoTitle) ?>" />
    <meta name="twitter:description" content="<?= esc($seoDesc) ?>" />

    <!-- 네이버 지도 API (필요 없으시면 제거) -->
    <!-- <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script> -->
  
    <!-- 광고 스크립트 -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>
    <?php include APPPATH . 'Views/includes/listing_theme.php'; ?>
</head>
<body class="listing-page">

<?php include APPPATH . 'Views/includes/header.php'; ?>

<div class="container">
  <div class="hero">
    <div>
      <h1>캠핑장 목록</h1>
      <p>전국 캠핑장 주소와 최신 업데이트 정보를 한눈에 확인하고, 상세 페이지에서 위치와 주변 시설까지 이어서 탐색할 수 있습니다.</p>
      <div class="listing-meta-bar">
        <span class="listing-meta-pill">최신 12개 기준</span>
        <span class="listing-meta-pill">공공데이터 기반</span>
      </div>
    </div>
  </div>

  <div class="ad">
    <ins class="adsbygoogle"
      style="display:block"
      data-ad-client="ca-pub-6686738239613464"
      data-ad-slot="1204098626"
      data-ad-format="auto"
      data-full-width-responsive="true"></ins>
  </div>

  <div class="grid">
    <?php if (!empty($campings)): ?>
      <?php 
        $count = 0;
        foreach ($campings as $camping): 
          $count++;
      ?>
        <?php
          $id = $camping['id'] ?? 0;
          $name = esc($camping['FCLTY_NM'] ?? '캠핑장');
          $addr = esc(($camping['RDNMADR_NM'] ?? '') ?: ($camping['LNM_ADDR'] ?? ''));
          $updatedAt = esc($camping['LAST_UPDT_DE'] ?? '');
          $manage = esc($camping['MNG_INSTT_NM'] ?? '');
        ?>
        <a class="card" href="<?= esc(site_url('camping/' . $id)) ?>">
          <h2 class="name"><?= $name ?></h2>
          <div class="meta">
            <?php if ($addr): ?>📍 <?= $addr ?><br><?php endif; ?>
            <?php if ($updatedAt): ?>🕒 최근 갱신: <?= $updatedAt ?><?php endif; ?>
          </div>
          <div class="chips">
            <?php if ($manage): ?><span class="chip"><?= $manage ?></span><?php endif; ?>
            <?php if ($updatedAt): ?><span class="chip">업데이트 <?= $updatedAt ?></span><?php endif; ?>
          </div>
        </a>
        
        <?php if ($count === 6): ?>
          <div class="ad" style="grid-column:1/-1; margin:1rem 0;">
            <ins class="adsbygoogle"
              style="display:block"
              data-ad-client="ca-pub-6686738239613464"
              data-ad-slot="1204098626"
              data-ad-format="auto"
              data-full-width-responsive="true"></ins>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="card empty-state">
        <div class="name">표시할 캠핑장이 없습니다.</div>
        <div class="meta">데이터가 준비되면 이 영역에 최신 캠핑장 목록이 노출됩니다.</div>
      </div>
    <?php endif; ?>
  </div>

  <div class="ad">
    <ins class="adsbygoogle"
      style="display:block"
      data-ad-client="ca-pub-6686738239613464"
      data-ad-slot="1204098626"
      data-ad-format="auto"
      data-full-width-responsive="true"></ins>
  </div>
</div>

<?php include APPPATH . 'Views/includes/footer.php'; ?>

<script>
(function(){
  function pushAdsSafe(){
    try{
      var ins = document.querySelectorAll('ins.adsbygoogle');
      for (var i = 0; i < ins.length; i++){
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
})();
</script>

</body>
</html>
