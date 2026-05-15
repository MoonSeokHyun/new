<style>
  :root {
    --pk-page-bg: #f4f7fb;
    --pk-page-bg-soft: #eef3ff;
    --pk-card: rgba(255, 255, 255, 0.96);
    --pk-card-strong: #ffffff;
    --pk-text: #0f172a;
    --pk-sub: #526071;
    --pk-muted: #7c8aa5;
    --pk-line: #dbe4f0;
    --pk-line-strong: #c7d2fe;
    --pk-primary: #3730a3;
    --pk-primary-strong: #4338ca;
    --pk-primary-soft: #eef2ff;
    --pk-primary-soft-2: #e0e7ff;
    --pk-accent: #0f766e;
    --pk-accent-soft: #ecfeff;
    --pk-shadow-sm: 0 10px 24px rgba(15, 23, 42, 0.06);
    --pk-shadow-md: 0 18px 48px rgba(55, 48, 163, 0.14);
    --pk-radius-lg: 28px;
    --pk-radius-md: 20px;
    --pk-radius-sm: 14px;
  }

  * {
    box-sizing: border-box;
  }

  body.listing-page {
    margin: 0;
    font-family: "Pretendard Variable", "Pretendard", "Noto Sans KR", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: var(--pk-text);
    background:
      radial-gradient(circle at top left, rgba(99, 102, 241, 0.14), transparent 30%),
      radial-gradient(circle at top right, rgba(14, 165, 233, 0.1), transparent 28%),
      linear-gradient(180deg, #f8fbff 0%, var(--pk-page-bg) 48%, #eef2f7 100%);
  }

  body.listing-page a {
    color: inherit;
    text-decoration: none;
  }

  body.listing-page .container {
    max-width: 1160px;
    margin: 0 auto;
    padding: 26px 18px 56px;
  }

  body.listing-page .top,
  body.listing-page .hero {
    position: relative;
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(280px, 420px);
    gap: 18px 22px;
    align-items: end;
    padding: 28px;
    border: 1px solid rgba(219, 228, 240, 0.92);
    border-radius: var(--pk-radius-lg);
    background:
      linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(244, 247, 255, 0.94) 56%, rgba(236, 254, 255, 0.9) 100%);
    box-shadow: var(--pk-shadow-md);
    overflow: hidden;
    isolation: isolate;
  }

  body.listing-page .top::before,
  body.listing-page .hero::before {
    content: "";
    position: absolute;
    right: -48px;
    top: -48px;
    width: 180px;
    height: 180px;
    border-radius: 999px;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.24) 0%, rgba(99, 102, 241, 0) 72%);
    z-index: -1;
  }

  body.listing-page .top::after,
  body.listing-page .hero::after {
    content: "";
    position: absolute;
    left: -60px;
    bottom: -80px;
    width: 220px;
    height: 220px;
    border-radius: 999px;
    background: radial-gradient(circle, rgba(14, 165, 233, 0.14) 0%, rgba(14, 165, 233, 0) 72%);
    z-index: -1;
  }

  body.listing-page .listing-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 36px;
    padding: 8px 14px;
    border: 1px solid var(--pk-line-strong);
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.84);
    color: var(--pk-primary);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.04em;
    margin-bottom: 14px;
    backdrop-filter: blur(10px);
  }

  body.listing-page .top h1,
  body.listing-page .hero h1,
  body.listing-page .page-title {
    margin: 0;
    font-size: clamp(28px, 4vw, 40px);
    line-height: 1.12;
    letter-spacing: -0.04em;
    font-weight: 900;
    color: var(--pk-text);
  }

  body.listing-page .top > div:first-child,
  body.listing-page .hero > div:first-child {
    position: relative;
  }

  body.listing-page .top > div:first-child::before,
  body.listing-page .hero > div:first-child::before {
    content: "퐁퐁코리아 디렉터리";
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 36px;
    padding: 8px 14px;
    border: 1px solid var(--pk-line-strong);
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.84);
    color: var(--pk-primary);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.04em;
    margin-bottom: 14px;
    backdrop-filter: blur(10px);
  }

  body.listing-page .top p,
  body.listing-page .hero p {
    margin: 12px 0 0;
    max-width: 720px;
    color: var(--pk-sub);
    font-size: 15px;
    line-height: 1.75;
    word-break: keep-all;
  }

  body.listing-page .listing-meta-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 18px;
  }

  body.listing-page .listing-meta-pill {
    display: inline-flex;
    align-items: center;
    min-height: 40px;
    padding: 0 14px;
    border-radius: 999px;
    border: 1px solid rgba(199, 210, 254, 0.92);
    background: rgba(255, 255, 255, 0.86);
    color: var(--pk-sub);
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
  }

  body.listing-page .search,
  body.listing-page .search-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    max-width: 420px;
    padding: 8px;
    border: 1px solid rgba(219, 228, 240, 0.96);
    border-radius: 22px;
    background: rgba(255, 255, 255, 0.92);
    box-shadow: 0 12px 24px rgba(15, 23, 42, 0.07);
    backdrop-filter: blur(10px);
  }

  body.listing-page .search:focus-within,
  body.listing-page .search-bar:focus-within {
    border-color: rgba(99, 102, 241, 0.6);
    box-shadow: 0 16px 32px rgba(67, 56, 202, 0.16);
  }

  body.listing-page .search input,
  body.listing-page .search-bar input {
    width: 100%;
    min-width: 0;
    min-height: 48px;
    padding: 0 16px;
    border: 0;
    outline: none;
    border-radius: 16px;
    background: transparent;
    color: var(--pk-text);
    font-size: 15px;
  }

  body.listing-page .search input::placeholder,
  body.listing-page .search-bar input::placeholder {
    color: #8b97ad;
  }

  body.listing-page .search button,
  body.listing-page .search-bar button,
  body.listing-page .btn,
  body.listing-page .btn-detail,
  body.listing-page .listing-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 48px;
    padding: 0 18px;
    border: 1px solid transparent;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--pk-primary) 0%, var(--pk-primary-strong) 100%);
    color: #ffffff;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: -0.01em;
    white-space: nowrap;
    box-shadow: 0 10px 20px rgba(55, 48, 163, 0.18);
    cursor: pointer;
    transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease, border-color 0.18s ease, color 0.18s ease;
  }

  body.listing-page .search button:hover,
  body.listing-page .search-bar button:hover,
  body.listing-page .btn:hover,
  body.listing-page .btn-detail:hover,
  body.listing-page .listing-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 14px 26px rgba(55, 48, 163, 0.22);
  }

  body.listing-page .search button:focus-visible,
  body.listing-page .search-bar button:focus-visible,
  body.listing-page .btn:focus-visible,
  body.listing-page .btn-detail:focus-visible,
  body.listing-page .listing-action:focus-visible,
  body.listing-page .card:focus-visible {
    outline: 3px solid rgba(99, 102, 241, 0.22);
    outline-offset: 3px;
  }

  body.listing-page .btn.primary {
    background: linear-gradient(135deg, var(--pk-primary) 0%, var(--pk-primary-strong) 100%);
    color: #ffffff;
    border-color: transparent;
  }

  body.listing-page .btn:not(.primary) {
    background: rgba(255, 255, 255, 0.88);
    color: var(--pk-primary);
    border-color: rgba(199, 210, 254, 0.92);
    box-shadow: none;
  }

  body.listing-page .btn:not(.primary):hover {
    background: var(--pk-primary-soft);
  }

  body.listing-page .ad {
    margin: 18px 0;
    text-align: center;
  }

  body.listing-page .grid,
  body.listing-page .card-container {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
    margin-top: 20px;
  }

  body.listing-page .card {
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 12px;
    min-height: 100%;
    padding: 20px;
    border: 1px solid rgba(219, 228, 240, 0.96);
    border-radius: var(--pk-radius-md);
    background:
      linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.96) 100%);
    box-shadow: var(--pk-shadow-sm);
    transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    overflow: hidden;
  }

  body.listing-page .card::before {
    content: "";
    position: absolute;
    left: 20px;
    top: 0;
    width: 56px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--pk-primary) 0%, #0ea5e9 100%);
  }

  body.listing-page a.card:hover,
  body.listing-page .card:hover,
  body.listing-page .card[onclick]:hover {
    transform: translateY(-4px);
    border-color: rgba(167, 180, 252, 0.92);
    box-shadow: 0 22px 42px rgba(15, 23, 42, 0.1);
  }

  body.listing-page .name,
  body.listing-page .card h3 {
    margin: 0;
    font-size: 18px;
    line-height: 1.35;
    font-weight: 900;
    letter-spacing: -0.03em;
    color: var(--pk-text);
  }

  body.listing-page .meta,
  body.listing-page .card p {
    margin: 0;
    color: var(--pk-sub);
    font-size: 13.5px;
    line-height: 1.7;
    word-break: keep-all;
  }

  body.listing-page .chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: auto;
    padding-top: 4px;
  }

  body.listing-page .chip,
  body.listing-page .pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    min-height: 34px;
    padding: 0 12px;
    border: 1px solid rgba(191, 219, 254, 0.94);
    border-radius: 999px;
    background: linear-gradient(180deg, var(--pk-primary-soft) 0%, rgba(239, 246, 255, 0.96) 100%);
    color: var(--pk-primary);
    font-size: 12px;
    font-weight: 800;
  }

  body.listing-page .actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: auto;
    padding-top: 4px;
  }

  body.listing-page .empty-state {
    grid-column: 1 / -1;
    align-items: center;
    justify-content: center;
    min-height: 180px;
    text-align: center;
    padding: 32px 24px;
    border-style: dashed;
    background:
      linear-gradient(180deg, rgba(255, 255, 255, 0.9) 0%, rgba(238, 242, 255, 0.9) 100%);
  }

  body.listing-page .empty-state .name {
    font-size: 20px;
  }

  body.listing-page .empty-state .meta {
    max-width: 480px;
  }

  @media (max-width: 980px) {
    body.listing-page .top,
    body.listing-page .hero {
      grid-template-columns: 1fr;
    }

    body.listing-page .search,
    body.listing-page .search-bar {
      max-width: 100%;
    }

    body.listing-page .grid,
    body.listing-page .card-container {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  @media (max-width: 640px) {
    body.listing-page .container {
      padding: 18px 14px 44px;
    }

    body.listing-page .top,
    body.listing-page .hero {
      padding: 22px 18px;
      border-radius: 24px;
      gap: 16px;
    }

    body.listing-page .listing-kicker {
      margin-bottom: 12px;
    }

    body.listing-page .search,
    body.listing-page .search-bar {
      flex-wrap: nowrap;
      padding: 6px;
      border-radius: 18px;
    }

    body.listing-page .search input,
    body.listing-page .search-bar input {
      min-height: 44px;
      padding: 0 12px;
      font-size: 14px;
    }

    body.listing-page .search button,
    body.listing-page .search-bar button,
    body.listing-page .btn,
    body.listing-page .btn-detail,
    body.listing-page .listing-action {
      min-height: 44px;
      padding: 0 15px;
      border-radius: 14px;
      font-size: 13px;
    }

    body.listing-page .grid,
    body.listing-page .card-container {
      grid-template-columns: 1fr;
      gap: 14px;
    }

    body.listing-page .card {
      padding: 18px;
      border-radius: 18px;
    }

    body.listing-page .name,
    body.listing-page .card h3 {
      font-size: 17px;
    }
  }
</style>
