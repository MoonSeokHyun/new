<?php

namespace App\Models;

use CodeIgniter\Model;

class ClothingCollectionBinModel extends Model
{
    protected $table = 'clothing_collection_bins';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'Province Name', 'Clothing Collection Bin Location Name', 'District Name',
        'Street Address', 'Land Lot Address', 'Latitude', 'Longitude',
        'Detailed Location', 'Managing Institution Name', 
        'Managing Institution Phone Number', 'Data Reference Date',
        'Provider Institution Code', 'Provider Institution Name'
    ];
    protected $useTimestamps = false;

    // 검색 기능
    public function search($query)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->like('`Clothing Collection Bin Location Name`', $query);
        $builder->orLike('`Street Address`', $query);
        $queryResult = $builder->get();
        return $queryResult->getResult();
    }

    // 모든 데이터 가져오기 (인덱스 페이지)
    public function getAllBins($limit = 10, $offset = 0)
    {
        return $this->findAll($limit, $offset);
    }

    // 데이터 카운트 (페이징을 위한 카운트)
    public function countAllBins()
    {
        return $this->countAllResults();
    }
}
