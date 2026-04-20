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

  <style>
    :root{
      --bg:#f6f8fc; --card:#fff; --txt:#1f2937; --sub:#6b7280;
      --pri:#2563eb; --pri2:#1d4ed8; --bd:#e5e7eb; --r:16px;
    }
    *{box-sizing:border-box}
    body{margin:0; font-family:system-ui,-apple-system,'Noto Sans KR',sans-serif; background:var(--bg); color:var(--txt);}
    a{color:inherit; text-decoration:none;}
    .container{max-width:1100px; margin:0 auto; padding:18px 14px 40px;}
    .hero{background:linear-gradient(135deg,#ffffff 0%,#eef2ff 100%); border:1px solid var(--bd); border-radius:var(--r); padding:18px; box-shadow:0 6px 18px rgba(0,0,0,.04);}
    .hero h1{margin:0 0 8px; font-size:22px;}
    .hero p{margin:0; color:var(--sub); line-height:1.6;}
    .search{display:flex; gap:10px; margin-top:14px; flex-wrap:wrap;}
    .search input{
      flex:1; min-width:220px;
      padding:12px 14px; border:1px solid var(--bd); border-radius:999px;
      outline:none; background:#fff;
    }
    .search button{
      padding:12px 16px; border:none; border-radius:999px;
      background:var(--pri); color:#fff; font-weight:800; cursor:pointer;
    }
    .search button:hover{background:var(--pri2);}
    .grid{display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-top:16px;}
    @media(max-width:980px){ .grid{grid-template-columns:repeat(2,1fr);} }
    @media(max-width:640px){ .grid{grid-template-columns:1fr;} }
    .card{
      background:var(--card); border:1px solid var(--bd); border-radius:var(--r);
      padding:14px; box-shadow:0 6px 18px rgba(0,0,0,.04);
      transition:transform .15s ease, box-shadow .15s ease;
      display:flex; flex-direction:column; gap:8px;
    }
    .card:hover{transform:translateY(-2px); box-shadow:0 10px 24px rgba(0,0,0,.06);}
    .name{font-weight:900; font-size:16px; line-height:1.35;}
    .meta{color:var(--sub); font-size:13px; line-height:1.45;}
    .pill{display:inline-flex; align-items:center; gap:6px; font-size:12px; padding:6px 10px; border-radius:999px; background:#eef2ff; color:#1e3a8a; font-weight:800; width:max-content;}
    .actions{display:flex; gap:10px; margin-top:6px; flex-wrap:wrap;}
    .btn{
      display:inline-flex; align-items:center; justify-content:center;
      padding:10px 12px; border-radius:12px; border:1px solid #dbeafe;
      background:#fff; color:#1e3a8a; font-weight:900; font-size:13px;
    }
    .btn.primary{background:var(--pri); border-color:var(--pri); color:#fff;}
    .btn.primary:hover{background:var(--pri2);}
    .ad{margin:16px 0; text-align:center;}
    /* ✅ pager 깨짐 방지 */
    .pagination ul{list-style:none; margin:14px 0 0; padding:0; display:flex; gap:8px; justify-content:center; flex-wrap:wrap;}
    .pagination li{list-style:none;}
    .pagination a, .pagination span{
      display:inline-flex; align-items:center; justify-content:center;
      min-width:38px; height:38px; padding:0 12px;
      border:1px solid var(--bd); border-radius:12px; background:#fff; color:var(--txt);
      font-weight:900;
    }
    .pagination .active span{background:var(--pri); border-color:var(--pri); color:#fff;}
  </style>
</head>
<body>
<?php include APPPATH . 'Views/includes/header.php'; ?>

<div class="container">
  <div class="hero">
    <h1><?= esc($search !== '' ? "동물병원 검색 결과" : "전국 동물병원 목록") ?></h1>
    <p><?= esc($desc) ?></p>

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

  <div class="pagination">
    <?= $pager->links('hospitals', 'default_full') ?>
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
