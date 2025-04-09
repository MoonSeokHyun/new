<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($salon['open_service_name']) ?> - 미용실 정보</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9e6e6;
            color: #333;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 36px;
            color: #5a8f9e;
        }

        .details p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #5a8f9e;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #4a7f89;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1><?= esc($salon['open_service_name']) ?> - 미용실 상세 정보</h1>

        <div class="details">
            <p><strong>미용실 ID:</strong> <?= esc($salon['open_service_id']) ?></p>
            <p><strong>사업자명:</strong> <?= esc($salon['business_name']) ?></p>
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

        <a href="/hairsalon" class="back-button">목록으로 돌아가기</a>
    </div>
</body>
</html>
