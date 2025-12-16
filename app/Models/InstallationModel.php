<?php

namespace App\Models;

use CodeIgniter\Model;

class InstallationModel extends Model
{
    protected $table = 'installation_data';
    protected $primaryKey = 'id';
    protected $returnType = 'array'; // 배열로 반환
    protected $allowedFields = [
        'Installation Location Name', 'Province Name', 'District Name',
        'Street Address', 'Land Lot Address', 'Latitude', 'Longitude',
        'Detailed Location', 'Managing Institution Name',
        'Managing Institution Phone Number', 'Data Reference Date',
        'Provider Institution Code', 'Provider Institution Name'
    ];
    protected $useTimestamps = false;

    // 전체 설치장소 개수를 반환하는 메소드
    public function countAllInstallations()
    {
        return $this->countAllResults();  // 전체 설치장소 데이터 개수 반환
    }

    // 설치장소 목록을 limit과 offset을 이용해 가져오는 메소드
    public function getInstallations($limit, $offset)
    {
        return $this->table($this->table)
                    ->limit($limit, $offset)  // limit과 offset을 사용해 데이터 가져오기
                    ->findAll();  // 설치장소 데이터를 반환
    }

    public function search($query)
    {
        // Use backticks to escape columns with spaces
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);

        // Adding LIKE condition - CodeIgniter automatically escapes column names
        $builder->groupStart()
            ->like('Installation Location Name', $query)
            ->orLike('Street Address', $query)
            ->orLike('Land Lot Address', $query)
            ->orLike('District Name', $query)
            ->orLike('Managing Institution Name', $query)
        ->groupEnd();

        // Run query and return results as array
        $queryResult = $builder->get();
        $results = $queryResult->getResultArray();

        // Convert objects to arrays if needed
        if (!empty($results) && is_object($results[0])) {
            $results = array_map(function($item) {
                return is_object($item) ? (array)$item : $item;
            }, $results);
        }

        return $results;
    }
}
