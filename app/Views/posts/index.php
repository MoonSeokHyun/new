<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시글 목록</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        
        h1 {
            color: #333;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: calc(100% - 130px);
            margin-right: 10px;
        }

        button[type="submit"] {
            padding: 10px 15px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background: white;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>게시글 목록</h1>

    <!-- 글쓰기 버튼 -->
    <a class="btn" href="/posts/create?category=<?= esc($category) ?>">글쓰기</a>

    <!-- 검색 폼 -->
    <form action="/posts" method="get">
        <input type="hidden" name="category" value="<?= esc($category) ?>">
        <input type="text" name="search" placeholder="검색어를 입력하세요" value="<?= esc($search) ?>">
        <button type="submit">검색</button>
    </form>

    <h2>카테고리: <?= esc($categoryName) ?></h2>

    <!-- 게시글 목록 -->
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <a href="/posts/<?= $post['id'] ?>">
                    <?= esc($post['title']) ?> (작성자: <?= esc($post['nickname']) ?>)
                </a>
                <p>조회수: <?= esc($post['view_count']) ?> | 추천: <?= esc($post['likes']) ?> | 비추천: <?= esc($post['dislikes']) ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
