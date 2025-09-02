<!-- 헤더 시작 -->
<div id="header-wrapper">
  <!-- 사이트 타이틀 -->
  <header>
    <h2>퐁퐁</h2>
    <p>퐁퐁터지는 생황시설 정보</p>
  </header>

  <!-- 네비게이션 -->
  <nav class="main-nav">
    <ul class="top-menu">
      <!-- 서비스 -->
      <li class="menu-group">
        <a href="#" class="dropdown-toggle">🛠️ 서비스 ▾</a>
        <ul class="sub-menu">
          <li><a href="/hairsalon">💇 미용실</a></li>
          <li><a href="/seminar_rooms">🏢 공유회의실</a></li>
          <li><a href="/LibraryInfo">📚 도서관</a></li>
          <li><a href="/shops">👓 안경점</a></li>
          <li><a href="/animal-hospital">🐶 동물병원</a></li>
        </ul>
      </li>

      <!-- 재활용 -->
      <li class="menu-group">
        <a href="#" class="dropdown-toggle">♻️ 재활용 ▾</a>
        <ul class="sub-menu">
          <li><a href="/installation">💊 폐의약품</a></li>
          <li><a href="/clothingcollectionbin">👕 폐의류</a></li>
        </ul>
      </li>

      <!-- 야외활동 -->
      <li class="menu-group">
        <a href="#" class="dropdown-toggle">🌳 야외활동 ▾</a>
        <ul class="sub-menu">
          <li><a href="/camping">🏕️ 캠핑장</a></li>
          <li><a href="/sports_facilities">🏟️ 체육시설</a></li>
        </ul>
      </li>

      <!-- 맛집 -->
      <li class="menu-group">
        <a href="#" class="dropdown-toggle">🍽️ 맛집 ▾</a>
        <ul class="sub-menu">
          <li><a href="/world_res">🌍 세계음식</a></li>
        </ul>
      </li>
    </ul>
  </nav>
</div>

<!-- ✅ 쿠팡 파트너스 모달 (오버레이) -->
<div id="coupang-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="coupang-modal-title" style="display:none;">
  <div id="coupang-modal">
    <button id="coupang-modal-close" type="button" aria-label="닫기">×</button>

    <!-- 상단 로고/타이틀 -->
    <div class="modal-header">
      <img class="coupang-logo" src="https://static.coupangcdn.com/image/coupang/common/logo_coupang_w360.png" alt="coupang" />
      <h3 id="coupang-modal-title">제철 특가</h3>
    </div>

    <!-- 광고 이미지 (링크 + 이미지 교체됨) -->
    <a class="modal-link" href="https://link.coupang.com/a/cOmD6P" target="_blank" rel="noopener noreferrer nofollow sponsored">
      <img class="modal-hero" src="https://image14.coupangcdn.com/image/affiliate/event/promotion/2025/09/02/75aed5e5e3ab00900154b168f10fa550.png" alt="쿠팡 특가 배너" />
    </a>

    <!-- 하단 CTA 바 -->
    <a class="modal-cta" href="https://link.coupang.com/a/cOmD6P" target="_blank" rel="noopener noreferrer nofollow sponsored">자세히 보기</a>

    <!-- 고지문 -->
    <p class="disclaimer">※ 본 링크는 쿠팡 파트너스 활동의 일환으로, 이에 따른 일정액의 수수료를 제공받을 수 있습니다.</p>
  </div>
</div>

<style>
  /* ====== 기존 헤더 스타일 그대로 유지 ====== */
  #header-wrapper header { background-color:#62D491; color:#fff; padding:1.5rem 1rem; text-align:center; }
  #header-wrapper header h1 { font-size:29px; margin-bottom:4px; }
  #header-wrapper header p { font-size:16px; margin-top:4px; }
  #header-wrapper .main-nav { background-color:#e6f7ef; padding:0.7rem; text-align:center; position:relative; z-index:9999; }
  #header-wrapper .top-menu { list-style:none; display:flex; gap:2rem; justify-content:center; margin:0; padding:0; position:relative; flex-wrap:wrap; }
  #header-wrapper .top-menu>li { position:relative; }
  #header-wrapper .top-menu>li>a { text-decoration:none; color:#3eaf7c; font-weight:bold; font-size:16px; padding:10px 15px; border-radius:8px; transition:background-color .3s ease, transform .3s ease; }
  #header-wrapper .top-menu>li>a:hover { background-color:#3eaf7c; color:#fff; transform:translateY(-2px); }
  .sub-menu { display:none; position:absolute; top:100%; left:0; background:#fff; border:1px solid #ccc; border-radius:6px; padding:.5rem 0; min-width:180px; list-style:none; box-shadow:0 4px 8px rgba(0,0,0,.1); z-index:10000; }
  .menu-group:hover .sub-menu { display:block; }
  .sub-menu li a { display:block; padding:8px 16px; color:#3eaf7c; font-size:14px; text-decoration:none; }
  .sub-menu li a:hover { background-color:#f0fdf8; }
  @media (max-width:768px){
    #header-wrapper .top-menu{ flex-direction:row; flex-wrap:wrap; justify-content:center; gap:1rem; }
    #header-wrapper .top-menu>li{ width:auto; }
    #header-wrapper .top-menu>li>a{ padding:10px 15px; }
    .sub-menu{ position:absolute; top:100%; left:0; }
    .menu-group:hover .sub-menu{ display:block; }
    .sub-menu li a{ font-size:14px; }
  }
  .adsbygoogle{ display:block; text-align:center; margin:0 auto; }

  /* ====== 모달 스타일 ====== */
  html.no-scroll, body.no-scroll { overflow: hidden !important; }

  #coupang-modal-overlay{
    position: fixed; inset: 0;
    background: rgba(0,0,0,.6);
    display: flex; align-items: center; justify-content: center;
    z-index: 100000; /* 헤더/메뉴보다 위 */
    padding: 16px; /* 모바일 안전 여백 */
  }

  #coupang-modal{
    position: relative;
    width: 100%;
    max-width: 420px; /* 모바일~태블릿 */
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0,0,0,.25);
    overflow: hidden;
    animation: modalIn .24s ease-out;
  }
  @keyframes modalIn {
    from { transform: translateY(12px); opacity: .0; }
    to   { transform: translateY(0); opacity: 1; }
  }

  #coupang-modal-close{
    position: absolute; top: 8px; right: 8px;
    width: 36px; height: 36px;
    border: none; border-radius: 50%;
    background: rgba(0,0,0,.55); color: #fff;
    font-size: 22px; line-height: 36px; cursor: pointer;
  }
  #coupang-modal-close:hover{ filter: brightness(.9); }

  .modal-header{
    display:flex; align-items:center; gap:8px;
    padding: 12px 16px 0 16px;
  }
  .coupang-logo{ height:18px; width:auto; display:block; }
  #coupang-modal-title{ font-size:18px; margin: 0 0 8px 0; }

  .modal-link{ display:block; }
  .modal-hero{
    width: 100%; height: auto; display:block;
    aspect-ratio: 4 / 3; object-fit: cover; /* 이미지 비율 보호 */
    background: #f3f3f3;
  }

  .modal-cta{
    display: block;
    text-align: center;
    font-weight: 700;
    padding: 14px 16px;
    background: #1677ff; color: #fff; text-decoration: none;
    font-size: 16px;
    border-radius: 0 0 16px 16px;
  }
  .modal-cta:active{ filter: brightness(.95); }

  .disclaimer{
    margin: 10px 16px 14px;
    font-size: 12px; color: #666; line-height: 1.45;
  }

  /* 더 작은 기기 최적화 */
  @media (max-width: 360px){
    #coupang-modal{ max-width: 100%; }
    .modal-cta{ font-size: 15px; padding: 12px 14px; }
  }
</style>

<!-- 모바일 드롭다운 토글 + 모달 스크립트 -->
<script>
  // 모바일 드롭다운
  if (window.innerWidth <= 768) {
    document.querySelectorAll("#header-wrapper .menu-group > a.dropdown-toggle").forEach(function(toggleLink) {
      toggleLink.addEventListener('click', function(e) {
        e.preventDefault();
        var submenu = toggleLink.nextElementSibling;
        if (submenu) {
          submenu.style.display = submenu.style.display === "block" ? "none" : "block";
        }
      });
    });
  }

  /* ========= 쿠키 유틸 ========= */
  function setCookie(name, value, maxAgeSeconds) {
    var cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + ";path=/;SameSite=Lax";
    if (maxAgeSeconds) cookie += ";max-age=" + maxAgeSeconds;
    document.cookie = cookie;
  }
  function getCookie(name) {
    var m = document.cookie.match(new RegExp('(?:^|; )' + encodeURIComponent(name) + '=([^;]*)'));
    return m ? decodeURIComponent(m[1]) : null;
  }

  /* ========= 모달 동작 ========= */
  (function initCoupangModal(){
    var OVERLAY_ID = "coupang-modal-overlay";
    var CLOSE_ID = "coupang-modal-close";
    var HIDE_COOKIE = "hide_coupang_modal";
    var HIDE_SECONDS = 60 * 60 * 2; // 2시간

    var overlay = document.getElementById(OVERLAY_ID);
    if (!overlay) return;

    function openModal(){
      overlay.style.display = "flex";
      document.documentElement.classList.add("no-scroll");
      document.body.classList.add("no-scroll");
    }
    function closeModal(){
      overlay.style.display = "none";
      document.documentElement.classList.remove("no-scroll");
      document.body.classList.remove("no-scroll");
      setCookie(HIDE_COOKIE, "1", HIDE_SECONDS);
    }

    // 최초 노출 (쿠키 없으면)
    if (!getCookie(HIDE_COOKIE)) {
      // 이미지/레이아웃 준비 후 살짝 늦게 열어 깜빡임 방지
      window.requestAnimationFrame(openModal);
    }

    // 닫기 버튼
    var closeBtn = document.getElementById(CLOSE_ID);
    if (closeBtn) closeBtn.addEventListener("click", closeModal);

    // 오버레이 빈 공간 클릭 시 닫기 (모달 내부 클릭은 제외)
    overlay.addEventListener("click", function(e){
      if (e.target === overlay) closeModal();
    });

    // ESC 키 닫기
    document.addEventListener("keydown", function(e){
      if (e.key === "Escape" && overlay.style.display !== "none") closeModal();
    });
  })();
</script>
