<style>
  :root {
    --pk-detail-bg: #f4f7fb;
    --pk-detail-bg-2: #edf2ff;
    --pk-detail-surface: rgba(255, 255, 255, 0.96);
    --pk-detail-surface-strong: #ffffff;
    --pk-detail-text: #0f172a;
    --pk-detail-sub: #526071;
    --pk-detail-muted: #7c8aa5;
    --pk-detail-line: #dbe4f0;
    --pk-detail-line-strong: #c7d2fe;
    --pk-detail-primary: #3730a3;
    --pk-detail-primary-strong: #4338ca;
    --pk-detail-primary-soft: #eef2ff;
    --pk-detail-accent: #0891b2;
    --pk-detail-shadow-sm: 0 14px 32px rgba(15, 23, 42, 0.08);
    --pk-detail-shadow-md: 0 22px 56px rgba(55, 48, 163, 0.14);
    --pk-detail-radius-xl: 30px;
    --pk-detail-radius-lg: 22px;
    --pk-detail-radius-md: 18px;
    --pk-detail-radius-sm: 14px;
  }

  * {
    box-sizing: border-box;
  }

  body.detail-page {
    margin: 0;
    font-family: "Pretendard Variable", "Pretendard", "Noto Sans KR", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: var(--pk-detail-text);
    background:
      radial-gradient(circle at top left, rgba(99, 102, 241, 0.14), transparent 28%),
      radial-gradient(circle at top right, rgba(8, 145, 178, 0.11), transparent 26%),
      linear-gradient(180deg, #f8fbff 0%, var(--pk-detail-bg) 48%, #eef2f7 100%);
  }

  body.detail-page a {
    color: inherit;
    text-decoration: none;
  }

  body.detail-page .container {
    max-width: 1040px;
    margin: 0 auto;
    padding: 24px 18px 60px;
  }

  body.detail-page .breadcrumb {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    margin: 0 0 16px;
    color: var(--pk-detail-muted);
    font-size: 13px;
    line-height: 1.5;
  }

  body.detail-page .breadcrumb a {
    display: inline-flex;
    align-items: center;
    min-height: 34px;
    padding: 0 12px;
    border: 1px solid rgba(199, 210, 254, 0.92);
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.82);
    color: var(--pk-detail-primary);
    font-weight: 700;
    transition: background-color 0.16s ease, border-color 0.16s ease, transform 0.16s ease;
  }

  body.detail-page .breadcrumb a:hover {
    background: var(--pk-detail-primary-soft);
    border-color: rgba(129, 140, 248, 0.84);
    transform: translateY(-1px);
  }

  body.detail-page .title,
  body.detail-page .content-title,
  body.detail-page .hero h1 {
    margin: 0;
    font-size: clamp(30px, 4.8vw, 44px);
    line-height: 1.08;
    letter-spacing: -0.04em;
    font-weight: 900;
    color: var(--pk-detail-text);
  }

  body.detail-page .container > .breadcrumb + .title {
    margin-top: 8px;
    padding: 24px 28px 8px;
    border: 1px solid rgba(219, 228, 240, 0.94);
    border-bottom: 0;
    border-radius: var(--pk-detail-radius-xl) var(--pk-detail-radius-xl) 0 0;
    background:
      linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(244, 247, 255, 0.95) 56%, rgba(236, 254, 255, 0.92) 100%);
    box-shadow: var(--pk-detail-shadow-md);
  }

  body.detail-page .container > .title + .subtitle {
    margin-top: 0;
    margin-bottom: 18px;
    padding: 0 28px 28px;
    border: 1px solid rgba(219, 228, 240, 0.94);
    border-top: 0;
    border-radius: 0 0 var(--pk-detail-radius-xl) var(--pk-detail-radius-xl);
    background:
      linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(244, 247, 255, 0.95) 56%, rgba(236, 254, 255, 0.92) 100%);
    box-shadow: var(--pk-detail-shadow-md);
  }

  body.detail-page .container > .content-title {
    padding: 26px 28px;
    border: 1px solid rgba(219, 228, 240, 0.94);
    border-radius: var(--pk-detail-radius-xl);
    background:
      linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(244, 247, 255, 0.95) 56%, rgba(236, 254, 255, 0.92) 100%);
    box-shadow: var(--pk-detail-shadow-md);
  }

  body.detail-page .content-title {
    border: 0;
    padding: 0;
    margin-bottom: 10px;
  }

  body.detail-page .subtitle,
  body.detail-page .hero p {
    margin: 12px 0 0;
    max-width: 760px;
    color: var(--pk-detail-sub);
    font-size: 15px;
    line-height: 1.78;
    word-break: keep-all;
  }

  body.detail-page .hero,
  body.detail-page .page-hero {
    position: relative;
    padding: 28px;
    border: 1px solid rgba(219, 228, 240, 0.94);
    border-radius: var(--pk-detail-radius-xl);
    background:
      linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(244, 247, 255, 0.95) 56%, rgba(236, 254, 255, 0.92) 100%);
    box-shadow: var(--pk-detail-shadow-md);
    overflow: hidden;
    isolation: isolate;
  }

  body.detail-page .hero::before,
  body.detail-page .page-hero::before {
    content: "";
    position: absolute;
    right: -60px;
    top: -60px;
    width: 190px;
    height: 190px;
    border-radius: 999px;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.24) 0%, rgba(99, 102, 241, 0) 72%);
    z-index: -1;
  }

  body.detail-page .hero::after,
  body.detail-page .page-hero::after {
    content: "";
    position: absolute;
    left: -70px;
    bottom: -90px;
    width: 220px;
    height: 220px;
    border-radius: 999px;
    background: radial-gradient(circle, rgba(8, 145, 178, 0.14) 0%, rgba(8, 145, 178, 0) 72%);
    z-index: -1;
  }

  body.detail-page .hero .actions,
  body.detail-page .page-hero .actions {
    margin-top: 18px;
  }

  body.detail-page .grid {
    display: grid;
    gap: 18px;
    margin-top: 18px;
  }

  body.detail-page .card,
  body.detail-page .section {
    position: relative;
    margin-bottom: 0;
    padding: 22px;
    border: 1px solid rgba(219, 228, 240, 0.94);
    border-radius: var(--pk-detail-radius-lg);
    background:
      linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.96) 100%);
    box-shadow: var(--pk-detail-shadow-sm);
    overflow: hidden;
  }

  body.detail-page .card::before,
  body.detail-page .section::before {
    content: "";
    position: absolute;
    left: 22px;
    top: 0;
    width: 58px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--pk-detail-primary) 0%, var(--pk-detail-accent) 100%);
  }

  body.detail-page .card h2,
  body.detail-page .section h2 {
    margin: 0 0 16px;
    padding: 0;
    border: 0;
    color: var(--pk-detail-text);
    font-size: 18px;
    font-weight: 900;
    letter-spacing: -0.02em;
  }

  body.detail-page .kv {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  body.detail-page .pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    min-height: 36px;
    padding: 0 13px;
    border: 1px solid rgba(191, 219, 254, 0.94);
    border-radius: 999px;
    background: linear-gradient(180deg, var(--pk-detail-primary-soft) 0%, rgba(239, 246, 255, 0.96) 100%);
    color: var(--pk-detail-primary);
    font-size: 12px;
    font-weight: 800;
  }

  body.detail-page .actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  body.detail-page .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    padding: 0 16px;
    border: 1px solid rgba(199, 210, 254, 0.94);
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.9);
    color: var(--pk-detail-primary);
    font-size: 14px;
    font-weight: 800;
    letter-spacing: -0.01em;
    box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
    transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease, border-color 0.18s ease, color 0.18s ease;
  }

  body.detail-page .btn:hover {
    transform: translateY(-1px);
    background: var(--pk-detail-primary-soft);
    border-color: rgba(129, 140, 248, 0.88);
    box-shadow: 0 12px 24px rgba(55, 48, 163, 0.12);
  }

  body.detail-page .btn.primary {
    border-color: transparent;
    background: linear-gradient(135deg, var(--pk-detail-primary) 0%, var(--pk-detail-primary-strong) 100%);
    color: #ffffff;
    box-shadow: 0 14px 28px rgba(55, 48, 163, 0.18);
  }

  body.detail-page .btn.primary:hover {
    background: linear-gradient(135deg, var(--pk-detail-primary) 0%, var(--pk-detail-primary-strong) 100%);
    color: #ffffff;
  }

  body.detail-page .btn.muted {
    background: rgba(255, 255, 255, 0.78);
  }

  body.detail-page .btn:focus-visible,
  body.detail-page .breadcrumb a:focus-visible {
    outline: 3px solid rgba(99, 102, 241, 0.22);
    outline-offset: 3px;
  }

  body.detail-page .detail,
  body.detail-page .detail-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  body.detail-page .row,
  body.detail-page .detail-item {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    padding: 14px 0;
    border-bottom: 1px solid rgba(226, 232, 240, 0.92);
  }

  body.detail-page .row:last-child,
  body.detail-page .detail-item:last-child {
    border-bottom: 0;
  }

  body.detail-page .label {
    min-width: 120px;
    font-weight: 800;
    color: var(--pk-detail-text);
  }

  body.detail-page .value {
    max-width: 72%;
    color: var(--pk-detail-sub);
    text-align: right;
    word-break: break-word;
    line-height: 1.65;
  }

  body.detail-page .note,
  body.detail-page .small {
    margin-top: 12px;
    color: var(--pk-detail-sub);
    font-size: 13px;
    line-height: 1.75;
  }

  body.detail-page .sep {
    height: 1px;
    margin: 14px 0;
    background: rgba(226, 232, 240, 0.96);
  }

  body.detail-page #map {
    width: 100%;
    height: 360px;
    border-radius: var(--pk-detail-radius-md);
    overflow: hidden;
    background:
      linear-gradient(135deg, rgba(224, 231, 255, 0.84) 0%, rgba(219, 234, 254, 0.9) 100%);
    border: 1px solid rgba(199, 210, 254, 0.88);
  }

  body.detail-page .near-grid {
    display: grid;
    gap: 12px;
  }

  body.detail-page .near-item {
    padding: 16px;
    border: 1px solid rgba(219, 228, 240, 0.94);
    border-radius: var(--pk-detail-radius-md);
    background: rgba(255, 255, 255, 0.88);
    transition: transform 0.16s ease, border-color 0.16s ease, box-shadow 0.16s ease;
  }

  body.detail-page .near-item:hover {
    transform: translateY(-2px);
    border-color: rgba(129, 140, 248, 0.8);
    box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
  }

  body.detail-page .near-title {
    margin: 0 0 6px;
    font-size: 16px;
    font-weight: 900;
    color: var(--pk-detail-text);
    letter-spacing: -0.02em;
  }

  body.detail-page .near-title a {
    color: inherit;
  }

  body.detail-page .near-meta {
    color: var(--pk-detail-sub);
    font-size: 13px;
    line-height: 1.65;
  }

  body.detail-page .ad,
  body.detail-page #ad,
  body.detail-page .ad-box {
    margin: 18px 0;
    text-align: center;
  }

  body.detail-page .ad .adsbygoogle,
  body.detail-page #ad .adsbygoogle,
  body.detail-page .ad-box .adsbygoogle {
    overflow: hidden;
    border-radius: var(--pk-detail-radius-md);
  }

  /* ── Blog list ── */
  body.detail-page .blog-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0;
  }

  body.detail-page .blog-item {
    padding: 16px 0;
    border-bottom: 1px solid rgba(226, 232, 240, 0.92);
  }

  body.detail-page .blog-item:last-child {
    border-bottom: 0;
    padding-bottom: 0;
  }

  body.detail-page .blog-item:first-child {
    padding-top: 0;
  }

  body.detail-page .blog-title {
    display: block;
    margin-bottom: 6px;
    font-size: 15px;
    font-weight: 800;
    color: var(--pk-detail-primary);
    letter-spacing: -0.02em;
    line-height: 1.45;
    transition: color 0.16s ease;
  }

  body.detail-page .blog-title:hover {
    color: var(--pk-detail-accent);
    text-decoration: underline;
    text-underline-offset: 3px;
  }

  body.detail-page .blog-desc {
    margin: 0 0 6px;
    font-size: 13px;
    color: var(--pk-detail-sub);
    line-height: 1.7;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  body.detail-page .blog-date {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    color: var(--pk-detail-muted);
    background: var(--pk-detail-primary-soft);
    border: 1px solid rgba(199, 210, 254, 0.8);
    border-radius: 999px;
    padding: 2px 10px;
  }

  @media (max-width: 680px) {
    body.detail-page .container {
      padding: 18px 14px 48px;
    }

    body.detail-page .hero,
    body.detail-page .page-hero,
    body.detail-page .card,
    body.detail-page .section {
      padding: 18px;
      border-radius: 20px;
    }

    body.detail-page .container > .breadcrumb + .title {
      padding: 18px 18px 8px;
      border-radius: 20px 20px 0 0;
    }

    body.detail-page .container > .title + .subtitle,
    body.detail-page .container > .content-title {
      padding-left: 18px;
      padding-right: 18px;
      border-radius: 0 0 20px 20px;
    }

    body.detail-page .container > .content-title {
      border-radius: 20px;
      padding-top: 18px;
      padding-bottom: 18px;
    }

    body.detail-page .breadcrumb {
      gap: 6px;
      font-size: 12px;
    }

    body.detail-page .breadcrumb a {
      min-height: 30px;
      padding: 0 10px;
    }

    body.detail-page .btn {
      min-height: 44px;
      width: 100%;
    }

    body.detail-page .row,
    body.detail-page .detail-item {
      flex-direction: column;
      align-items: flex-start;
      gap: 6px;
    }

    body.detail-page .value {
      max-width: 100%;
      text-align: left;
    }

    body.detail-page #map {
      height: 300px;
    }
  }
</style>
