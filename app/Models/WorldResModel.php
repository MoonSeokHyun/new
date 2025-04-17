<?php
namespace App\Models;

use CodeIgniter\Model;

class WorldResModel extends Model
{
    protected $table      = 'restaurants';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'FCLTY_NM','CTGRY_ONE_NM','CTGRY_TWO_NM','CTGRY_THREE_NM',
        'CTPRVN_NM','SIGNGU_NM','LEGALDONG_NM','LI_NM','LNBR_NO',
        'ROAD_NM','BULD_NO','LC_LA','LC_LO','ZIP_NO',
        'RDNMADR_NM','LNM_ADDR','TEL_NO','WORKDAY_OPER_TIME_DC',
        'WKEND_OPER_TIME_DC','FRE_PARKNG_AT','VALET_PARKNG_POSBL_AT',
        'INFN_CHAIR_LEND_POSBL_AT','WCHAIR_HOLD_AT','PET_POSBL_AT',
        'VGTR_MENU_HOLD_AT','HALAL_FOOD_HOLD_AT','GFRE_FOOD_HOLD_AT',
        'LAST_UPDT_DE'
    ];

    /**
     * 사이트맵 생성용: 전체 음식점 데이터 개수 반환
     *
     * @return int
     */
    public function countAllRestaurants(): int
    {
        return $this->countAllResults();
    }

    /**
     * 사이트맵 생성용: 페이지네이션에 사용할 음식점 목록
     *
     * @param int $limit  한 번에 가져올 레코드 수
     * @param int $offset 시작 위치
     * @return array
     */
    public function getRestaurants(int $limit, int $offset): array
    {
        return $this->table($this->table)
                    ->orderBy($this->primaryKey, 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }
}
