<?php namespace App\Models;

use CodeIgniter\Model;

class HairSalonModel extends Model
{
    protected $table = 'hair_salon'; // 테이블명
    protected $primaryKey = 'id';    // 기본키
    protected $useTimestamps = true; // 타임스탬프 자동 관리
    protected $allowedFields = [
        'open_service_name', 'open_service_id', 'local_government_code', 'management_number',
        'permit_date', 'permit_cancellation_date', 'business_status_code', 'business_status_name',
        'detailed_business_status_code', 'detailed_business_status_name', 'closure_date',
        'temporary_closure_start_date', 'temporary_closure_end_date', 'reopening_date',
        'contact_phone_number', 'location_area', 'postal_code', 'full_address', 'road_name_address',
        'road_name_postal_code', 'business_name', 'last_modification_time', 'data_update_type',
        'data_update_date', 'business_type_name', 'x_coordinate', 'y_coordinate', 'hygiene_business_type',
        'building_upper_floors', 'building_lower_floors', 'used_start_upper_floor', 'used_end_upper_floor',
        'used_start_lower_floor', 'used_end_lower_floor', 'chair_count', 'conditional_permission_reason',
        'conditional_permission_start_date', 'conditional_permission_end_date', 'building_ownership_type',
        'female_staff_count', 'male_staff_count', 'bed_count', 'multi_use_business'
    ];
    
    // 유효성 검사 규칙 (필요한 경우 추가할 수 있음)
    protected $validationRules = [
        'open_service_name' => 'required|min_length[3]|max_length[255]',
        'open_service_id' => 'required|min_length[3]|max_length[255]',
        // 추가적인 유효성 검사 규칙
    ];
}
