<!DOCTYPE html>
<html lang="ko">
<head>
  <?php $canonical = site_url('/'); ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="naver-site-verification" content="3364bf3d26f95db9c37f59a7acb7f4523cc8c823" />
  <title>공공데이터 포털 - 퐁퐁코리아 | 전국 생활시설 정보 검색</title>
  <meta name="description" content="전국 미용실, 도서관, 안경점, 동물병원, 캠핑장, 체육시설, 세계음식점 등 생활시설 정보를 한눈에 검색하세요. 공공데이터 기반 정확한 위치, 전화번호, 운영정보 제공." />
  <meta name="keywords" content="공공데이터, 생활시설, 미용실, 도서관, 안경점, 동물병원, 캠핑장, 체육시설, 세계음식점, 위치검색, 전화번호" />
  <meta name="robots" content="index,follow,max-image-preview:large" />
  <link rel="canonical" href="<?= esc($canonical) ?>" />
  <link rel="alternate" href="<?= esc($canonical) ?>" hreflang="ko" />

  <!-- Open Graph -->
  <meta property="og:type" content="website" />
  <meta property="og:title" content="공공데이터 포털 - 퐁퐁코리아 | 전국 생활시설 정보 검색" />
  <meta property="og:description" content="전국 미용실, 도서관, 안경점, 동물병원, 캠핑장, 체육시설, 세계음식점 등 생활시설 정보를 한눈에 검색하세요." />
  <meta property="og:url" content="<?= esc($canonical) ?>" />
  <meta property="og:locale" content="ko_KR" />
  <meta property="og:site_name" content="퐁퐁코리아" />
  <meta property="og:image" content="<?= esc(site_url('assets/og/og-default.jpg')) ?>" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:image:alt" content="퐁퐁코리아 - 전국 생활시설 정보 검색" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="공공데이터 포털 - 퐁퐁코리아" />
  <meta name="twitter:description" content="전국 생활시설 정보를 한눈에 검색하세요." />
  <meta name="twitter:image" content="<?= esc(site_url('assets/og/og-default.jpg')) ?>" />

  <!-- 네이버 검색 최적화 -->
  <meta name="format-detection" content="telephone=no" />
  <meta name="mobile-web-app-capable" content="yes" />

  <!-- 성능 최적화 -->
  <link rel="preconnect" href="https://pagead2.googlesyndication.com" crossorigin>
  <link rel="preconnect" href="https://googleads.g.doubleclick.net" crossorigin>
  <link rel="preconnect" href="https://oapi.map.naver.com" crossorigin>

  <link rel="stylesheet" href="/assets/css/main.css">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>

  <!-- 구조화된 데이터: 공공데이터 포털 -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "WebSite",
        "@id": "<?= site_url() ?>#website",
        "url": "<?= site_url() ?>",
        "name": "퐁퐁코리아",
        "description": "전국 생활시설 정보 검색 포털",
        "inLanguage": "ko-KR",
        "potentialAction": {
          "@type": "SearchAction",
          "target": {
            "@type": "EntryPoint",
            "urlTemplate": "<?= site_url('hairsalon?search={search_term_string}') ?>"
          },
          "query-input": "required name=search_term_string"
        }
      },
      {
        "@type": "GovernmentOrganization",
        "@id": "<?= site_url() ?>#organization",
        "name": "퐁퐁코리아",
        "url": "<?= site_url() ?>",
        "description": "공공데이터 기반 생활시설 정보 제공 서비스"
      },
      {
        "@type": "Dataset",
        "@id": "<?= site_url() ?>#dataset",
        "name": "전국 생활시설 데이터",
        "description": "미용실, 도서관, 안경점, 동물병원, 캠핑장, 체육시설, 세계음식점 등 생활시설 정보",
        "keywords": "공공데이터, 생활시설, 위치정보",
        "license": "https://www.data.go.kr/",
        "publisher": {
          "@type": "GovernmentOrganization",
          "name": "공공데이터포털"
        }
      }
    ]
  }
  </script>

  <style>
    /* ── 퐁퐁코리아 홈 전용 디자인 ── */
    :root {
      --pk-primary:      #3730A3;
      --pk-primary-h:    #4338CA;
      --pk-accent:       #6366F1;
      --pk-accent-bg:    #EEF2FF;
      --pk-accent-bdr:   #C7D2FE;
      --pk-surface:      #FFFFFF;
      --pk-bg:           #F8FAFC;
      --pk-bg-alt:       #F1F5F9;
      --pk-text:         #1E293B;
      --pk-text-2:       #475569;
      --pk-text-3:       #94A3B8;
      --pk-border:       #E2E8F0;
      --pk-sh-sm:        0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
      --pk-sh-md:        0 4px 16px rgba(0,0,0,.09);
      --pk-sh-lg:        0 14px 44px rgba(55,48,163,.13);
      --pk-r-sm:         8px;
      --pk-r-md:         14px;
      --pk-r-lg:         20px;
    }

    /* ── 레이아웃 래퍼 ── */
    .pk-wrap {
      max-width: 1160px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* ── Hero ── */
    .pk-hero {
      background: linear-gradient(150deg, #EEF2FF 0%, #F8FAFC 52%, #E0F2FE 100%);
      border-bottom: 1px solid var(--pk-border);
      padding: 44px 20px 36px;
      text-align: center;
    }

    .pk-hero-inner {
      max-width: 720px;
      margin: 0 auto;
    }

    .pk-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 5px 16px;
      background: var(--pk-accent-bg);
      border: 1px solid var(--pk-accent-bdr);
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
      color: var(--pk-primary);
      letter-spacing: .7px;
      text-transform: uppercase;
      margin-bottom: 14px;
    }

    .pk-hero h1 {
      font-size: clamp(26px, 5.5vw, 48px);
      font-weight: 900;
      line-height: 1.18;
      letter-spacing: -1.5px;
      color: var(--pk-text);
      margin-bottom: 12px;
    }

    .pk-hero h1 em {
      font-style: normal;
      color: var(--pk-primary);
    }

    .pk-hero-sub {
      font-size: clamp(14px, 2.2vw, 17px);
      color: var(--pk-text-2);
      line-height: 1.75;
      margin-bottom: 22px;
      max-width: 540px;
      margin-left: auto;
      margin-right: auto;
    }

    /* 시각적 검색 박스 (폼 기능 없음, 클릭 시 미용실 페이지 이동) */
    .pk-search-box {
      display: flex;
      align-items: center;
      max-width: 520px;
      margin: 0 auto 18px;
      background: var(--pk-surface);
      border: 2px solid var(--pk-border);
      border-radius: 16px;
      padding: 6px 6px 6px 18px;
      box-shadow: var(--pk-sh-md);
      gap: 8px;
      transition: border-color .2s, box-shadow .2s;
    }

    .pk-search-box:focus-within {
      border-color: var(--pk-accent);
      box-shadow: 0 4px 20px rgba(99,102,241,.15);
    }

    .pk-search-hint {
      flex: 1;
      font-size: 15px;
      color: var(--pk-text-3);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      pointer-events: none;
      user-select: none;
      text-align: left;
    }

    .pk-search-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 12px 24px;
      background: var(--pk-primary);
      color: #fff;
      font-size: 14px;
      font-weight: 700;
      border-radius: 11px;
      white-space: nowrap;
      min-height: 44px;
      text-decoration: none;
      transition: background .2s, transform .15s;
      flex-shrink: 0;
    }

    .pk-search-btn:hover {
      background: var(--pk-primary-h);
      color: #fff;
      transform: translateY(-1px);
    }

    .pk-search-btn:focus-visible {
      outline: 3px solid var(--pk-accent);
      outline-offset: 2px;
    }

    /* 카테고리 태그 빠른 바로가기 */
    .pk-tag-bar {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      justify-content: center;
    }

    .pk-tag {
      display: inline-flex;
      align-items: center;
      padding: 8px 18px;
      background: var(--pk-surface);
      border: 1.5px solid var(--pk-border);
      border-radius: 999px;
      font-size: 13px;
      font-weight: 600;
      color: var(--pk-text-2);
      min-height: 44px;
      text-decoration: none;
      transition: all .15s;
    }

    .pk-tag:hover,
    .pk-tag:focus-visible {
      border-color: var(--pk-accent);
      color: var(--pk-primary);
      background: var(--pk-accent-bg);
      outline: none;
    }

    .pk-tag--active {
      background: var(--pk-primary);
      border-color: var(--pk-primary);
      color: #fff;
    }

    .pk-tag--active:hover {
      background: var(--pk-primary-h);
      border-color: var(--pk-primary-h);
      color: #fff;
    }

    /* ── 광고 래퍼 (CLS 방지) ── */
    .pk-ad-wrap {
      max-width: 1160px;
      margin: 0 auto;
      padding: 8px 20px;
      min-height: 100px;
    }

    /* ── 섹션 공통 ── */
    .pk-section {
      padding: 44px 20px;
      background: var(--pk-surface);
    }

    .pk-section--alt {
      background: var(--pk-bg-alt);
    }

    .pk-section--gray {
      background: var(--pk-bg);
    }

    .pk-section-head {
      text-align: center;
      margin-bottom: 26px;
    }

    .pk-kicker {
      display: inline-block;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1.3px;
      text-transform: uppercase;
      color: var(--pk-primary);
      margin-bottom: 10px;
    }

    .pk-section-head h2 {
      font-size: clamp(20px, 3.8vw, 32px);
      font-weight: 800;
      color: var(--pk-text);
      letter-spacing: -.6px;
      margin-bottom: 10px;
    }

    .pk-section-head p {
      font-size: 15px;
      color: var(--pk-text-2);
      max-width: 480px;
      margin: 0 auto;
      line-height: 1.7;
    }

    /* ── 카테고리 그리드 ── */
    .pk-cat-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 14px;
    }

    @media (min-width: 500px) {
      .pk-cat-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (min-width: 768px) {
      .pk-cat-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (min-width: 1024px) {
      .pk-cat-grid { grid-template-columns: repeat(4, 1fr); }
    }

    .pk-cat-card {
      background: var(--pk-surface);
      border: 1.5px solid var(--pk-border);
      border-radius: var(--pk-r-lg);
      padding: 18px 16px 16px;
      display: flex;
      flex-direction: column;
      position: relative;
      overflow: hidden;
      text-decoration: none;
      color: inherit;
      transition: border-color .2s, box-shadow .2s, transform .2s;
      box-shadow: var(--pk-sh-sm);
    }

    .pk-cat-card::after {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: var(--_accent, #6366F1);
      opacity: 0;
      transition: opacity .2s;
    }

    a.pk-cat-card:hover {
      border-color: var(--_accent, var(--pk-accent));
      box-shadow: var(--pk-sh-lg);
      transform: translateY(-4px);
      color: inherit;
    }

    a.pk-cat-card:hover::after {
      opacity: 1;
    }

    a.pk-cat-card:focus-visible {
      outline: 3px solid var(--pk-accent);
      outline-offset: 2px;
    }

    .pk-cat-icon {
      width: 46px;
      height: 46px;
      border-radius: 12px;
      background: var(--_icon-bg, var(--pk-accent-bg));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      margin-bottom: 16px;
      flex-shrink: 0;
    }

    .pk-cat-name {
      font-size: 16px;
      font-weight: 700;
      color: var(--pk-text);
      margin-bottom: 6px;
    }

    .pk-cat-desc {
      font-size: 13px;
      color: var(--pk-text-2);
      line-height: 1.6;
      flex: 1;
    }

    .pk-cat-link {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      margin-top: 16px;
      font-size: 13px;
      font-weight: 700;
      color: var(--pk-primary);
      transition: gap .15s;
    }

    a.pk-cat-card:hover .pk-cat-link {
      gap: 8px;
    }

    .pk-cat-badge {
      position: absolute;
      top: 16px;
      right: 16px;
      font-size: 10px;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 999px;
      background: #DCFCE7;
      color: #15803D;
      letter-spacing: .2px;
    }

    /* ── 기능 소개 그리드 ── */
    .pk-feat-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 14px;
    }

    @media (min-width: 540px) {
      .pk-feat-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (min-width: 900px) {
      .pk-feat-grid { grid-template-columns: repeat(4, 1fr); }
    }

    .pk-feat-card {
      background: var(--pk-surface);
      border: 1px solid var(--pk-border);
      border-radius: var(--pk-r-md);
      padding: 20px 18px;
      text-align: center;
      box-shadow: var(--pk-sh-sm);
      transition: box-shadow .2s, transform .2s;
    }

    .pk-feat-card:hover {
      box-shadow: var(--pk-sh-md);
      transform: translateY(-3px);
    }

    .pk-feat-icon {
      width: 54px;
      height: 54px;
      border-radius: 14px;
      background: var(--pk-accent-bg);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      margin: 0 auto 16px;
    }

    .pk-feat-card h3 {
      font-size: 15px;
      font-weight: 700;
      color: var(--pk-text);
      margin-bottom: 8px;
    }

    .pk-feat-card p {
      font-size: 13px;
      color: var(--pk-text-2);
      line-height: 1.65;
    }

    /* ── 활용 대상 ── */
    .pk-user-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 14px;
      max-width: 860px;
      margin: 0 auto;
    }

    @media (min-width: 640px) {
      .pk-user-grid { grid-template-columns: repeat(4, 1fr); }
    }

    .pk-user-card {
      background: var(--pk-surface);
      border: 1px solid var(--pk-border);
      border-radius: var(--pk-r-md);
      padding: 18px 14px;
      text-align: center;
      box-shadow: var(--pk-sh-sm);
      transition: box-shadow .2s, transform .2s;
    }

    .pk-user-card:hover {
      box-shadow: var(--pk-sh-md);
      transform: translateY(-2px);
    }

    .pk-user-icon {
      font-size: 30px;
      margin-bottom: 12px;
      display: block;
    }

    .pk-user-card strong {
      display: block;
      font-size: 14px;
      font-weight: 700;
      color: var(--pk-text);
      margin-bottom: 6px;
    }

    .pk-user-card span {
      font-size: 12px;
      color: var(--pk-text-2);
      line-height: 1.6;
    }

    /* ── 모바일 반응형 ── */
    @media (max-width: 480px) {
      .pk-hero {
        padding: 30px 16px 26px;
      }
      .pk-section {
        padding: 30px 16px;
      }
      .pk-search-box {
        padding: 5px 5px 5px 14px;
      }
      .pk-search-hint {
        font-size: 13px;
      }
      .pk-search-btn {
        padding: 12px 18px;
        font-size: 13px;
      }
    }

    /* ── 감소 모션 ── */
    @media (prefers-reduced-motion: reduce) {
      .pk-cat-card,
      .pk-feat-card,
      .pk-user-card,
      .pk-search-btn,
      .pk-tag {
        transition: none;
      }
    }
  </style>
</head>
<body>
<?php include APPPATH . 'Views/includes/header.php'; ?>

<main>

  <!-- ━━ Hero ━━ -->
  <section class="pk-hero">
    <div class="pk-hero-inner">
      <span class="pk-eyebrow">공공데이터 포털</span>
      <h1>전국 생활시설 정보를<br><em>한눈에 찾는</em> 공공데이터 포털</h1>
      <p class="pk-hero-sub">
        미용실, 도서관, 안경점, 동물병원, 캠핑장, 체육시설, 세계음식점까지
        공공데이터 기반의 정확한 위치·전화번호·운영정보를 검색하세요.
      </p>

      <!-- 시각적 검색 CTA — 실제 검색 URL이 미용실만 확인됨 -->
      <div class="pk-search-box" role="search" aria-label="생활시설 검색">
        <span class="pk-search-hint" aria-hidden="true">찾고 싶은 시설을 검색해보세요...</span>
        <a href="<?= site_url('hairsalon') ?>" class="pk-search-btn" aria-label="미용실 검색 페이지로 이동">검색하기</a>
      </div>

      <!-- 카테고리 빠른 탐색 -->
      <nav class="pk-tag-bar" aria-label="카테고리 빠른 탐색">
        <a href="<?= site_url('hairsalon') ?>" class="pk-tag pk-tag--active">✂️ 미용실</a>
        <span class="pk-tag">📚 도서관</span>
        <span class="pk-tag">👓 안경점</span>
        <span class="pk-tag">🐾 동물병원</span>
        <span class="pk-tag">⛺ 캠핑장</span>
        <span class="pk-tag">🏃 체육시설</span>
        <span class="pk-tag">🍜 세계음식점</span>
      </nav>
    </div>
  </section>

  <!-- ━━ 광고 (Hero 아래 — 기존 애드센스 코드 재배치) ━━ -->
  <div class="pk-ad-wrap" aria-label="광고 영역">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-6686738239613464"
         data-ad-slot="1204098626"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>

  <!-- ━━ 카테고리 ━━ -->
  <section class="pk-section" aria-labelledby="cat-title">
    <div class="pk-wrap">
      <div class="pk-section-head">
        <span class="pk-kicker">Categories</span>
        <h2 id="cat-title">주요 생활시설 카테고리</h2>
        <p>전국 공공데이터를 기반으로 다양한 생활시설 정보를 제공합니다.</p>
      </div>

      <div class="pk-cat-grid">

        <!-- 미용실 — URL 확인됨 (hairsalon) -->
        <a href="<?= site_url('hairsalon') ?>"
           class="pk-cat-card"
           style="--_accent:#6366F1; --_icon-bg:#EEF2FF;"
           aria-label="전국 미용실 검색">
          <span class="pk-cat-badge">검색 가능</span>
          <div class="pk-cat-icon">✂️</div>
          <div class="pk-cat-name">미용실</div>
          <p class="pk-cat-desc">전국 미용실 위치, 전화번호, 운영시간을 검색해보세요.</p>
          <span class="pk-cat-link">바로가기 →</span>
        </a>

        <!-- 도서관 — URL 미확인, 비링크 -->
        <div class="pk-cat-card" style="--_accent:#0EA5E9; --_icon-bg:#E0F2FE;">
          <div class="pk-cat-icon">📚</div>
          <div class="pk-cat-name">도서관</div>
          <p class="pk-cat-desc">전국 공공도서관 위치, 운영시간, 연락처 정보를 확인하세요.</p>
        </div>

        <!-- 안경점 — URL 미확인 -->
        <div class="pk-cat-card" style="--_accent:#8B5CF6; --_icon-bg:#F3E8FF;">
          <div class="pk-cat-icon">👓</div>
          <div class="pk-cat-name">안경점</div>
          <p class="pk-cat-desc">가까운 안경점과 콘택트렌즈 취급점의 위치·연락처를 확인하세요.</p>
        </div>

        <!-- 동물병원 — URL 미확인 -->
        <div class="pk-cat-card" style="--_accent:#10B981; --_icon-bg:#D1FAE5;">
          <div class="pk-cat-icon">🐾</div>
          <div class="pk-cat-name">동물병원</div>
          <p class="pk-cat-desc">전국 동물병원·동물의료기관의 위치와 진료 정보를 제공합니다.</p>
        </div>

        <!-- 캠핑장 — URL 미확인 -->
        <div class="pk-cat-card" style="--_accent:#F59E0B; --_icon-bg:#FEF3C7;">
          <div class="pk-cat-icon">⛺</div>
          <div class="pk-cat-name">캠핑장</div>
          <p class="pk-cat-desc">전국 캠핑장·오토캠핑장의 위치, 시설, 이용정보를 안내합니다.</p>
        </div>

        <!-- 체육시설 — URL 미확인 -->
        <div class="pk-cat-card" style="--_accent:#EF4444; --_icon-bg:#FEE2E2;">
          <div class="pk-cat-icon">🏃</div>
          <div class="pk-cat-name">체육시설</div>
          <p class="pk-cat-desc">공공 체육시설, 스포츠센터, 수영장 위치와 이용시간을 확인하세요.</p>
        </div>

        <!-- 세계음식점 — URL 미확인 -->
        <div class="pk-cat-card" style="--_accent:#EC4899; --_icon-bg:#FCE7F3;">
          <div class="pk-cat-icon">🍜</div>
          <div class="pk-cat-name">세계음식점</div>
          <p class="pk-cat-desc">한식부터 이국적인 세계 각국의 음식점 정보를 검색할 수 있습니다.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- ━━ 주요 기능 ━━ -->
  <section class="pk-section pk-section--gray" aria-labelledby="feat-title">
    <div class="pk-wrap">
      <div class="pk-section-head">
        <span class="pk-kicker">Features</span>
        <h2 id="feat-title">퐁퐁코리아에서 할 수 있는 것</h2>
        <p>공공데이터를 기반으로 생활에 꼭 필요한 시설 정보를 빠르게 확인하세요.</p>
      </div>

      <div class="pk-feat-grid">
        <div class="pk-feat-card">
          <div class="pk-feat-icon">📍</div>
          <h3>위치 정보 확인</h3>
          <p>전국 생활시설의 정확한 주소와 위치 정보를 확인할 수 있습니다.</p>
        </div>
        <div class="pk-feat-card">
          <div class="pk-feat-icon">📞</div>
          <h3>전화번호 확인</h3>
          <p>시설별 대표 전화번호를 바로 확인하고 연결할 수 있습니다.</p>
        </div>
        <div class="pk-feat-card">
          <div class="pk-feat-icon">🕐</div>
          <h3>운영정보 확인</h3>
          <p>영업시간, 휴무일 등 최신 운영 정보를 한눈에 확인하세요.</p>
        </div>
        <div class="pk-feat-card">
          <div class="pk-feat-icon">🗂️</div>
          <h3>공공데이터 기반</h3>
          <p>정부 공공데이터포털 자료를 바탕으로 신뢰할 수 있는 정보를 제공합니다.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ━━ 활용 대상 ━━ -->
  <section class="pk-section pk-section--alt" aria-labelledby="user-title">
    <div class="pk-wrap">
      <div class="pk-section-head">
        <span class="pk-kicker">For Everyone</span>
        <h2 id="user-title">누가 활용하나요?</h2>
        <p>퐁퐁코리아는 대한민국 국민 누구나 무료로 이용할 수 있습니다.</p>
      </div>

      <div class="pk-user-grid">
        <div class="pk-user-card">
          <span class="pk-user-icon">🇰🇷</span>
          <strong>대한민국 국민 누구나</strong>
          <span>일상에서 필요한 생활시설 정보를 손쉽게 검색하세요.</span>
        </div>
        <div class="pk-user-card">
          <span class="pk-user-icon">🏛️</span>
          <strong>공공기관</strong>
          <span>정책 수립과 행정 업무에 공공데이터를 활용하세요.</span>
        </div>
        <div class="pk-user-card">
          <span class="pk-user-icon">📊</span>
          <strong>기업</strong>
          <span>입지 선정, 시장 분석 등 비즈니스 의사결정에 활용하세요.</span>
        </div>
        <div class="pk-user-card">
          <span class="pk-user-icon">🙋</span>
          <strong>시민 · 연구자</strong>
          <span>지역 정보 검색과 연구·학습 자료로 자유롭게 활용하세요.</span>
        </div>
      </div>
    </div>
  </section>

</main>

<?php include APPPATH . 'Views/includes/footer.php'; ?>
</body>
</html>
