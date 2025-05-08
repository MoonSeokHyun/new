<?php

namespace App\Controllers;

use App\Models\AnimalHospitalModel;

class AnimalHospitalController extends BaseController
{
    public function index()
    {
        $model = new AnimalHospitalModel();
        $data['hospitals'] = $model->getHospitals(12); // 12개 항목만 가져오기

        return view('animal_hospital/index', $data);
    }

    public function detail($id)
    {
        $model = new AnimalHospitalModel();
        $data['hospital'] = $model->getHospitalDetails($id);

        return view('animal_hospital/detail', $data);
    }
}
