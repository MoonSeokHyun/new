<style>
    /* 네비게이션 바 스타일 */
#hd_section {
    background-color: #333;
    padding: 3px 3px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
#hd_section a {
    color: #00d8ff;
    text-decoration: none;
    font-weight: bold;
    margin: 0 10px;
    padding: 8px;
    font-size: 0.9em;
    transition: background-color 0.3s ease;
}
#hd_section a:hover {
    background-color: #444;
    border-radius: 3px;
}

/* 모바일 메뉴 버튼 스타일 */
.menu-toggle {
    display: none;
    background-color: transparent;
    border: none;
    font-size: 20px;
    color: #00d8ff;
    cursor: pointer;
}

/* 드롭다운 메뉴 스타일 */
.hd_dd_menu {
    position: relative;
}
.hd_dd_menu ul {
    display: flex;
    list-style: none;
    flex-wrap: wrap;
}
.hd_dd_menu .has-sub {
    position: relative;
}
.hd_dd_menu .has-sub .dd_toggle {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: #444;
    border-radius: 3px;
    padding: 8px 0;
    min-width: 120px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.hd_dd_menu .has-sub:hover .dd_toggle {
    display: block;
}
.hd_dd_menu .has-sub .dd_toggle a {
    color: #ddd;
    display: block;
    padding: 6px 15px;
    text-decoration: none;
    font-size: 0.85em;
}
.hd_dd_menu .has-sub .dd_toggle a:hover {
    background-color: #333;
}

/* 모바일 스타일 */
@media (max-width: 768px) {
    .menu-toggle {
        display: block;
    }
    .hd_dd_menu {
        display: none;
        flex-direction: column;
        width: 100%;
        background-color: #333;
        padding: 10px 0;
        border-radius: 3px;
    }
    .hd_dd_menu.active {
        display: flex;
    }
}
    </style>


<div id="hd_section">
    <a href="/">퐁퐁코리아 도태남 집합소</a>
    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
    <div class="hd_dd_menu">
        <ul>
            <li class="has-sub"><a href="/">메인</a></li>
            <li class="has-sub">
                <a href="#">공지사항</a>
                <div class="dd_toggle">
                    <a href="/posts?category=99">공지사항</a>
                </div>
            </li>
            <li class="has-sub">
                <a href="#">베스트 게시판</a>
                <div class="dd_toggle">
                    <a href="/posts?category=9">풍코 베스트</a>
                </div>
            </li>
            <li class="has-sub">
                <a href="#">전체 게시판</a>
                <div class="dd_toggle">
                    <a href="/posts?category=1">풍코 토론</a>
                    <a href="/posts?category=8">풍코 이슈</a>
                    <a href="/posts?category=4">자유 게시판</a>
                    <a href="/posts?category=7">유머 게시판</a>
                </div>
            </li>
        </ul>
    </div>
</div>

<script>
    // 메뉴 토글 함수
    function toggleMenu() {
        const menu = document.querySelector('.hd_dd_menu');
        menu.classList.toggle('active');
    }
</script>