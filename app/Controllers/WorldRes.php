<?php
namespace App\Controllers;

use App\Models\WorldResModel;

class WorldRes extends BaseController
{
    public function index()
    {
        $model = new WorldResModel();
        // 최신 12개 레코드만 조회
        $data['restaurants'] = $model
            ->orderBy('id', 'DESC')  // 최신순으로 가져오려면, 필요 없으면 제거하세요
            ->findAll(12);
        return view('world_res/index', $data);
    }
    
    public function detail($id = null)
    {
        $model = new WorldResModel();
        $data['restaurant'] = $model->find($id);
        if (!$data['restaurant']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find restaurant with id '. $id);
        }
        return view('world_res/detail', $data);
    }
}
