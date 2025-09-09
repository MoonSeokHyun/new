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

  <!-- ✅ 쿠팡 파트너스 배너 (정적/비플로팅/비모달) -->
  <section class="coupang-banner" role="region" aria-label="쿠팡 파트너스 배너" id="coupang-banner" hidden>
    <div class="banner-inner">
      <a class="banner-link" href="https://link.coupang.com/a/cPfAe6" target="_blank" rel="noopener noreferrer nofollow sponsored" aria-label="쿠팡 제철 특가 자세히 보기">
        <img class="banner-hero" src="https://image8.coupangcdn.com/image/affiliate/event/promotion/2025/09/05/7162093536a5003c01e713ab6fc6faf3.png" alt="쿠팡 제철 특가 배너" loading="lazy" />
      </a>
      <div class="banner-cta-row">
        <strong class="banner-title">제철 특가</strong>
        <a class="banner-cta" href="https://link.coupang.com/a/cPfAe6" target="_blank" rel="noopener noreferrer nofollow sponsored">자세히 보기</a>
        <button class="banner-close" type="button" aria-label="배너 닫기">×</button>
      </div>
      <p class="banner-disclaimer">이 게시물은 쿠팡 파트너스 활동의 일환으로, 이에 따른 일정액의 수수료를 제공받습니다.</p>
    </div>
  </section>
</div>
<!-- 헤더 끝 -->

<style>
  /* ====== 헤더 ====== */
  #header-wrapper header { background-color:#62D491; color:#fff; padding:1.5rem 1rem; text-align:center; }
  #header-wrapper header h1, #header-wrapper header h2 { font-size:29px; margin-bottom:4px; }
  #header-wrapper header p { font-size:16px; margin-top:4px; }
  #header-wrapper .main-nav { background-color:#e6f7ef; padding:0.7rem; text-align:center; position:relative; z-index:1; }
  #header-wrapper .top-menu { list-style:none; display:flex; gap:2rem; justify-content:center; margin:0; padding:0; position:relative; flex-wrap:wrap; }
  #header-wrapper .top-menu>li { position:relative; }
  #header-wrapper .top-menu>li>a { text-decoration:none; color:#3eaf7c; font-weight:bold; font-size:16px; padding:10px 15px; border-radius:8px; transition:background-color .3s ease, transform .3s ease; }
  #header-wrapper .top-menu>li>a:hover { background-color:#3eaf7c; color:#fff; transform:translateY(-2px); }
  .sub-menu { display:none; position:absolute; top:100%; left:0; background:#fff; border:1px solid #ccc; border-radius:6px; padding:.5rem 0; min-width:180px; list-style:none; box-shadow:0 4px 8px rgba(0,0,0,.1); z-index:10; }
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

  /* ====== 배너 (정적) ====== */
  .coupang-banner { background:#fff; border-top:1px solid #eaeaea; border-bottom:1px solid #eaeaea; }
  .coupang-banner[hidden]{ display:none !important; }
  .coupang-banner .banner-inner { max-width:1100px; margin:0 auto; padding:12px 16px 10px; }

  /* 이미지는 높이 과다로 본문 가림 방지 */
  .banner-hero{
    width:100%; display:block;
    aspect-ratio: 16 / 9;         /* 고정 비율 */
    object-fit: cover;             /* 과도한 세로 길이 방지 */
    max-height: 240px;             /* 1차 안전장치 */
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,.06);
    background:#f3f3f3;
  }

  .banner-cta-row { display:flex; align-items:center; gap:10px; margin-top:10px; }
  .banner-title{ font-size:15px; color:#333; }
  .banner-cta {
    margin-left:auto; display:inline-block; padding:10px 14px;
    font-weight:700; background:#1677ff; color:#fff; text-decoration:none; border-radius:8px;
  }
  .banner-close {
    appearance:none; border:none; background:#f2f3f5; color:#222;
    width:32px; height:32px; line-height:32px; border-radius:50%; cursor:pointer; font-size:18px;
  }
  .banner-disclaimer { margin:8px 0 0; font-size:12px; color:#666; }

  @media (max-width:520px){
    .banner-cta{ padding:9px 12px; font-size:14px; }
    .banner-close{ width:28px; height:28px; font-size:16px; }
    .banner-hero{ max-height: 200px; } /* 모바일에서 더 낮춤 */
  }
</style>

<!-- 모바일 드롭다운 + 배너 스크립트 -->
<script>
  // 모바일 드롭다운
  if (window.innerWidth <= 768) {
    document.querySelectorAll("#header-wrapper .menu-group > a.dropdown-toggle").forEach(function(toggleLink) {
      toggleLink.addEventListener('click', function(e) {
        e.preventDefault();
        var submenu = toggleLink.nextElementSibling;
        if (submenu) submenu.style.display = submenu.style.display === "block" ? "none" : "block";
      });
    });
  }

  /* ====== 쿠키 유틸 ====== */
  function setCookie(name, value, maxAgeSeconds) {
    var cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + ";path=/;SameSite=Lax";
    if (maxAgeSeconds) cookie += ";max-age=" + maxAgeSeconds;
    document.cookie = cookie;
  }
  function getCookie(name) {
    var m = document.cookie.match(new RegExp('(?:^|; )' + encodeURIComponent(name) + '=([^;]*)'));
    return m ? decodeURIComponent(m[1]) : null;
  }

  /* ====== 배너 동작 (정적/가림 방지) ====== */
  (function initCoupangBanner(){
    var banner = document.getElementById("coupang-banner");
    if (!banner) return;

    var closeBtn = banner.querySelector(".banner-close");
    var HIDE_COOKIE = "hide_coupang_banner";
    var HIDE_SECONDS = 60 * 60 * 2; // 2시간

    // 닫은 적 없으면 표시
    if (!getCookie(HIDE_COOKIE)) {
      banner.hidden = false;
    }

    // 닫기 시 2시간 숨김
    if (closeBtn) {
      closeBtn.addEventListener("click", function(){
        banner.hidden = true;
        setCookie(HIDE_COOKIE, "1", HIDE_SECONDS);
      });
    }
  })();
</script>
