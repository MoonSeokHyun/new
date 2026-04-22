<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// 게시판 폐쇄: 410 Gone 으로 응답 (기존 색인된 URL을 검색엔진에서 깔끔히 제거하기 위함)
$routes->get('/posts', 'Posts::index');
$routes->get('/posts/create', 'Posts::create');
$routes->get('/posts/(:num)', 'Posts::show/$1');
$routes->get('/posts/(:num)/edit', 'Posts::edit/$1');

// Sitemap Routes
$routes->get('sitemap.xml', 'SitemapController::index'); // 사이트맵 인덱스

$routes->get('sitemap/hairSalonSitemap', 'SitemapController::index');
$routes->get('sitemap/hairSalonPage/(:num)', 'SitemapController::hairSalonPage/$1');
$routes->get('sitemap/installationSitemap', 'SitemapController::index');
$routes->get('sitemap/installationPage/(:num)', 'SitemapController::installationPage/$1');

//미용실

$routes->get('/hairsalon', 'HairSalonController::index');  // 미용실 목록 페이지 (페이징 + 검색 기능 포함)
$routes->get('/hairsalon/detail/(:num)', 'HairSalonController::detail/$1');  // 미용실 디테일 페이지 (정수 ID만 허용)

$routes->get('/installation', 'InstallationController::index');
$routes->get('/installation/show/(:num)', 'InstallationController::show/$1');

$routes->get('/clothingcollectionbin', 'ClothingCollectionBinController::index');
$routes->get('/clothing-collection-bin', 'ClothingCollectionBinController::index'); // 하이픈 버전
$routes->get('/clothingcollectionbin/show/(:num)', 'ClothingCollectionBinController::show/$1');
$routes->get('/clothing-collection-bin/show/(:num)', 'ClothingCollectionBinController::show/$1'); // 하이픈 버전
$routes->get('/sitemap/clothingCollectionBinPage/(:num)', 'SitemapController::clothingCollectionBinPage/$1');

// File: app/Config/Routes.php
$routes->get('seminar-rooms',       'SeminarRooms::index');
$routes->get('seminar-rooms/detail/(:num)', 'SeminarRooms::detail/$1');
$routes->get('seminar_rooms', 'SeminarRooms::index'); // 하위 호환성
$routes->get('seminar_rooms/(:num)', 'SeminarRooms::detail/$1'); // 하위 호환성
$routes->get('/seminar_rooms', 'SeminarRooms::index');
$routes->get('/seminar_rooms/(:num)', 'SeminarRooms::detail/$1');
$routes->get('sitemap/seminarRoomPage/(:num)',            'SitemapController::seminarRoomPage/$1');  // ← 추가

// 캠핑장
$routes->get('camping', 'Camping::index');
$routes->get('camping/(:num)', 'Camping::detail/$1');
$routes->get('camping/detail/(:num)', 'Camping::detail/$1'); // 과거 변이 URL 하위 호환성
$routes->get('/camping/detail/(:num)', 'Camping::detail/$1');
$routes->get('sitemap/campingPage/(:num)', 'SitemapController::campingPage/$1');


// 세계 식당 

$routes->get('world-res',          'WorldRes::index');
$routes->get('world-res/detail/(:num)',   'WorldRes::detail/$1');
$routes->get('world_res', 'WorldRes::index'); // 구 사이트맵 하위 호환성
$routes->get('world_res/(:num)', 'WorldRes::detail/$1'); // 구 사이트맵 하위 호환성
$routes->get('world_res/detail/(:num)', 'WorldRes::detail/$1');
$routes->get('/world_res', 'WorldRes::index');
$routes->get('/world_res/(:num)', 'WorldRes::detail/$1');
$routes->get('/world_res/detail/(:num)', 'WorldRes::detail/$1');
$routes->get('sitemap/worldResPage/(:num)', 'SitemapController::worldResPage/$1');


// 체육시설
$routes->get('sports-facility',          'SportsFacility::index');
$routes->get('sports-facility/detail/(:num)',   'SportsFacility::detail/$1');
$routes->get('sports_facilities', 'SportsFacility::index'); // 구 사이트맵 하위 호환성
$routes->get('sports_facilities/(:num)', 'SportsFacility::detail/$1'); // 구 사이트맵 하위 호환성
$routes->get('sports_facilities/detail/(:num)', 'SportsFacility::detail/$1');
$routes->get('/sports_facilities', 'SportsFacility::index');
$routes->get('/sports_facilities/(:num)', 'SportsFacility::detail/$1');
$routes->get('/sports_facilities/detail/(:num)', 'SportsFacility::detail/$1');

$routes->get('sitemap/sportsFacilitiesPage/(:num)', 'SitemapController::sportsFacilitiesPage/$1');

// 도서관 (canonical: 소문자 하이픈). 뷰 canonical 메타는 library-info 로 고정.
$routes->get('library-info', 'LibraryInfoController::index');
$routes->get('library-info/detail/(:num)', 'LibraryInfoController::detail/$1');
$routes->get('/library-info', 'LibraryInfoController::index');
$routes->get('/library-info/detail/(:num)', 'LibraryInfoController::detail/$1');
// 과거 대소문자 혼합·소문자 URL — 리다이렉트 없이 동일 페이지 (환경별 site_url/리다이렉트 오류 방지)
$routes->get('LibraryInfo', 'LibraryInfoController::index');
$routes->get('LibraryInfo/detail/(:num)', 'LibraryInfoController::detail/$1');
$routes->get('/LibraryInfo', 'LibraryInfoController::index');
$routes->get('/LibraryInfo/detail/(:num)', 'LibraryInfoController::detail/$1');
$routes->get('libraryinfo', 'LibraryInfoController::index');
$routes->get('libraryinfo/detail/(:num)', 'LibraryInfoController::detail/$1');
$routes->get('sitemap/libraryInfoPage/(:num)', 'SitemapController::libraryInfoPage/$1');  // 도서관 사이트맵 라우터 유지

//안경점

// app/Config/Routes.php 에 추가
$routes->get('open-service-info', 'OpenServiceInfoController::index');
$routes->get('open-service-info/detail/(:num)', 'OpenServiceInfoController::detail/$1');
$routes->get('shops', 'OpenServiceInfoController::index'); // 구 사이트맵 하위 호환성
$routes->get('shops/(:num)', 'OpenServiceInfoController::detail/$1'); // 구 사이트맵 하위 호환성
$routes->get('shops/detail/(:num)', 'OpenServiceInfoController::detail/$1');
$routes->get('/shops', 'OpenServiceInfoController::index');
$routes->get('/shops/(:num)', 'OpenServiceInfoController::detail/$1');
$routes->get('/shops/detail/(:num)', 'OpenServiceInfoController::detail/$1');
$routes->get('sitemap/shopsPage/(:num)', 'SitemapController::shopsPage/$1');

$routes->get('analytics', 'Analytics::index');

$routes->get('animal-hospital', 'AnimalHospitalController::index');
$routes->get('animal-hospital/detail/(:num)', 'AnimalHospitalController::detail/$1');

// app/Config/Routes.php

$routes->get('sitemap/animalHospitalPage/(:num)', 'SitemapController::animalHospitalPage/$1');

