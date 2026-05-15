<?php
helper(['url']);

$request = service('request');
$search = isset($search) ? trim((string)$search) : '';
$page   = max(1, (int)($request->getGet('page') ?? ($page ?? 1)));
$isSearch = ($search !== '');
$isPaginated = ($page > 1);

$listUrl = site_url('installation');

$canonical = $listUrl;

$seoTitle = ($search !== '')
  ? "{$search} 폐의약품 수거장소 검색 결과 | 수거장소 목록"
  : "폐의약품 수거장소 목록 | 지역별 수거장소 정보";

$seoDescParts = [];
if ($search !== '') $seoDescParts[] = "검색어: {$search}";
$seoDescParts[] = "전국 폐의약품 수거장소 주소/전화번호/관리기관 정보를 확인하세요.";
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


  <?php include APPPATH . 'Views/includes/listing_theme.php'; ?>
</head>
<body class="listing-page">

<?php include APPPATH . 'Views/includes/header.php'; ?>

<div class="container">

  <div class="top">
    <div>
      <h1><?= esc($search !== '' ? "“{$search}” 검색 결과" : "폐의약품 수거장소 목록") ?></h1>
      <p>주소/전화/관리기관 정보를 빠르게 확인하고 상세 페이지에서 지도와 근처 수거장소도 보세요.</p>
    </div>

    <form class="search" method="get" action="<?= esc($listUrl) ?>">
      <input type="text" name="search" value="<?= esc($search) ?>" placeholder="수거장소명/주소로 검색" />
      <button type="submit">검색</button>
    </form>
  </div>

  <div class="grid">
    <?php if (!empty($installations) && is_array($installations)): ?>
      <?php 
        $count = 0;
        foreach ($installations as $inst): 
          $count++;
      ?>
        <?php
          $id    = $inst['id'] ?? null;
          if (!$id) continue;

          $name  = esc($inst['Installation Location Name'] ?? '수거장소');
          $addr  = esc($inst['Street Address'] ?? ($inst['Land Lot Address'] ?? ''));
          $phone = esc($inst['Managing Institution Phone Number'] ?? '');
          $district = esc($inst['District Name'] ?? '');
          $url   = site_url('installation/show/' . $id);
        ?>
        <div class="card">
          <h2 class="name"><?= $name ?></h2>
          <div class="meta">
            <?php if ($addr): ?>📍 <?= $addr ?><br><?php endif; ?>
            <?php if ($phone): ?>📞 <?= $phone ?><?php endif; ?>
          </div>
          <div class="chips">
            <?php if ($district): ?><span class="chip"><?= $district ?></span><?php endif; ?>
            <?php if (($inst['Managing Institution Name'] ?? '') !== ''): ?>
              <span class="chip"><?= esc($inst['Managing Institution Name']) ?></span>
            <?php endif; ?>
          </div>
          <div class="actions">
            <a href="<?= esc($url) ?>" class="btn-detail">상세보기</a>
          </div>
        </div>
        
      <?php endforeach; ?>
    <?php else: ?>
      <div class="card empty-state">
        검색 결과가 없습니다.
      </div>
    <?php endif; ?>
  </div>
  <?php if (isset($pager) && $pager): ?>
    <div class="pager-wrap">
      <?= $pager->links('installations', 'default_full') ?>
    </div>
  <?php endif; ?>

</div>

<?php include APPPATH . 'Views/includes/footer.php'; ?>


</body>
</html>
