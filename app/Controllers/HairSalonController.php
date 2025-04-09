<?php namespace App\Controllers;

use App\Models\HairSalonModel;
use CodeIgniter\Controller;

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
                            ->paginate(10, 'salons'); // 10개씩 표시
        } else {
            // 검색어가 없으면 전체 목록에서 페이징 처리
            $salons = $model->paginate(10, 'salons'); // 10개씩 표시
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

        return view('hair/hairsalon_detail', $data);
    }
}
