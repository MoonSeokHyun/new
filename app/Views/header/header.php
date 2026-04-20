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
    <a href="/">퐁퐁코리아</a>
    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
    <div class="hd_dd_menu">
        <ul>
            <li class="has-sub"><a href="/">메인</a></li>
            <li class="has-sub">
                <a href="#">생활시설</a>
                <div class="dd_toggle">
                    <a href="/hairsalon">미용실</a>
                    <a href="/library-info">도서관</a>
                    <a href="/open-service-info">안경점</a>
                    <a href="/animal-hospital">동물병원</a>
                </div>
            </li>
            <li class="has-sub">
                <a href="#">야외활동</a>
                <div class="dd_toggle">
                    <a href="/camping">캠핑장</a>
                    <a href="/sports-facility">체육시설</a>
                </div>
            </li>
            <li class="has-sub">
                <a href="#">기타</a>
                <div class="dd_toggle">
                    <a href="/world-res">세계음식</a>
                    <a href="/seminar-rooms">공유회의실</a>
                    <a href="/installation">폐의약품</a>
                    <a href="/clothing-collection-bin">의류 수거함</a>
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