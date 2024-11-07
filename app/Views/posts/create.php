<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>새 글 작성 - 카테고리 <?= esc($category) ?></title>
    <!-- TinyMCE 오픈 소스 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'image link media table code',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image link',
            menubar: false,
            content_style: "body { color: #ddd; background-color: #333; }"
        });

        function validateForm() {
            var content = tinymce.get("content").getContent();
            if (content.trim() === "") {
                alert("내용을 입력해주세요.");
                return false;
            }
            return true;
        }
    </script>
    <style>
        /* 기본 스타일 */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: '돋움', Arial, sans-serif;
            background-color: #222;
            color: #ddd;
            padding: 20px;
            margin: 0;
        }
        @media (min-width: 768px) {
    body {
        max-width: 1350px;
        margin: 0 auto; /* 가운데 정렬 */
    }
}

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

        h1 {
            color: #ddd;
            font-size: 1.5em;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #aaa;
            font-size: 0.9em;
        }

        input[type="text"],
        input[type="password"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #333;
            color: #ddd;
            border: 1px solid #555;
            border-radius: 3px;
            box-sizing: border-box;
            font-size: 0.9em;
        }

        button {
            background-color: #00d8ff;
            color: #222;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.9em;
            width: 100%;
            max-width: 200px;
            margin: 10px auto;
            display: block;
        }

        button:hover {
            background-color: #00b0d4;
        }

        /* TinyMCE 스타일 */
        .tox-tinymce {
            border-radius: 3px;
            background-color: #333;
        }
        .tox .tox-toolbar, .tox .tox-toolbar__primary {
            background-color: #444;
            border-bottom: 1px solid #555;
        }
        .tox .tox-toolbar__group {
            padding: 5px;
        }
        .tox .tox-button {
            color: #ddd;
        }
        .tox .tox-editor-header, .tox .tox-statusbar {
            background-color: #333;
            color: #bbb;
        }

        /* 모바일 친화적인 스타일 */
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            h1 {
                font-size: 1.2em;
            }
            label {
                font-size: 0.8em;
            }
            input[type="text"],
            input[type="password"],
            input[type="file"],
            textarea {
                font-size: 0.8em;
                padding: 8px;
            }
            button {
                font-size: 0.8em;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
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

<form action="/posts" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
    <input type="hidden" name="category" value="<?= esc($category) ?>"> <!-- 카테고리 자동 입력 -->
    
    <label>닉네임:</label>
    <input type="text" name="nickname" required>

    <label>제목:</label>
    <input type="text" name="title" required>

    <label>내용:</label>
    <textarea id="content" name="content"></textarea>

    <label>비밀번호:</label>
    <input type="password" name="password" required>

    <label>이미지 업로드:</label>
    <input type="file" name="image1">
    <input type="file" name="image2">
    <input type="file" name="image3">
    <input type="file" name="image4">
    <input type="file" name="image5">

    <button type="submit">작성</button>
</form>

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
