<?php
helper(['url']);
$request = service('request');
$search = isset($search) ? trim((string)$search) : '';
$page = max(1, (int)($request->getGet('page') ?? 1));
$isSearch = ($search !== '');
$isPaginated = ($page > 1);
$listUrl = site_url('clothing-collection-bin');
$canonical = $listUrl;
$seoTitle = ($search !== '')
  ? "{$search} 폐의류 수거함 검색 결과 | 폐의류 수거함 목록"
  : "폐의류 수거함 목록 | 지역별 수거함 정보";
$seoDescParts = [];
if ($search !== '') $seoDescParts[] = "검색어: {$search}";
$seoDescParts[] = "전국 폐의류 수거함 주소/전화번호/관리기관 정보를 확인하세요.";
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
  <style>
    :root{ --bg:#f6f7fb; --card:#fff; --txt:#222; --sub:#555; --bd:#e9ecf2; --blue:#1b6cff; --chip:#eef4ff; }
    *{ box-sizing:border-box; }
    body{ margin:0; font-family: system-ui,-apple-system,'Noto Sans KR',sans-serif; background:var(--bg); color:var(--txt); }
    a{ color:inherit; text-decoration:none; }
    a:hover{ text-decoration:underline; }
    .container{ max-width:1100px; margin:0 auto; padding:18px 14px 40px; }
    .top{ display:flex; gap:12px; align-items:flex-end; justify-content:space-between; padding:16px; background:var(--card); border:1px solid var(--bd); border-radius:16px; box-shadow:0 1px 6px rgba(0,0,0,.05); }
    .top h1{ margin:0; font-size:22px; }
    .top p{ margin:6px 0 0; color:var(--sub); font-size:14px; line-height:1.5; }
    .search{ display:flex; gap:8px; align-items:center; width:420px; max-width:100%; }
    .search input{ width:100%; padding:12px 14px; border-radius:999px; border:1px solid var(--bd); outline:none; background:#fff; }
    .search button{ padding:12px 14px; border-radius:999px; border:1px solid var(--bd); background:var(--blue); color:#fff; font-weight:800; cursor:pointer; }
    .ad{ margin:14px 0; text-align:center; }
    .grid{ display:grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap:12px; margin-top:14px; }
    .card{ background:var(--card); border:1px solid var(--bd); border-radius:16px; padding:14px 14px 12px; box-shadow:0 1px 6px rgba(0,0,0,.05); transition: transform .15s ease; min-height: 130px; }
    .card:hover{ transform: translateY(-2px); }
    .name{ font-size:16px; font-weight:900; margin:0 0 8px; }
    .meta{ color:var(--sub); font-size:13px; line-height:1.45; }
    .chips{ display:flex; flex-wrap:wrap; gap:6px; margin-top:10px; }
    .chip{ background:var(--chip); color:#0b3d91; border-radius:999px; padding:6px 10px; font-size:12px; font-weight:800; border:1px solid #dbe7ff; }
    .pager-wrap{ margin-top:18px; padding:12px; background:var(--card); border:1px solid var(--bd); border-radius:16px; }
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
      <h1><?= esc($search !== '' ? "“{$search}” 검색 결과" : "폐의류 수거함 목록") ?></h1>
      <p>주소/전화/관리기관 정보를 빠르게 확인하고 상세 페이지에서 지도와 근처 수거함도 보세요.</p>
    </div>
    <form class="search" method="get" action="<?= esc($listUrl) ?>">
      <input type="text" name="search" value="<?= esc($search) ?>" placeholder="수거함명/주소로 검색" />
      <button type="submit">검색</button>
    </form>
  </div>
  <div class="grid">
    <?php if (!empty($bins) && is_array($bins)): ?>
      <?php 
        $count = 0;
        foreach ($bins as $bin): 
          $count++;
      ?>
        <?php
          $id = $bin['id'] ?? null;
          if (!$id) continue;
          $name = esc($bin['Clothing Collection Bin Location Name'] ?? '수거함');
          $addr = esc($bin['Street Address'] ?? ($bin['Land Lot Address'] ?? ''));
          $district = esc($bin['District Name'] ?? '');
          $url = site_url('clothing-collection-bin/show/' . $id);
        ?>
        <a class="card" href="<?= esc($url) ?>">
          <h2 class="name"><?= $name ?></h2>
          <div class="meta">
            <?php if ($addr): ?>📍 <?= $addr ?><br><?php endif; ?>
            <?php if ($district): ?>🏙️ <?= $district ?><?php endif; ?>
          </div>
          <div class="chips">
            <?php if ($district): ?><span class="chip"><?= $district ?></span><?php endif; ?>
          </div>
        </a>
        
      <?php endforeach; ?>
    <?php else: ?>
      <div class="card" style="grid-column:1/-1;">
        검색 결과가 없습니다.
      </div>
    <?php endif; ?>
  </div>
  
  <div class="pager-wrap">
    <?php if (isset($pager) && $pager): ?>
      <?= $pager->links('bins', 'default_full') ?>
    <?php endif; ?>
  </div>
</div>
<?php include APPPATH . 'Views/includes/footer.php'; ?>
</body>
</html>
