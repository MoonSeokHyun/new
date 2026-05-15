<!-- 헤더 시작 -->
<style>
  * { box-sizing: border-box; }

  #pk-header {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: #fff;
    border-bottom: 1px solid #E2E8F0;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
  }

  .pk-hd-bar {
    max-width: 960px;
    margin: 0 auto;
    padding: 0 16px;
    display: flex;
    align-items: center;
    height: 50px;
    gap: 12px;
  }

  /* 로고 */
  .pk-logo {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 15px;
    font-weight: 900;
    color: #3730A3;
    text-decoration: none;
    white-space: nowrap;
    letter-spacing: -.3px;
    flex-shrink: 0;
  }
  .pk-logo-badge {
    width: 24px;
    height: 24px;
    background: #3730A3;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: #fff;
    flex-shrink: 0;
  }

  /* 데스크톱 Nav */
  .pk-nav-desk {
    display: flex;
    align-items: center;
    gap: 2px;
    flex: 1;
  }

  /* hover 영역 끊김 방지: group이 버튼 아래까지 덮음 */
  .pk-nav-group {
    position: relative;
    padding-bottom: 0;
  }

  .pk-nav-btn {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 6px 10px;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    border-radius: 7px;
    cursor: pointer;
    text-decoration: none;
    border: none;
    background: none;
    white-space: nowrap;
    transition: background .15s, color .15s;
    line-height: 1;
  }
  .pk-nav-btn:hover,
  .pk-nav-group:hover .pk-nav-btn {
    background: #EEF2FF;
    color: #3730A3;
  }
  .pk-nav-chevron {
    width: 9px;
    height: 9px;
    transition: transform .2s;
    flex-shrink: 0;
  }
  .pk-nav-group:hover .pk-nav-chevron {
    transform: rotate(180deg);
  }

  /* 드롭다운: top:100%에 붙이고 padding-top으로 시각 간격 확보
     → 버튼과 메뉴 사이 마우스 이동 중에도 hover가 유지됨 */
  .pk-sub {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    padding-top: 6px;
    min-width: 152px;
    z-index: 200;
  }
  .pk-nav-group:hover .pk-sub {
    display: block;
  }
  .pk-sub-box {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 5px;
    box-shadow: 0 6px 20px rgba(0,0,0,.1);
  }
  .pk-sub a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 10px;
    font-size: 12.5px;
    color: #374151;
    text-decoration: none;
    border-radius: 7px;
    font-weight: 500;
    transition: background .12s, color .12s;
    white-space: nowrap;
  }
  .pk-sub a:hover {
    background: #EEF2FF;
    color: #3730A3;
  }

  /* 햄버거 */
  .pk-burger {
    display: none;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    width: 34px;
    height: 34px;
    cursor: pointer;
    border: none;
    background: none;
    padding: 4px;
    margin-left: auto;
    border-radius: 6px;
    transition: background .15s;
  }
  .pk-burger:hover { background: #F1F5F9; }
  .pk-burger span {
    width: 18px;
    height: 2px;
    background: #475569;
    border-radius: 2px;
    display: block;
    transition: all .22s;
  }
  .pk-burger.is-open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
  .pk-burger.is-open span:nth-child(2) { opacity: 0; }
  .pk-burger.is-open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

  /* 모바일 드로어 */
  .pk-mob-drawer {
    display: none;
    background: #fff;
    border-top: 1px solid #F1F5F9;
  }
  .pk-mob-drawer.is-open { display: block; }

  .pk-mob-grp { border-bottom: 1px solid #F1F5F9; }

  .pk-mob-hd {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    font-size: 13.5px;
    font-weight: 700;
    color: #1E293B;
    border: none;
    background: none;
    cursor: pointer;
    text-align: left;
  }
  .pk-mob-hd svg {
    width: 12px;
    height: 12px;
    transition: transform .2s;
    flex-shrink: 0;
    color: #94A3B8;
  }
  .pk-mob-hd.is-open svg { transform: rotate(180deg); }

  .pk-mob-body {
    display: none;
    background: #F8FAFC;
    padding: 4px 10px 6px;
  }
  .pk-mob-body.is-open { display: block; }
  .pk-mob-body a {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 8px;
    font-size: 13px;
    color: #374151;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 500;
    transition: background .12s;
  }
  .pk-mob-body a:hover {
    background: #EEF2FF;
    color: #3730A3;
  }

  @media (max-width: 768px) {
    .pk-nav-desk { display: none; }
    .pk-burger { display: flex; }
  }
</style>

<header id="pk-header">
  <div class="pk-hd-bar">
    <a href="/" class="pk-logo">
      <span class="pk-logo-badge">🔍</span>
      퐁퐁코리아
    </a>

    <nav class="pk-nav-desk" aria-label="주 메뉴">
      <!-- 서비스 -->
      <div class="pk-nav-group">
        <button class="pk-nav-btn">
          🛠️ 서비스
          <svg class="pk-nav-chevron" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1.5 3.5l3.5 3.5 3.5-3.5"/></svg>
        </button>
        <div class="pk-sub">
          <div class="pk-sub-box">
            <a href="/hairsalon">💇 미용실</a>
            <a href="/seminar-rooms">🏢 공유회의실</a>
            <a href="/library-info">📚 도서관</a>
            <a href="/open-service-info">👓 안경점</a>
            <a href="/animal-hospital">🐶 동물병원</a>
          </div>
        </div>
      </div>
      <!-- 재활용 -->
      <div class="pk-nav-group">
        <button class="pk-nav-btn">
          ♻️ 재활용
          <svg class="pk-nav-chevron" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1.5 3.5l3.5 3.5 3.5-3.5"/></svg>
        </button>
        <div class="pk-sub">
          <div class="pk-sub-box">
            <a href="/installation">💊 폐의약품</a>
            <a href="/clothing-collection-bin">👕 폐의류</a>
          </div>
        </div>
      </div>
      <!-- 야외활동 -->
      <div class="pk-nav-group">
        <button class="pk-nav-btn">
          🌳 야외활동
          <svg class="pk-nav-chevron" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1.5 3.5l3.5 3.5 3.5-3.5"/></svg>
        </button>
        <div class="pk-sub">
          <div class="pk-sub-box">
            <a href="/camping">🏕️ 캠핑장</a>
            <a href="/sports-facility">🏟️ 체육시설</a>
          </div>
        </div>
      </div>
      <!-- 맛집 -->
      <div class="pk-nav-group">
        <button class="pk-nav-btn">
          🍽️ 맛집
          <svg class="pk-nav-chevron" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1.5 3.5l3.5 3.5 3.5-3.5"/></svg>
        </button>
        <div class="pk-sub">
          <div class="pk-sub-box">
            <a href="/world-res">🌍 세계음식</a>
          </div>
        </div>
      </div>
    </nav>

    <button class="pk-burger" id="pk-burger" aria-label="메뉴 열기" aria-expanded="false" aria-controls="pk-mob-drawer">
      <span></span><span></span><span></span>
    </button>
  </div>

  <!-- 모바일 드로어 -->
  <div class="pk-mob-drawer" id="pk-mob-drawer" aria-hidden="true">
    <div class="pk-mob-grp">
      <button class="pk-mob-hd">🛠️ 서비스 <svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1.5 3.5l3.5 3.5 3.5-3.5"/></svg></button>
      <div class="pk-mob-body">
        <a href="/hairsalon">💇 미용실</a>
        <a href="/seminar-rooms">🏢 공유회의실</a>
        <a href="/library-info">📚 도서관</a>
        <a href="/open-service-info">👓 안경점</a>
        <a href="/animal-hospital">🐶 동물병원</a>
      </div>
    </div>
    <div class="pk-mob-grp">
      <button class="pk-mob-hd">♻️ 재활용 <svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1.5 3.5l3.5 3.5 3.5-3.5"/></svg></button>
      <div class="pk-mob-body">
        <a href="/installation">💊 폐의약품</a>
        <a href="/clothing-collection-bin">👕 폐의류</a>
      </div>
    </div>
    <div class="pk-mob-grp">
      <button class="pk-mob-hd">🌳 야외활동 <svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1.5 3.5l3.5 3.5 3.5-3.5"/></svg></button>
      <div class="pk-mob-body">
        <a href="/camping">🏕️ 캠핑장</a>
        <a href="/sports-facility">🏟️ 체육시설</a>
      </div>
    </div>
    <div class="pk-mob-grp">
      <button class="pk-mob-hd">🍽️ 맛집 <svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1.5 3.5l3.5 3.5 3.5-3.5"/></svg></button>
      <div class="pk-mob-body">
        <a href="/world-res">🌍 세계음식</a>
      </div>
    </div>
  </div>

</header>

<!-- 헤더 하단 광고 -->
<div style="text-align:center; padding:6px 0; background:#fff; border-bottom:1px solid #F1F5F9;">
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-client="ca-pub-6686738239613464"
       data-ad-slot="1204098626"
       data-ad-format="auto"
       data-full-width-responsive="true"></ins>
  <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
</div>

<script>
  (function() {
    var burger = document.getElementById('pk-burger');
    var drawer = document.getElementById('pk-mob-drawer');
    if (!burger || !drawer) return;
    burger.addEventListener('click', function() {
      var open = drawer.classList.toggle('is-open');
      burger.classList.toggle('is-open', open);
      burger.setAttribute('aria-expanded', String(open));
      drawer.setAttribute('aria-hidden', String(!open));
      burger.setAttribute('aria-label', open ? '메뉴 닫기' : '메뉴 열기');
    });
    drawer.querySelectorAll('.pk-mob-hd').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var body = btn.nextElementSibling;
        var open = body.classList.toggle('is-open');
        btn.classList.toggle('is-open', open);
      });
    });
  })();
</script>
<!-- 헤더 끝 -->
