<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($salon['open_service_name']) ?> - 미용실 정보</title>
    <style>
        /* 기본 스타일 */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #fce0e0; /* 부드러운 핑크색 배경 */
            color: #333;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 40px;
            color: #d44f8c; /* 핑크 톤 색상 */
            margin-bottom: 10px;
        }

        .sub-heading {
            font-size: 24px;
            color: #777;
            margin-bottom: 30px;
        }

        /* "메인으로 돌아가기" 버튼 */
        .main-button {
            padding: 10px 25px;
            font-size: 16px;
            background-color: #d44f8c;
            color: white;
            border-radius: 30px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 20px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .main-button:hover {
            background-color: #c13e72;
        }

        /* 상세 정보 스타일 */
        .details p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .details strong {
            color: #d44f8c;
        }

        /* 상세 정보 카드 스타일 */
        .card {
            background-color: #fce0e0;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* 페이징 스타일 */
        .pagination {
            margin-top: 30px;
            text-align: center;
            display: flex;
            justify-content: center;
        }

        .pagination a {
            padding: 10px 15px;
            background-color: #d44f8c;
            color: white;
            border-radius: 5px;
            margin: 0 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .pagination a:hover {
            background-color: #c13e72;
        }

        .pagination .active {
            background-color: #ffb3b3;
        }

        footer {
            background-color: #d44f8c;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            font-size: 14px;
        }

        footer a {
            color: #f9e6e6;
            text-decoration: none;
            font-weight: bold;
        }

        /* 모바일 최적화 */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .main-button {
                font-size: 14px;
                width: 100%;
            }

            .grid {
                grid-template-columns: repeat(2, 1fr); /* 2개씩 그리드로 변경 */
            }

            .pagination a {
                font-size: 14px;
                padding: 8px 12px;
            }

            .icon-card {
                height: auto; /* 모바일에서는 카드 높이 자동 조정 */
                padding: 15px;
            }

            .search-box input {
                width: 100%; /* 모바일에서는 입력창을 가득 채우도록 */
            }
        }

        @media (max-width: 480px) {
            .grid {
                grid-template-columns: 1fr; /* 1개씩 그리드로 변경 */
            }

            .pagination a {
                font-size: 12px;
                padding: 6px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><?= esc($salon['open_service_name']) ?> - 미용실 상세 정보</h1>
            <p class="sub-heading"><?= esc($salon['business_name']) ?></p>
        </header>

        <!-- "메인으로 돌아가기" 버튼 -->
        <a href="/" class="main-button">메인으로 돌아가기</a>

        <div class="details">
            <div class="card">
                <p><strong>미용실 ID:</strong> <?= esc($salon['open_service_id']) ?></p>
                <p><strong>전화번호:</strong> <?= esc($salon['contact_phone_number']) ?></p>
                <p><strong>주소:</strong> <?= esc($salon['full_address']) ?></p>
                <p><strong>도로명 주소:</strong> <?= esc($salon['road_name_address']) ?></p>
                <p><strong>사업장 면적:</strong> <?= esc($salon['location_area']) ?> m²</p>
                <p><strong>영업 상태:</strong> <?= esc($salon['business_status_name']) ?></p>
                <p><strong>상세 영업 상태:</strong> <?= esc($salon['detailed_business_status_name']) ?></p>
                <p><strong>폐업일자:</strong> <?= esc($salon['closure_date']) ?></p>
                <p><strong>영업 시작일자:</strong> <?= esc($salon['permit_date']) ?></p>
                <p><strong>재개업일자:</strong> <?= esc($salon['reopening_date']) ?></p>
                <p><strong>최종 수정 시점:</strong> <?= esc($salon['last_modification_time']) ?></p>
                <p><strong>업종명:</strong> <?= esc($salon['business_type_name']) ?></p>
                <p><strong>위생업태명:</strong> <?= esc($salon['hygiene_business_type']) ?></p>
                <p><strong>건물 지상층수:</strong> <?= esc($salon['building_upper_floors']) ?>층</p>
                <p><strong>건물 지하층수:</strong> <?= esc($salon['building_lower_floors']) ?>층</p>
                <p><strong>의자 수:</strong> <?= esc($salon['chair_count']) ?></p>
                <p><strong>침대 수:</strong> <?= esc($salon['bed_count']) ?></p>
                <p><strong>여성 종사자 수:</strong> <?= esc($salon['female_staff_count']) ?></p>
                <p><strong>남성 종사자 수:</strong> <?= esc($salon['male_staff_count']) ?></p>
                <p><strong>다중이용업소 여부:</strong> <?= esc($salon['multi_use_business']) ?></p>
            </div>
        </div>

        <!-- "목록으로 돌아가기" 버튼 -->
        <a href="/hairsalon" class="main-button">목록으로 돌아가기</a>
    </div>

    <footer>
        <p>이 데이터는 공공데이터 <a href="https://www.data.go.kr" target="_blank">www.data.go.kr</a>을 활용하여 만든 웹사이트입니다. 사용 방법 혹은 정보 변경 요청은 <a href="mailto:gjqmaoslwj@naver.com">gjqmaoslwj@naver.com</a>으로 연락 주시기 바랍니다.</p>
    </footer>
</body>
</html>
