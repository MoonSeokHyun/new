<?php
namespace App\Controllers;
use App\Models\OpenServiceInfoModel;
use CodeIgniter\Controller;

class OpenServiceInfoController extends Controller
{
    public function index()
    {
        $model = new OpenServiceInfoModel();
        $data['shops'] = $model->findAll(12);
        return view('open_service_info/index', $data);
    }

    public function detail($id = null)
    {
        $model = new OpenServiceInfoModel();
        $data['shop'] = $model->find($id);

        if (empty($data['shop'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find shop with id ' . $id);
        }

        return view('open_service_info/detail', $data);
    }
}
