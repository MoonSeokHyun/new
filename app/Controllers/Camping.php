<?php
namespace App\Controllers;

use App\Models\CampingModel;

class Camping extends BaseController
{
    public function index()
    {
        $model = new CampingModel();
        // 최신 12개 레코드만 조회
        $data['campings'] = $model->orderBy('id', 'DESC')->findAll(12);
        return view('camping/index', $data);
    }
    

    public function detail($id = null)
    {
        $model = new CampingModel();
        $data['camping'] = $model->find($id);
        if (!$data['camping']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find camping with id '. $id);
        }
        return view('camping/detail', $data);
    }
}
