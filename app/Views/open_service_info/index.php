<?php
helper(['url']);

$request = service('request');
$search = isset($search) ? trim((string)$search) : '';
$page   = max(1, (int)($request->getGet('page') ?? ($page ?? 1)));
$isSearch = ($search !== '');
$isPaginated = ($page > 1);

$listUrl = site_url('open-service-info');

$canonical = $listUrl;

$seoTitle = ($search !== '')
  ? "{$search} 안경점 검색 결과 | 안경점 목록"
  : "안경점 목록 | 지역별 안경점 정보";

$seoDescParts = [];
if ($search !== '') $seoDescParts[] = "검색어: {$search}";
$seoDescParts[] = "전국 안경점 주소/전화번호/장비 정보를 확인하세요.";
$seoDescription = implode(' · ', $seoDescParts);

$robots = ($isSearch || $isPaginated) ? 'noindex,follow' : 'index,follow,max-image-preview:large';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title><?= esc($seoTitle) ?></title>
  <meta name="description" content="<?= esc($seoDescription) ?>" />
  <meta name="robots" content="<?= esc($robots) ?>" />
  <link rel="canonical" href="<?= esc($canonical) ?>" />
  <link rel="alternate" href="<?= esc($canonical) ?>" hreflang="ko" />

  <link rel="preconnect" href="https://pagead2.googlesyndication.com" crossorigin>
  <link rel="preconnect" href="https://googleads.g.doubleclick.net" crossorigin>

  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= esc($seoTitle) ?>" />
  <meta property="og:description" content="<?= esc($seoDescription) ?>" />
  <meta property="og:url" content="<?= esc($canonical) ?>" />
  <meta property="og:image" content="<?= esc(site_url('assets/og/og-default.jpg')) ?>" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:image:alt" content="퐁퐁코리아 - 전국 생활시설 정보 검색" />
  <meta name="twitter:image" content="<?= esc(site_url('assets/og/og-default.jpg')) ?>" />
  <meta property="og:locale" content="ko_KR" />

  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= esc($seoTitle) ?>" />
  <meta name="twitter:description" content="<?= esc($seoDescription) ?>" />

  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

  <?php include APPPATH . 'Views/includes/listing_theme.php'; ?>
</head>
<body class="listing-page">

<?php include APPPATH . 'Views/includes/header.php'; ?>

<div class="container">

  <div class="top">
    <div>
      <h1><?= esc($search !== '' ? "“{$search}” 검색 결과" : "안경점 목록") ?></h1>
      <p>주소/전화/장비 정보를 빠르게 확인하고 상세 페이지에서 지도와 근처 안경점도 보세요.</p>
    </div>

    <form class="search" method="get" action="<?= esc($listUrl) ?>">
      <input type="text" name="search" value="<?= esc($search) ?>" placeholder="안경점명/주소로 검색" />
      <button type="submit">검색</button>
    </form>
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
    <?php if (!empty($shops) && is_array($shops)): ?>
      <?php 
        $count = 0;
        foreach ($shops as $shop): 
          $count++;
      ?>
        <?php
          $id    = $shop['id'] ?? null;
          if (!$id) continue;

          $name  = esc($shop['BusinessName'] ?? '안경점');
          $addr  = esc($shop['RoadAddress'] ?? ($shop['FullAddress'] ?? ''));
          $phone = esc($shop['PhoneNumber'] ?? '');
          $type  = esc($shop['BusinessTypeName'] ?? '');
          $url   = site_url('open-service-info/detail/' . $id);
        ?>
        <a class="card" href="<?= esc($url) ?>">
          <h2 class="name"><?= $name ?></h2>
          <div class="meta">
            <?php if ($addr): ?>📍 <?= $addr ?><br><?php endif; ?>
            <?php if ($phone): ?>📞 <?= $phone ?><?php endif; ?>
          </div>
          <div class="chips">
            <?php if ($type): ?><span class="chip"><?= $type ?></span><?php endif; ?>
            <?php if ($shop['Area'] ?? ''): ?>
              <span class="chip"><?= esc($shop['Area']) ?></span>
            <?php endif; ?>
          </div>
        </a>
        
        <!-- 광고 중간 삽입 (6개 카드 후) -->
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
        검색 결과가 없습니다.
      </div>
    <?php endif; ?>
  </div>

  <!-- 광고(하단) -->
  <div class="ad">
    <ins class="adsbygoogle"
      style="display:block"
      data-ad-client="ca-pub-6686738239613464"
      data-ad-slot="1204098626"
      data-ad-format="auto"
      data-full-width-responsive="true"></ins>
  </div>
  <?php if (isset($pager) && $pager): ?>
    <div class="pager-wrap">
      <?= $pager->links('shops', 'default_full') ?>
    </div>
  <?php endif; ?>

</div>

<?php include APPPATH . 'Views/includes/footer.php'; ?>

<script>
(function(){
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
})();
</script>

</body>
</html>
