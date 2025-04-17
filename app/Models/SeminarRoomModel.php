<?php 
namespace App\Models;

use CodeIgniter\Model;

class SeminarRoomModel extends Model {
    protected $table      = 'seminar_rooms';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'FCLTY_NM','CTPRVN_NM','SIGNGU_NM','EMD_NM','LI_NM','LNBR_NO','ROAD_NM','BULD_NO',
        'LC_LA','LC_LO','ZIP_NO','RDNMADR_NM','LNM_ADDR','FCLTY_TY_NM',
        'MON_OPER_TIME','TUES_OPER_TIME','WED_OPER_TIME','THUR_OPER_TIME','FRI_OPER_TIME','SAT_OPER_TIME','SUN_OPER_TIME',
        'ADO_FCLTY_HOLD_AT','ADIT_CHAIR_HOLD_AT','PRINTER_HOLD_AT','TV_HOLD_AT','DOORLOCK_AT',
        'PARKNG_POSBL_AT','INTNT_HOLD_AT','KITCHEN_HOLD_AT','MIC_HOLD_AT','DESK_HOLD_AT',
        'PRJT_HOLD_AT','WIFI_HOLD_AT','WBOARD_HOLD_AT','PC_HOLD_AT','LAPTOP_HOLD_AT','LAST_UPDT_DE'
    ];

    /**
     * 사이트맵 생성용: 전체 세미나룸(미용실) 데이터 개수 반환
     *
     * @return int
     */
    public function countAllSalons()
    {
        // countAllResults()는 쿼리 결과의 전체 row 수를 반환합니다.
        return $this->countAllResults();
    }

    /**
     * 사이트맵 생성용: 페이지네이션에 사용할 세미나룸(미용실) 목록
     *
     * @param int $limit  한 번에 가져올 레코드 수
     * @param int $offset 시작 위치
     * @return object[]|array
     */
    public function getHairSalons(int $limit, int $offset)
    {
        return $this->table($this->table)
                    ->limit($limit, $offset)
                    ->findAll();
    }
}
