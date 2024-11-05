<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>새 글 작성 - 카테고리 <?= esc($category) ?></title>
    <!-- TinyMCE 오픈 소스 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#content',  // id="content"인 textarea에 적용
            plugins: 'image link media table code',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image link',
            menubar: false
        });

        function validateForm() {
            // TinyMCE의 내용이 비어있는지 확인
            var content = tinymce.get("content").getContent();
            if (content.trim() === "") {
                alert("내용을 입력해주세요.");
                return false;
            }
            return true;
        }
    </script>
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

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="password"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* TinyMCE 스타일 */
        .tox-tinymce {
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>새 글 작성 - 카테고리 <?= esc($category) ?></h1>
    <form action="/posts" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <input type="hidden" name="category" value="<?= esc($category) ?>"> <!-- 카테고리 자동 입력 -->
        
        <label>닉네임:</label>
        <input type="text" name="nickname" required>

        <label>제목:</label>
        <input type="text" name="title" required>

        <label>내용:</label>
        <textarea id="content" name="content"></textarea> <!-- required 속성 제거 -->

        <label>비밀번호:</label>
        <input type="password" name="password" required>

        <label>이미지:</label>
        <input type="file" name="image1">
        <input type="file" name="image2">
        <input type="file" name="image3">
        <input type="file" name="image4">
        <input type="file" name="image5">

        <button type="submit">작성</button>
    </form>
</body>
</html>
