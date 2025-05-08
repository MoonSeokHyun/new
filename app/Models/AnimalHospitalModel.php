<?php

namespace App\Models;

use CodeIgniter\Model;

class AnimalHospitalModel extends Model
{
    protected $table      = 'animal_hospital';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'x_value', 'y_value', 'new_address', 'old_address',
        'b_num', 'b_name', 'b_status', 'old_full_address', 'new_full_address'
    ];

    // 12개만 가져오는 메서드
    public function getHospitals($limit = 12)
    {
        return $this->orderBy('id', 'ASC')
                    ->findAll($limit);  // 12개 항목만 가져오기
    }

    public function getHospitalDetails($id)
    {
        return $this->find($id);
    }

    /**
     * 사이트맵 생성용: 전체 동물병원 데이터 개수 반환
     *
     * @return int
     */
    public function countAllHospitals(): int
    {
        // countAllResults()는 현재 쿼리 조건에 맞는 전체 row 수를 반환합니다.
        return $this->countAllResults();
    }

    /**
     * 사이트맵 생성용: 페이지네이션에 사용할 동물병원 목록
     *
     * @param int $limit  한 번에 가져올 레코드 수
     * @param int $offset 시작 위치
     * @return array
     */
    public function getHospitalsPagination(int $limit, int $offset): array
    {
        return $this->table($this->table)
                    ->orderBy($this->primaryKey, 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }
}
