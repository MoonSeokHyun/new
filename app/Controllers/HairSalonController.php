<?php namespace App\Controllers;

use App\Models\HairSalonModel;
use CodeIgniter\Controller;
use proj4php\Proj4php;
use proj4php\Point;
use proj4php\Proj;

class HairSalonController extends Controller
{
    public function index()
    {
        $model = new HairSalonModel();

        // 검색어 처리
        $search = $this->request->getVar('search');

        // 기본 페이지 번호 (페이징 처리)
        $page = $this->request->getVar('page') ?: 1;

        // 검색어가 있을 경우 쿼리 수정
        if ($search) {
            $salons = $model->like('open_service_name', $search)
                            ->orLike('business_name', $search)
                            ->paginate(12, 'salons'); // 12개씩 표시
        } else {
            // 검색어가 없으면 전체 목록에서 페이징 처리
            $salons = $model->paginate(12, 'salons'); // 12개씩 표시
        }

        // 페이지 네비게이션 데이터
        $data = [
            'salons' => $salons,
            'pager' => $model->pager,
            'search' => $search
        ];

        return view('hair/hairsalon_list', $data); // 미용실 목록 페이지를 보여줍니다
    }

    public function detail($id)
    {
        $model = new HairSalonModel();
        $data['salon'] = $model->find($id);

        if (!$data['salon']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('미용실을 찾을 수 없습니다.');
        }

        // 좌표 변환 (UTM -> 위도, 경도)
        $utm_x = $data['salon']['x_coordinate']; // UTM X 좌표
        $utm_y = $data['salon']['y_coordinate']; // UTM Y 좌표

        // Proj4php 객체 생성
        $proj4php = new Proj4php();

        // UTM 좌표계 정의 (예: EPSG:32652, UTM Zone 52N)
        // 예시: 서울이나 전라남도 순천시의 경우 EPSG:32652
        $utm = new Proj('EPSG:32652', $proj4php); // 서울/순천 UTM Zone (EPSG:32652)
        $wgs84 = new Proj('EPSG:4326', $proj4php); // WGS84

        // UTM 좌표를 Point로 생성
        $utmPoint = new Point($utm_x, $utm_y, $utm);

        // 변환을 위해 Point 객체를 직접 변환
        $wgs84Point = $proj4php->transform($utm, $wgs84, $utmPoint); // Proj4php 객체를 통해 좌표 변환

        // 변환된 위도, 경도 값을 배열로 전달
        $data['latitude'] = $wgs84Point->y;
        $data['longitude'] = $wgs84Point->x;

        return view('hair/hairsalon_detail', $data);
    }
}
