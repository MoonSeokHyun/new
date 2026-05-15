<?php

declare(strict_types=1);

namespace App\Traits;

/**
 * 네이버 Maps Geocoding REST + 주소 정리.
 * CodeIgniter .env 는 env() 로 읽는 것이 getenv() 보다 안정적입니다.
 */
trait NaverGeocodeTrait
{
    protected function naverGeocode(string $query): ?array
    {
        $query = trim($query);
        if ($query === '') {
            return null;
        }

        $apiKeyId = env('NAVER_MAPS_API_KEY_ID', '');
        $apiKey   = env('NAVER_MAPS_API_KEY', '');
        if ($apiKeyId === '' || $apiKey === '') {
            return null;
        }

        $base = 'https://maps.apigw.ntruss.com/map-geocode/v2/geocode';
        $url  = $base . '?' . http_build_query([
            'query'    => $query,
            'count'    => 1,
            'page'     => 1,
            'language' => 'kor',
        ]);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 6,
            CURLOPT_CONNECTTIMEOUT => 4,
            CURLOPT_HTTPHEADER     => [
                'Accept: application/json',
                'x-ncp-apigw-api-key-id: ' . $apiKeyId,
                'x-ncp-apigw-api-key: ' . $apiKey,
            ],
        ]);

        $raw  = curl_exec($ch);
        $http = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_errno($ch);
        curl_close($ch);

        if ($err !== 0 || $http !== 200 || ! is_string($raw) || $raw === '') {
            return null;
        }

        $json = json_decode($raw, true);
        if (! is_array($json)) {
            return null;
        }
        if (($json['status'] ?? '') !== 'OK') {
            return null;
        }

        $addr = $json['addresses'][0] ?? null;
        if (! is_array($addr) || ! isset($addr['x'], $addr['y'])) {
            return null;
        }

        return ['lng' => (float) $addr['x'], 'lat' => (float) $addr['y']];
    }

    protected function cleanAddressForGeocode(string $address): string
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

    protected function simplifyAddressForGeocode(string $address): string
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

    /**
     * DB 위·경도가 유효하면 사용하고, 없으면 주소(변형 포함)로 지오코딩합니다.
     *
     * @return array{lat: float|null, lng: float|null}
     */
    protected function latLngFromDbOrGeocode(string $address, ?float $dbLat, ?float $dbLng, bool $rejectZeroPair = true): array
    {
        $lat = null;
        $lng = null;

        if ($dbLat !== null && $dbLng !== null) {
            if ($dbLat >= -90.0 && $dbLat <= 90.0 && $dbLng >= -180.0 && $dbLng <= 180.0) {
                if (! $rejectZeroPair || ($dbLat !== 0.0 || $dbLng !== 0.0)) {
                    $lat = $dbLat;
                    $lng = $dbLng;
                }
            }
        }

        if ($lat !== null && $lng !== null) {
            return ['lat' => $lat, 'lng' => $lng];
        }

        $address = trim($address);
        if ($address === '') {
            return ['lat' => null, 'lng' => null];
        }

        foreach ($this->geocodeQueryVariants($address) as $q) {
            $geo = $this->naverGeocode($q);
            if ($geo) {
                return ['lat' => $geo['lat'], 'lng' => $geo['lng']];
            }
        }

        return ['lat' => null, 'lng' => null];
    }

    /**
     * @return list<string>
     */
    protected function geocodeQueryVariants(string $address): array
    {
        $address = trim($address);
        $variants = [];
        if ($address !== '') {
            $variants[] = $address;
        }

        $clean = $this->cleanAddressForGeocode($address);
        if ($clean !== $address && $clean !== '') {
            $variants[] = $clean;
        }

        $simple = $this->simplifyAddressForGeocode($address);
        if ($simple !== $address && $simple !== '' && $simple !== $clean) {
            $variants[] = $simple;
        }

        return array_values(array_unique($variants));
    }

    protected function naverBlogSearch(string $query, string $suffix = ' 정보'): array
    {
        $query = trim($query);
        if ($query === '') return [];

        $clientId     = env('NAVER_SEARCH_CLIENT_ID', '');
        $clientSecret = env('NAVER_SEARCH_CLIENT_SECRET', '');
        if ($clientId === '' || $clientSecret === '') return [];

        $url = 'https://openapi.naver.com/v1/search/blog.json?' . http_build_query([
            'query'   => $query . $suffix,
            'display' => 5,
            'sort'    => 'sim',
        ]);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER     => [
                'X-Naver-Client-Id: '     . $clientId,
                'X-Naver-Client-Secret: ' . $clientSecret,
            ],
        ]);

        $raw  = curl_exec($ch);
        $http = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http !== 200 || !$raw) return [];

        $json = json_decode($raw, true);
        return $json['items'] ?? [];
    }
}
