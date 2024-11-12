<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="32ICtfA9W_GY36z5sfWlyLwYFrrcbK8qUDEbAFCDQMU" />
    <meta name="naver-site-verification" content="3364bf3d26f95db9c37f59a7acb7f4523cc8c823" />
    <meta name="google-adsense-account" content="ca-pub-6686738239613464">
    <link rel="stylesheet" href="/css/index.css"> 
    <title>풍퐁코리아 - 남녀차별, 퐁퐁남 토론 커뮤니티</title>
    
    <!-- SEO 메타태그 -->
    <meta name="description" content="풍코 커뮤니티 - 퐁퐁남, 남녀차별, 최신 이슈와 토론을 위한 플랫폼. 다양한 게시판에서 이슈와 유머를 함께 나눠보세요.">
    <meta name="keywords" content="퐁퐁남, 남녀차별, 토론, 커뮤니티, 풍코, 유머, 이슈">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="풍코 - 남녀차별과 퐁퐁남 이슈 커뮤니티">
    <meta property="og:description" content="풍코 커뮤니티에서 퐁퐁남, 남녀차별 등 다양한 이슈를 자유롭게 토론하세요.">
    <meta property="og:image" content="https://pongpongkorea.com/path/to/thumbnail.jpg">
    <meta property="og:url" content="https://pongpongkorea.com">
    <meta property="og:type" content="website">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="풍코 - 남녀차별과 퐁퐁남 이슈 커뮤니티">
    <meta name="twitter:description" content="풍코 커뮤니티에서 남녀차별, 퐁퐁남 등 사회적 이슈와 유머를 함께 즐겨보세요.">
    <meta name="twitter:image" content="https://pongpongkorea.com/path/to/thumbnail.jpg">
    

</head>
<body>
<!--헤더자리-->
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
<div class="ad-container">
    <iframe src="https://ads-partners.coupang.com/widgets.html?id=819616&template=carousel&trackingCode=AF8077807&subId=&width=680&height=140&tsource=" 
            class="ad-iframe" 
            frameborder="0" 
            scrolling="no" 
            referrerpolicy="unsafe-url"></iframe>
</div>

<?php foreach ($postsByCategory as $categoryName => $posts): ?>
    <div class="category">
        <h2><a href="/posts?category=<?= urlencode($categoryName) ?>" class="category-link"><?= esc($categoryName) ?></a></h2>
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h3>
                        <a href="/posts/<?= esc($post['id']) ?>" class="post-link">
                            <?= esc($post['title']) ?> <span class="reply-count">[<?= esc($post['reply_count']) ?>]</span>
                        </a>
                    </h3>
                    <div class="post-info">
                        <p>작성자: <?= esc($post['nickname']) ?></p>
                        <p><?= esc($post['created_at']) ?> | 조회수: <?= esc($post['view_count']) ?> | 추천: <?= esc($post['likes']) ?> | 비추천: <?= esc($post['dislikes']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>게시글이 없습니다.</p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const categoryLinks = document.querySelectorAll(".category-link");
        
        // 카테고리 이름과 ID 매핑
        const categories = {
            "공지사항": 99,
            "베스트": 9,
            "퐁코 토론": 1,
            "퐁코 이슈": 8,
            "자유 게시판": 4,
            "유머 게시판": 7
        };

        categoryLinks.forEach(link => {
            link.addEventListener("click", function(event) {
                event.preventDefault(); // 기본 링크 이동을 막음
                
                const categoryName = this.textContent.trim();
                const categoryId = categories[categoryName];

                if (categoryId !== undefined) {
                    // URL을 카테고리 ID로 변경하여 이동
                    window.location.href = `/posts?category=${encodeURIComponent(categoryId)}`;
                }
            });
        });
    });
</script>


<script>
    // 메뉴 토글 함수
    function toggleMenu() {
        const menu = document.querySelector('.hd_dd_menu');
        menu.classList.toggle('active');
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
</html>
