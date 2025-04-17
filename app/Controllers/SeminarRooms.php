<?php 
namespace App\Controllers;

use App\Models\SeminarRoomModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class SeminarRooms extends BaseController
{
    public function index()
    {
        $model = new SeminarRoomModel();
        // 최신 12개만 가져오기
        $data['rooms'] = $model
            ->orderBy('id', 'ASC')
            ->findAll(12);  // ← limit 12
    
        return view('SeminarRooms/index', $data);
    }
    

    public function detail($id = null)
    {
        $model = new SeminarRoomModel();
        $room = $model->find($id);

        if (! $room) {
            throw PageNotFoundException::forPageNotFound("Seminar room not found: $id");
        }

        $data['room'] = $room;
        return view('SeminarRooms/detail', $data);
    }
}
