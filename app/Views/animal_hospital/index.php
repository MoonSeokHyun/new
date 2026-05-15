<?php
helper('url');

$request = service('request');
$search = trim((string)($search ?? ''));
$page = max(1, (int)($request->getGet('page') ?? 1));
$isSearch = ($search !== '');
$isPaginated = ($page > 1);
$listUrl = site_url('animal-hospital');

$canonical = $listUrl;

$title = $search !== ''
  ? "동물병원 검색: {$search} | 전국 동물병원 목록"
  : "전국 동물병원 목록 | 주소·상태·상세정보";

$desc  = $search !== ''
  ? "‘{$search}’ 관련 동물병원 목록입니다. 병원명/주소 기반으로 검색할 수 있고, 상세 페이지에서 지도와 정보를 확인할 수 있습니다."
  : "전국 동물병원 목록 페이지입니다. 병원명, 주소, 상태를 확인하고 상세 페이지에서 지도 및 정보를 확인할 수 있습니다.";

$robots = ($isSearch || $isPaginated) ? 'noindex,follow' : 'index,follow,max-image-preview:large';
?>
<!doctype html>
<html lang="ko">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title><?= esc($title) ?></title>
  <meta name="description" content="<?= esc($desc) ?>" />
  <meta name="robots" content="<?= esc($robots) ?>" />
  <link rel="canonical" href="<?= esc($canonical) ?>" />

  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= esc($title) ?>" />
  <meta property="og:description" content="<?= esc($desc) ?>" />
  <meta property="og:url" content="<?= esc($canonical) ?>" />
  <meta property="og:image" content="<?= esc(site_url('assets/og/og-default.jpg')) ?>" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:image:alt" content="퐁퐁코리아 - 전국 생활시설 정보 검색" />
  <meta name="twitter:image" content="<?= esc(site_url('assets/og/og-default.jpg')) ?>" />
  <meta property="og:locale" content="ko_KR" />

  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= esc($title) ?>" />
  <meta name="twitter:description" content="<?= esc($desc) ?>" />

  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

  <?php include APPPATH . 'Views/includes/listing_theme.php'; ?>
</head>
<body class="listing-page">
<?php include APPPATH . 'Views/includes/header.php'; ?>

<div class="container">
  <div class="hero">
    <div>
      <h1><?= esc($search !== '' ? "동물병원 검색 결과" : "전국 동물병원 목록") ?></h1>
      <p><?= esc($desc) ?></p>
    </div>

    <form class="search" method="get" action="<?= esc(site_url('animal-hospital')) ?>">
      <input type="text" name="search" value="<?= esc($search) ?>" placeholder="병원명/주소로 검색 (예: 강남, 삼청동, OO동물병원)" />
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
    <?php if (!empty($hospitals)): ?>
      <?php 
        $count = 0;
        foreach (($hospitals ?? []) as $h): 
          $count++;
      ?>
        <?php
          $name = esc($h['b_name'] ?? '동물병원');
          $addr = esc(($h['new_address'] ?? '') ?: ($h['old_address'] ?? ''));
          $st   = esc($h['b_status'] ?? '');
          $url  = site_url('animal-hospital/detail/' . ($h['id'] ?? 0));
        ?>
        <div class="card">
          <div class="name"><?= $name ?></div>
          <div class="meta">📍 <?= $addr ?: '-' ?></div>
          <?php if ($st): ?><div class="pill">상태: <?= $st ?></div><?php endif; ?>
          <div class="actions">
            <a class="btn primary" href="<?= esc($url) ?>">상세 보기</a>
            <?php if ($addr): ?>
              <a class="btn" href="<?= esc(site_url('animal-hospital') . '?search=' . urlencode($addr)) ?>" rel="nofollow">주소로 더 찾기</a>
            <?php endif; ?>
          </div>
        </div>
        
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
        <div class="name">검색 결과가 없습니다.</div>
        <div class="meta">다른 지역명이나 병원명으로 다시 검색해보세요.</div>
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
    <div class="pager-wrap pagination">
      <?= $pager->links('hospitals', 'default_full') ?>
    </div>
  <?php endif; ?>

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
  // ✅ AdSense push 안전 처리(중복 push 방지)
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
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', pushAdsSafe);
  else pushAdsSafe();

  // ✅ pagination 링크에 search 유지(템플릿/설정과 무관하게 강제 유지)
  var search = <?= json_encode($search) ?>;
  if (search) {
    var links = document.querySelectorAll('.pagination a[href]');
    links.forEach(function(a){
      try{
        var u = new URL(a.href, window.location.origin);
        u.searchParams.set('search', search);
        a.href = u.toString();
      }catch(e){}
    });
  }
})();
</script>
</body>
</html>
