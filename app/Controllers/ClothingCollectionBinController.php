<?php

namespace App\Controllers;

use App\Models\ClothingCollectionBinModel;
use CodeIgniter\Controller;

class ClothingCollectionBinController extends Controller
{
    // 인덱스 페이지
    public function index()
    {
        $model = new ClothingCollectionBinModel();

        // 검색 기능 (선택적)
        $query = $this->request->getVar('search');
        
        // 검색 시, 해당 query로 데이터 검색
        if ($query) {
            $bins = $model->search($query); // search 메서드를 통해 데이터 검색
        } else {
            // 페이징 처리
            $page = $this->request->getVar('page') ?? 1; // 현재 페이지
            $perPage = 12; // 한 페이지에 표시할 항목 수
            $offset = ($page - 1) * $perPage; // 페이지에 맞는 offset 계산

            // 해당 페이지에 맞는 수거함 데이터 가져오기
            $bins = $model->getAllBins($perPage, $offset);
        }

        // 전체 데이터 개수 (페이징을 위해)
        $totalBins = $model->countAllBins();
        
        // Pager 설정
        $pager = \Config\Services::pager();

        // 인덱스 페이지에 필요한 데이터 뷰로 전달
        return view('clothing_collection_bin/index', [
            'bins' => $bins,    // 수거함 목록
            'pager' => $pager,  // 페이징
            'totalBins' => $totalBins,  // 전체 데이터 개수
            'search' => $query, // 검색어 전달
        ]);
    }

    // 디테일 페이지
    public function show($id)
    {
        $model = new ClothingCollectionBinModel();
        
        // ID로 해당 수거함 데이터를 찾기
        $bin = $model->find($id);

        // 수거함이 없다면 404 에러 발생
        if (!$bin) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Collection Bin with ID $id not found");
        }

        // 해당 수거함 디테일 페이지를 보여줌
        return view('clothing_collection_bin/detail', ['bin' => $bin]);
    }
}
