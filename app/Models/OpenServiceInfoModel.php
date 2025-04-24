<?php
namespace App\Models;
use CodeIgniter\Model;

class OpenServiceInfoModel extends Model
{
    protected $table      = 'open_service_info';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'OpenServiceName','OpenServiceID','LocalGovernmentCode','ManagementNumber',
        'LicenseDate','LicenseCancellationDate','BusinessStatusCode','BusinessStatusName',
        'DetailedBusinessStatusCode','DetailedBusinessStatusName','ClosureDate',
        'TemporaryClosureStartDate','TemporaryClosureEndDate','ReopeningDate',
        'PhoneNumber','Area','PostalCode','FullAddress','RoadAddress','RoadPostalCode',
        'BusinessName','LastModifiedTime','DataUpdateType','DataUpdateDate','BusinessTypeName',
        'CoordinateX','CoordinateY','EyeChartCount','LensSampleCount','MeasurementChairCount',
        'PupilDistanceMeterCount','AutoRefractometerCount','LensGrinderCount','LensCutterCount',
        'HeaterCount','EyeglassCleanerCount','TotalArea','CoordinateX(epsg5174)','CoordinateY(epsg5174)'
    ];

        /**
     * 사이트맵 생성용: 전체 안경점 데이터 개수 반환
     *
     * @return int
     */
    public function countAllShops(): int
    {
        return $this->countAllResults();
    }

    /**
     * 사이트맵 생성용: 안경점 목록 페이지네이션 데이터
     *
     * @param int $limit  한 번에 가져올 레코드 수
     * @param int $offset 시작 위치
     * @return array
     */
    public function getShops(int $limit, int $offset): array
    {
        return $this->orderBy($this->primaryKey, 'ASC')
                    ->limit($limit, $offset)
                    ->findAll();
    }
}
