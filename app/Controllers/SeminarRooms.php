<?php 
namespace App\Controllers;

use App\Models\SeminarRoomModel;
use App\Traits\NaverGeocodeTrait;
use CodeIgniter\Exceptions\PageNotFoundException;

class SeminarRooms extends BaseController
{
    use NaverGeocodeTrait;

    public function index()
    {
        $model = new SeminarRoomModel();
        // 최신 12개만 가져오기
        $data['rooms'] = $model
            ->orderBy('id', 'ASC')
            ->findAll(12);  // ← limit 12
    
        return view('SeminarRooms/index', $data);
    }
    

    public function detail($id = null)
    {
        $model = new SeminarRoomModel();
        $room = $model->find($id);

        if (! $room) {
            throw PageNotFoundException::forPageNotFound("Seminar room not found: $id");
        }

        // ✅ 객체를 배열로 변환 (필요한 경우)
        if (is_object($room)) {
            $room = (array)$room;
        }

        // ✅ 주소 우선순위: 도로명 -> 지번
        $road = trim((string)($room['RDNMADR_NM'] ?? ''));
        $lot = trim((string)($room['LNM_ADDR'] ?? ''));
        $address = $road !== '' ? $road : $lot;

        $dbLat = isset($room['LC_LA']) ? (float) $room['LC_LA'] : null;
        $dbLng = isset($room['LC_LO']) ? (float) $room['LC_LO'] : null;
        $coords = $this->latLngFromDbOrGeocode($address, $dbLat, $dbLng);
        if (($coords['lat'] === null || $coords['lng'] === null) && $lot !== '' && $lot !== $road) {
            $coords = $this->latLngFromDbOrGeocode($lot, null, null);
        }
        $lat = $coords['lat'];
        $lng = $coords['lng'];

        // ✅ 근처 세미나룸
        $district = null;
        if ($address !== '') {
            preg_match('/([가-힣]+구|[가-힣]+읍|[가-힣]+면)/u', $address, $m);
            $district = $m[0] ?? null;
        }

        $nearby = [];
        if ($district) {
            $nearby = $model
                ->groupStart()
                    ->like('RDNMADR_NM', $district)
                    ->orLike('LNM_ADDR', $district)
                ->groupEnd()
                ->where('id !=', $id)
                ->limit(6)
                ->findAll();

            foreach ($nearby as &$n) {
                // 객체를 배열로 변환
                if (is_object($n)) {
                    $n = (array)$n;
                }
                $n['url'] = site_url('seminar-rooms/detail/' . ($n['id'] ?? ''));
            }
            unset($n);
        }

        $blogPosts = $this->naverBlogSearch(is_array($room) ? ($room['FCLTY_NM'] ?? '') : ($room->FCLTY_NM ?? ''));

        return view('SeminarRooms/detail', [
            'room' => $room,
            'latitude' => $lat,
            'longitude' => $lng,
            'nearby_rooms' => $nearby,
            'district' => $district,
            'blog_posts' => $blogPosts,
        ]);
    }
}
