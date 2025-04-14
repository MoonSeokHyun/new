<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464"
     crossorigin="anonymous"></script>
    <title>게시글 목록</title>
    
    <style>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* 전체 스타일 */
    body {
        font-family: '돋움', 'Arial', sans-serif;
        background-color: #fff8e1; /* 노란색 파스텔톤 배경 */
        color: #6f6f6f; /* 텍스트 색상 변경 */
        margin: 0;
        padding: 20px;
    }
    @media (min-width: 768px) {
    body {
        margin: 0; /* 가운데 정렬을 제거 */
    }
}


    /* 모바일 스타일 */
    @media (max-width: 768px) {
        .menu-toggle {
            display: block;
        }
    }

    /* 게시글 목록 스타일 */
    h1 {
        color: #ffeb3b; /* 노란색 */
        font-size: 1.5em;
        margin-bottom: 15px;
        text-align: center;
    }

    a {
        text-decoration: none;
        color: #ff9800; /* 오렌지색 */
    }

    a:hover {
        color: #ff5722; /* 진한 오렌지 */
    }

    .btn {
        background-color: #f57c00; /* 진한 오렌지 */
        color: #fff;
        padding: 8px 12px;
        border: 1px solid #ff9800;
        border-radius: 3px;
        cursor: pointer;
        font-size: 0.9em;
        text-align: center;
        display: inline-block;
        margin-bottom: 15px;
        margin-left: 15px;
    }

    .btn:hover {
        background-color: #ff5722;
    }

    form {
        margin-top: 10px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    input[type="text"] {
        padding: 8px;
        border: 1px solid #ff9800;
        background-color: #fff3e0; /* 밝은 노란색 배경 */
        color: #6f6f6f;
        width: calc(100% - 100px);
        margin-right: 5px;
        border-radius: 3px;
    }

    button[type="submit"] {
        padding: 8px 12px;
        border: 1px solid #ff9800;
        background-color: #f57c00; /* 진한 오렌지 */
        color: #fff;
        border-radius: 3px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #ff5722;
    }

    ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    li {
        background-color: #ffecb3; /* 연한 노란색 배경 */
        padding: 12px;
        margin-bottom: 8px;
        border-radius: 5px;
        border: 1px solid #ffcc80;
    }

    li a {
        color: #ff5722; /* 진한 오렌지 */
        font-weight: bold;
    }

    li p {
        margin: 4px 0;
        color: #9e9e9e;
        font-size: 0.85em;
    }

    .pagination {
        display: flex;
        list-style-type: none;
        padding: 0;
        margin-top: 20px;
        justify-content: center;
    }

    .pagination a, .pagination strong {
        padding: 6px 10px;
        border-radius: 3px;
        border: 1px solid #ff9800;
        margin: 0 3px;
        color: #ff9800;
        background-color: #fff8e1;
        font-size: 0.85em;
    }

    .pagination a:hover {
        background-color: #ffeb3b;
        color: #f57c00;
    }

    .pagination strong {
        background-color: #ff9800;
        color: #222;
        border-color: #ff9800;
    }

    h2 {
        font-size: 1em;
        color: #ff5722;
    }

    /* 모바일 친화적 스타일 조정 */
    @media (max-width: 480px) {
        h1 {
            font-size: 1.5em;
        }
        h2 {
            font-size: 1em;
        }
        .btn {
            margin-top: 10px;
            font-size: 0.8em;
            margin-left: 15px;
        }
        input[type="text"], button[type="submit"] {
            font-size: 0.8em;
        }
        li {
            padding: 10px;
        }
    }

    #hd_section {
        background-color: #f57c00;
        padding: 3px 3px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        width: 100%; /* 헤더 너비 조정 */
    }

    #hd_section a {
        color: #ffeb3b;
        text-decoration: none;
        font-weight: bold;
        margin: 0 10px;
        padding: 8px;
        font-size: 0.9em;
        transition: background-color 0.3s ease;
    }

    #hd_section a:hover {
        background-color: #ff5722;
        border-radius: 3px;
    }

    /* 모바일 메뉴 버튼 스타일 */
    .menu-toggle {
        display: none;
        background-color: transparent;
        border: none;
        font-size: 20px;
        color: #ff9800;
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

    /* 광고 스타일 */
    .ad-container {
        margin: 15px auto;
        max-width: 1350px;
        text-align: center;
        display: flex;
        justify-content: center;
    }

    .ad-iframe {
        width: 100%;
        height: auto;
        border: none;
    }

    /* PC 화면에서 높이 설정 */
    @media (min-width: 768px) {
        .ad-iframe {
            height: 150px;
        }
    }

    /* 모바일 화면에서 높이 설정 */
    @media (max-width: 767px) {
        .ad-iframe {
            height: 100px;
        }
    }
</style>

</head>
<body>
<?php include APPPATH . 'Views/includes/header.php'; ?>
<!-- 검색 폼 -->
<form action="/posts" method="get">
    <input type="hidden" name="category" value="<?= esc($category) ?>">
    <input type="text" name="search" placeholder="검색어를 입력하세요" value="<?= esc($search) ?>">
    <button type="submit">검색</button>
</form>

<h2 class="category-header">
    카테고리: <?= esc($categoryName) ?>
    <?php if ($category != 99 && $category != 9): ?>
        <a class="btn" href="/posts/create?category=<?= esc($category) ?>">글쓰기</a>
    <?php endif; ?>
</h2>

<div class="ad-container">
    <iframe src="https://ads-partners.coupang.com/widgets.html?id=819616&template=carousel&trackingCode=AF8077807&subId=&width=680&height=140&tsource=" 
            class="ad-iframe" 
            frameborder="0" 
            scrolling="no" 
            referrerpolicy="unsafe-url"></iframe>
</div>

<!-- 게시글 목록 -->
<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <a href="/posts/<?= $post['id'] ?>">
                <?= esc($post['title']) ?>
                <span style="font-weight:normal; color: #bbb;">
                    [<?= esc($post['reply_count']) ?>]
                </span>
            </a>
            <p>
                작성자: <?= esc($post['nickname']) ?> | 
                조회수: <?= esc($post['view_count']) ?> | 
                추천: <?= esc($post['likes']) ?> | 
                비추천: <?= esc($post['dislikes']) ?>
            </p>
            <p>작성일 <?= esc($post['created_at']) ?></p>
        </li>
    <?php endforeach; ?>
</ul>

<!-- 페이징 링크 -->
<div class="pagination">
    <?= $pager->links() ?>
</div>
<?php include APPPATH . 'Views/includes/footer.php'; ?>

</html>
