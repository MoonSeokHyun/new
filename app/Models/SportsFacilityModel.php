<?php
namespace App\Models;

use CodeIgniter\Model;

class SportsFacilityModel extends Model
{
    protected $table      = 'sports_facilities';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'FCLTY_NM','FCLTY_SDIV_CD','FCLTY_FLAG_NM','INDUTY_CD','INDUTY_NM',
        'FCLTY_TY_CD','FCLTY_TY_NM','POSESN_MBY_CD','POSESN_MBY_NM',
        'POSESN_MBY_CTPRVN_CD','POSESN_MBY_CTPRVN_NM','POSESN_MBY_SIGNGU_CD',
        'POSESN_MBY_SIGNGU_NM','RSPNSBLTY_DEPT_NM','RSPNSBLTY_TEL_NO',
        'ROAD_NM_CTPRVN_CD','ROAD_NM_CTPRVN_NM','ROAD_NM_SIGNGU_CD',
        'ROAD_NM_SIGNGU_NM','ROAD_NM_EMD_CD','ROAD_NM_EMD_NM','ROAD_NM_LI_CD',
        'ROAD_NM_LI_NM','RDNMADR_NM','FCLTY_LO','FCLTY_LA','FCLTY_AR_CO',
        'ACMD_NMPR_CO','ADTM_CO','FCLTY_HMPG_URL','NATION_ALSFC_AT',
        'FCLTY_STATE_CD','DEL_AT'
    ];

    /**
     * 사이트맵 생성용: 전체 체육시설 데이터 개수 반환
     *
     * @return int
     */
    public function countAllFacilities(): int
    {
        return $this->countAllResults();
    }

    /**
     * 사이트맵 생성용: 체육시설 목록 페이지네이션 데이터
     *
     * @param int $limit  한 번에 가져올 레코드 수
     * @param int $offset 시작 위치
     * @return array
     */
    public function getFacilities(int $limit, int $offset): array
    {
        return $this->table($this->table)
                    ->orderBy($this->primaryKey, 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }
}
