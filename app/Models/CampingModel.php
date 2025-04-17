<?php
namespace App\Models;

use CodeIgniter\Model;

class CampingModel extends Model
{
    protected $table      = 'facility';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'FCLTY_NM','CTGRY_ONE_NM','CTGRY_TWO_NM','CTGRY_THREE_NM',
        'CTPRVN_NM','SIGNGU_NM','LEGALDONG_NM','LI_NM','LNBR_NO',
        'ROAD_NM','BULD_NO','LC_LA','LC_LO','ZIP_NO',
        'RDNMADR_NM','LNM_ADDR','TEL_NO','HMPG_URL','MANAGE_MBY_NM',
        'WORKDAY_OPER_AT','WKEND_OPER_AT','SPR_OPER_AT','SUMR_OPER_AT',
        'FALL_OPER_AT','WNT_OPER_AT','ELECT_PROVD_AT','HWATER_PROVD_AT',
        'WIFI_HOLD_AT','FWOOD_SLE_AT','WLK_ROAD_AT','WATERPARK_HOLD_AT',
        'PLY_FCLTY_HOLD_AT','MART_HOLD_AT','TOILET_CO','SHWERRM_CO',
        'SINK_CO','FETGS_CO','CFR_FSHNG_FCLTY_AT','CFR_WLK_ROAD_FCLTY_AT',
        'CFR_BEACH_FCLTY_AT','CFR_PRIZE_LSR_FCLTY_AT','CFR_VALL_FCLTY_AT',
        'CFR_RIVER_FCLTY_AT','CFR_POOL_FCLTY_AT','CFR_YNGBGS_EXPRN_FCLTY_AT',
        'CFR_FAFV_EXPRN_FCLTY_AT','CFR_CHILD_PLY_FCLTY_AT','GLAMPING_BED_HOLD_AT',
        'GLAMPING_TV_HOLD_AT','GLAMPING_FRIDGE_HOLD_AT','GLAMPING_WIFI_HOLD_AT',
        'GLAMPING_IN_TOILET_HOLD_AT','GLAMPING_AC_HOLD_AT','GLAMPING_HEATER_HOLD_AT',
        'GLAMPING_CKNG_TOOL_HOLD_AT','ETC_FCLTY_DC','FCLTY_INTRCN_CN','LAST_UPDT_DE'
    ];

    /**
     * 사이트맵 생성용: 전체 캠핑장 데이터 개수 반환
     *
     * @return int
     */
    public function countAllCampings(): int
    {
        // countAllResults()는 현재 쿼리 조건에 맞는 전체 row 수를 반환합니다.
        return $this->countAllResults();
    }

    /**
     * 사이트맵 생성용: 페이지네이션에 사용할 캠핑장 목록
     *
     * @param int $limit  한 번에 가져올 레코드 수
     * @param int $offset 시작 위치
     * @return array
     */
    public function getCampings(int $limit, int $offset): array
    {
        return $this->table($this->table)
                    ->orderBy($this->primaryKey, 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }
}
