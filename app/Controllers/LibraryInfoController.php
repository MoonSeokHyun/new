<?php

namespace App\Controllers;

use App\Models\LibraryInfoModel;

class LibraryInfoController extends BaseController
{
    public function index()
    {
        $model = new LibraryInfoModel();
        $data['libraries'] = $model->findAll(12); // 최대 12개만 가져옴
        return view('LibraryInfo/index', $data);
    }

    public function detail($id)
    {
        $model = new LibraryInfoModel();
        $data['library'] = $model->find($id);
        return view('LibraryInfo/detail', $data);
    }
}
