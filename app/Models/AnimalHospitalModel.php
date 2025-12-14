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

    public function getHospitalDetails($id)
    {
        return $this->find($id);
    }

    public function countAllHospitals(): int
    {
        return $this->countAllResults();
    }

    public function getHospitalsPagination(int $limit, int $offset): array
    {
        return $this->table($this->table)
            ->orderBy($this->primaryKey, 'ASC')
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }
}
