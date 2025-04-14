
<!-- 헤더 시작 -->
<div id="header-wrapper">
  <!-- 사이트 타이틀 -->
  <header>
    <h1>퐁퐁</h1>
    <p>퐁하고 터지는 정보 퐁퐁코리아!</p>
  </header>

  <!-- 네비게이션 -->
  <nav class="main-nav">
    <ul class="top-menu">
      <!-- 편의점 메뉴 -->
      <li class="menu-group">
        <a href="#" class="dropdown-toggle">🍩 편의시설 </a>
        <ul class="sub-menu">
          <li><a href="/hairsalon">미용실</a></li>
        </ul>
      </li>

    </ul>

    <ul class="top-menu">
      <!-- 편의점 메뉴 -->
      <li class="menu-group">
        <a href="#" class="dropdown-toggle"> 😀 유머 </a>
        <ul class="sub-menu">
          <li><a href="/posts?category=9">베스트</a></li>
          <li><a href="/posts?category=7">웃긴자료</a></li>
        </ul>
      </li>

    </ul>
  </nav>
</div>

<!-- 스타일 -->
<!-- 스타일 수정 -->
<style>
  #header-wrapper header {
    background-color: #FFF3B0; /* 메인 헤더 컬러 - 파스텔 노랑 */
    color: #333;
    padding: 1.5rem 1rem;
    text-align: center;
  }

  #header-wrapper header h1 {
    font-size: 29px;
    margin-bottom: 4px;
    color: #d4a800; /* 딥 노랑 강조 */
  }

  #header-wrapper header p {
    font-size: 16px;
    margin-top: 4px;
  }

  #header-wrapper .main-nav {
    background-color: #fffbe6; /* 밝은 노랑 네비 */
    padding: 0.7rem;
    text-align: center;
    position: relative;
    z-index: 9999;
  }

  #header-wrapper .top-menu {
    list-style: none;
    display: flex;
    gap: 2rem;
    justify-content: center;
    margin: 0;
    padding: 0;
    position: relative;
    flex-direction: row; /* 메뉴를 가로로 배치 */
    flex-wrap: nowrap; /* 메뉴 항목들이 세로로 안 나가도록 설정 */
  }

  #header-wrapper .top-menu > li {
    position: relative;
  }

  #header-wrapper .top-menu > li > a {
    text-decoration: none;
    color: #d4a800;
    font-weight: bold;
    font-size: 16px;
    padding: 10px 15px;
    border-radius: 8px;
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  #header-wrapper .top-menu > li > a:hover {
    background-color: #ffe066;
    color: #333;
    transform: translateY(-2px);
  }

  .sub-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 0.5rem 0;
    min-width: 180px;
    list-style: none;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    z-index: 10000;
  }

  .menu-group:hover .sub-menu {
    display: block;
  }

  .sub-menu li a {
    display: block;
    padding: 8px 16px;
    color: #d4a800;
    font-size: 14px;
    text-decoration: none;
  }

  .sub-menu li a:hover {
    background-color: #fff8d6;
  }

  @media (max-width: 768px) {
    #header-wrapper .top-menu {
      flex-direction: column; /* 모바일에서는 세로로 */
      gap: 1rem;
    }

    #header-wrapper .top-menu > li {
      width: auto;
    }

    #header-wrapper .top-menu > li > a {
      padding: 10px 15px;
    }

    .sub-menu {
      position: absolute;
      top: 100%;
      left: 0;
    }

    .menu-group:hover .sub-menu {
      display: block;
    }

    .sub-menu li a {
      font-size: 14px;
    }
  }

  .adsbygoogle {
    display: block;
    text-align: center;
    margin: 0 auto;
  }
</style>


<!-- 모바일 드롭다운 토글 스크립트 -->
<script>
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
</script>

<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
if(!wcs_add) var wcs_add = {};
wcs_add["wa"] = "8bcce9183d61c0";
if(window.wcs) {
wcs_do();
}
</script>
</body>
