<?php
namespace App\Controllers;

use App\Models\SportsFacilityModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class SportsFacility extends Controller
{
    public function index()
    {
        $model = new SportsFacilityModel();
        // 최신 12개
        $data['facilities'] = $model
            ->orderBy('id', 'DESC')
            ->findAll(12);
        return view('sports_facilities/index', $data);
    }

    public function detail($id = null)
    {
        $model = new SportsFacilityModel();
        $data['facility'] = $model->find($id);

        if (!$data['facility']) {
            throw new PageNotFoundException("존재하지 않는 체육시설입니다: {$id}");
        }

        return view('sports_facilities/detail', $data);
    }
}
