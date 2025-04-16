<?php

namespace App\Controllers;

use App\Models\InstallationModel;

class InstallationController extends BaseController
{
    public function index()
    {
        $model = new InstallationModel();
        
        // Get search query from URL
        $query = $this->request->getVar('search');
        
        // Pagination
        $pager = \Config\Services::pager();
        $perPage = 12;

        // If search query exists, filter by Name or Address
        if ($query) {
            // Perform search using model's search function
            $installations = $model->search($query);
        } else {
            // If no search query, fetch all installations
            $installations = $model->paginate($perPage);
        }

        // Prepare data to send to the view
        $data = [
            'installations' => $installations,
            'pager' => $model->pager,
            'search' => $query
        ];

        // Return the view with data
        return view('installation/index', $data);
    }

    public function show($id)
    {
        $model = new InstallationModel();
        $data['installation'] = $model->find($id);
        
        if (empty($data['installation'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Cannot find the installation data.");
        }
        
        return view('installation/detail', $data);
    }
}
