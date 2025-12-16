<?php 
namespace App\Controllers;

use App\Models\SeminarRoomModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class SeminarRooms extends BaseController
{
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

        // ✅ 지오코딩
        $lat = null;
        $lng = null;

        // DB에 좌표가 있으면 우선 사용
        if (isset($room['LC_LA']) && isset($room['LC_LO'])) {
            $dbLat = (float)($room['LC_LA'] ?? 0);
            $dbLng = (float)($room['LC_LO'] ?? 0);
            if ($dbLat >= -90 && $dbLat <= 90 && $dbLng >= -180 && $dbLng <= 180 && $dbLat != 0 && $dbLng != 0) {
                $lat = $dbLat;
                $lng = $dbLng;
            }
        }

        // DB 좌표가 없거나 이상하면 지오코딩 시도
        if (($lat === null || $lng === null) && $address !== '') {
            $geo = $this->naverGeocode($address);
            if (!$geo) {
                $clean = $this->cleanAddressForGeocode($address);
                if ($clean !== $address && $clean !== '') {
                    $geo = $this->naverGeocode($clean);
                }
            }
            if (!$geo && $address !== '') {
                $simple = $this->simplifyAddressForGeocode($address);
                if ($simple !== $address && $simple !== '') {
                    $geo = $this->naverGeocode($simple);
                }
            }
            if ($geo) {
                $lat = $geo['lat'];
                $lng = $geo['lng'];
            }
        }

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

        return view('SeminarRooms/detail', [
            'room' => $room,
            'latitude' => $lat,
            'longitude' => $lng,
            'nearby_rooms' => $nearby,
            'district' => $district,
        ]);
    }

    private function naverGeocode(string $query): ?array
    {
        $apiKeyId = getenv('NAVER_MAPS_API_KEY_ID') ?: 'c3hsihbnx3';
        $apiKey   = getenv('NAVER_MAPS_API_KEY') ?: 'iyBYir1BVYhy4bW5XWB1wHGfUNyOit2Pz4g413ce';
        if (!$apiKey) return null;
        $base = 'https://maps.apigw.ntruss.com/map-geocode/v2/geocode';
        $url  = $base . '?' . http_build_query(['query' => $query, 'count' => 1, 'page' => 1, 'language' => 'kor']);
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 6,
            CURLOPT_CONNECTTIMEOUT => 4,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'x-ncp-apigw-api-key-id: ' . $apiKeyId,
                'x-ncp-apigw-api-key: ' . $apiKey,
            ],
        ]);
        $raw  = curl_exec($ch);
        $http = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_errno($ch);
        curl_close($ch);
        if ($err !== 0 || $http !== 200 || !$raw) return null;
        $json = json_decode($raw, true);
        if (!is_array($json)) return null;
        $addr = $json['addresses'][0] ?? null;
        if (!$addr || !isset($addr['x'], $addr['y'])) return null;
        return ['lng' => (float)$addr['x'], 'lat' => (float)$addr['y']];
    }

    private function cleanAddressForGeocode(string $address): string
    {
        $a = trim($address);
        $a = preg_replace('/\s*\([^)]*\)/u', '', $a);
        $a = preg_replace('/\s*,.*$/u', '', $a);
        $a = preg_replace('/\s+(지상|지하)\s*\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*호/u', '', $a);
        $a = preg_replace('/\s+[가-힣]+빌딩/u', '', $a);
        $a = preg_replace('/\s+/u', ' ', trim($a));
        return $a;
    }

    private function simplifyAddressForGeocode(string $address): string
    {
        $a = trim($address);
        $a = preg_replace('/\s*\([^)]*\)/u', '', $a);
        $a = preg_replace('/\s*,.*$/u', '', $a);
        $a = preg_replace('/\s+[가-힣]+(빌딩|아파트|타워|센터|플라자|마트|백화점)/u', '', $a);
        $a = preg_replace('/\s+(지상|지하|지하)\s*\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*층/u', '', $a);
        $a = preg_replace('/\s+\d+\s*호/u', '', $a);
        $a = preg_replace('/\s+\d+-\d+/u', '', $a);
        $a = preg_replace('/\s+/u', ' ', trim($a));
        return $a;
    }
}
