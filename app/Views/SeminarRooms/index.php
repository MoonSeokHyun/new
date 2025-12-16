<?php
helper(['url']);

$search = isset($search) ? trim((string)$search) : '';
$page   = isset($page) ? (int)$page : 1;

$listUrl = site_url('seminar-rooms');

$canonical = $listUrl;
if ($search !== '') {
  $canonical = $listUrl . '?search=' . urlencode($search);
} elseif ($page > 1) {
  $canonical = $listUrl;
}

$seoTitle = ($search !== '')
  ? "{$search} 세미나룸 검색 결과 | 세미나룸 목록"
  : "세미나룸 목록 | 지역별 세미나룸 정보";

$seoDescParts = [];
if ($search !== '') $seoDescParts[] = "검색어: {$search}";
$seoDescParts[] = "전국 세미나룸 주소/운영시간/편의시설 정보를 확인하세요.";
$seoDescription = implode(' · ', $seoDescParts);

$robots = ($page > 1) ? 'noindex,follow' : 'index,follow,max-image-preview:large';
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
  <meta property="og:locale" content="ko_KR" />

  <meta name="twitter:card" content="summary" />
  <meta name="twitter:title" content="<?= esc($seoTitle) ?>" />
  <meta name="twitter:description" content="<?= esc($seoDescription) ?>" />

  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

  <style>
    :root{
      --bg:#f6f7fb; --card:#fff; --txt:#222; --sub:#555; --bd:#e9ecf2;
      --blue:#1b6cff; --chip:#eef4ff;
    }
    *{ box-sizing:border-box; }
    body{ margin:0; font-family: system-ui,-apple-system,'Noto Sans KR',sans-serif; background:var(--bg); color:var(--txt); }
    a{ color:inherit; text-decoration:none; }
    a:hover{ text-decoration:underline; }

    .container{ max-width:1100px; margin:0 auto; padding:18px 14px 40px; }

    .top{
      display:flex; gap:12px; align-items:flex-end; justify-content:space-between;
      padding:16px; background:var(--card); border:1px solid var(--bd); border-radius:16px;
      box-shadow:0 1px 6px rgba(0,0,0,.05);
    }
    .top h1{ margin:0; font-size:22px; }
    .top p{ margin:6px 0 0; color:var(--sub); font-size:14px; line-height:1.5; }

    .search{
      display:flex; gap:8px; align-items:center; width:420px; max-width:100%;
    }
    .search input{
      width:100%; padding:12px 14px; border-radius:999px;
      border:1px solid var(--bd); outline:none; background:#fff;
    }
    .search button{
      padding:12px 14px; border-radius:999px; border:1px solid var(--bd);
      background:var(--blue); color:#fff; font-weight:800; cursor:pointer;
    }

    .ad{ margin:14px 0; text-align:center; }
    .grid{
      display:grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap:12px;
      margin-top:14px;
    }
    .card{
      background:var(--card);
      border:1px solid var(--bd);
      border-radius:16px;
      padding:14px 14px 12px;
      box-shadow:0 1px 6px rgba(0,0,0,.05);
      transition: transform .15s ease;
      min-height: 130px;
    }
    .card:hover{ transform: translateY(-2px); }

    .name{ font-size:16px; font-weight:900; margin:0 0 8px; }
    .meta{ color:var(--sub); font-size:13px; line-height:1.45; }
    .chips{ display:flex; flex-wrap:wrap; gap:6px; margin-top:10px; }
    .chip{
      background:var(--chip); color:#0b3d91;
      border-radius:999px; padding:6px 10px; font-size:12px; font-weight:800;
      border:1px solid #dbe7ff;
    }

    .pager-wrap{
      margin-top:18px;
      padding:12px;
      background:var(--card);
      border:1px solid var(--bd);
      border-radius:16px;
    }

    @media (max-width:980px){ .grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width:620px){
      .top{ flex-direction:column; align-items:stretch; }
      .grid{ grid-template-columns: 1fr; }
      .search{ width:100%; }
    }
  </style>
</head>
<body>

<?php include APPPATH . 'Views/includes/header.php'; ?>

<div class="container">

  <div class="top">
    <div>
      <h1><?= esc($search !== '' ? "“{$search}” 검색 결과" : "세미나룸 목록") ?></h1>
      <p>주소/운영시간/편의시설 정보를 빠르게 확인하고 상세 페이지에서 지도와 근처 세미나룸도 보세요.</p>
    </div>

    <form class="search" method="get" action="<?= esc($listUrl) ?>">
      <input type="text" name="search" value="<?= esc($search) ?>" placeholder="세미나룸명/주소로 검색" />
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
    <?php if (!empty($rooms) && is_array($rooms)): ?>
      <?php 
        $count = 0;
        foreach ($rooms as $room): 
          $count++;
      ?>
        <?php
          $id    = is_array($room) ? ($room['id'] ?? null) : ($room->id ?? null);
          if (!$id) continue;

          $name  = esc(is_array($room) ? ($room['FCLTY_NM'] ?? '세미나룸') : ($room->FCLTY_NM ?? '세미나룸'));
          $addr  = esc(is_array($room) ? ($room['RDNMADR_NM'] ?? ($room['LNM_ADDR'] ?? '')) : ($room->RDNMADR_NM ?? ($room->LNM_ADDR ?? '')));
          $url   = site_url('seminar-rooms/detail/' . $id);
        ?>
        <a class="card" href="<?= esc($url) ?>">
          <h2 class="name"><?= $name ?></h2>
          <div class="meta">
            <?php if ($addr): ?>📍 <?= $addr ?><?php endif; ?>
          </div>
          <div class="chips">
            <?php if (is_array($room) ? ($room['FCLTY_TY_NM'] ?? '') : ($room->FCLTY_TY_NM ?? '')): ?>
              <span class="chip"><?= esc(is_array($room) ? $room['FCLTY_TY_NM'] : $room->FCLTY_TY_NM) ?></span>
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
      <div class="card" style="grid-column:1/-1;">
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

  <div class="pager-wrap">
    <?php if (isset($pager) && $pager): ?>
      <?= $pager->links('rooms', 'default_full') ?>
    <?php endif; ?>
  </div>

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
