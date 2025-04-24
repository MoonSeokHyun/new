<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/posts', 'Posts::index');
$routes->get('/posts/create', 'Posts::create');
$routes->post('/posts', 'Posts::store');
$routes->get('/posts/(:num)', 'Posts::show/$1');
$routes->get('/posts/(:num)/edit', 'Posts::edit/$1');
$routes->post('/posts/(:num)', 'Posts::update/$1');
$routes->post('/posts/(:num)/delete', 'Posts::delete/$1');
$routes->get('/posts/(:num)/like', 'Posts::like/$1');  // 수정된 부분
$routes->get('/posts/(:num)/dislike', 'Posts::dislike/$1');  // 수정된 부분
$routes->post('posts/(:num)/reply', 'Posts::addReply'); // 댓글 추가
$routes->get('crawler/crawlAndSave/(:num)', 'Crawler::crawlAndSave/$1');
$routes->get('crawler/crawlAndSave', 'Crawler::crawlAndSave');

$routes->get('dcinside/crawl/(:num)', 'DCInsideCrawler::crawlDCInside/$1');
$routes->get('dcinside/crawl', 'DCInsideCrawler::crawl');

// Sitemap Routes
$routes->get('sitemap.xml', 'SitemapController::index'); // 사이트맵 인덱스
$routes->get('sitemap/page/(:num)', 'SitemapController::page/$1'); // 각 페이지별 사이트맵

$routes->post('/posts/(:num)/ajaxLike', 'Posts::ajaxLike/$1');
$routes->post('/posts/(:num)/ajaxDislike', 'Posts::ajaxDislike/$1');

$routes->get('sitemap/hairSalonSitemap', 'SitemapController::index');
$routes->get('sitemap/hairSalonPage/(:num)', 'SitemapController::hairSalonPage/$1');
$routes->get('sitemap/installationSitemap', 'SitemapController::index');
$routes->get('sitemap/installationPage/(:num)', 'SitemapController::installationPage/$1');

//미용실

$routes->get('/hairsalon', 'HairSalonController::index');  // 미용실 목록 페이지 (페이징 + 검색 기능 포함)
$routes->get('/hairsalon/detail/(:segment)', 'HairSalonController::detail/$1');  // 미용실 디테일 페이지

//사이트맵용 
$routes->get('/hairsalon/detail/(:num)', 'HairSalonController::detail/$1');

$routes->get('/hairsalon/detail/(:segment)', 'SitemapController::addHairSalonSitemap/$1');

$routes->get('/installation', 'InstallationController::index');
$routes->get('/installation/show/(:num)', 'InstallationController::show/$1');

$routes->get('/clothingcollectionbin', 'ClothingCollectionBinController::index');
$routes->get('/clothingcollectionbin/show/(:num)', 'ClothingCollectionBinController::show/$1');
$routes->get('/sitemap/clothingCollectionBinPage/(:num)', 'SitemapController::clothingCollectionBinPage/$1');

// File: app/Config/Routes.php
$routes->get('seminar_rooms',       'SeminarRooms::index');
$routes->get('seminar_rooms/(:num)', 'SeminarRooms::detail/$1');
$routes->get('sitemap/seminarRoomPage/(:num)',            'SitemapController::seminarRoomPage/$1');  // ← 추가

// 캠핑장 

$routes->get('camping', 'Camping::index');
$routes->get('camping/(:num)', 'Camping::detail/$1');
$routes->get('sitemap/campingPage/(:num)', 'SitemapController::campingPage/$1');


// 세계 식당 

$routes->get('world_res',          'WorldRes::index');
$routes->get('world_res/(:num)',   'WorldRes::detail/$1');
$routes->get('sitemap/worldResPage/(:num)', 'SitemapController::worldResPage/$1');


// 체육시설
$routes->get('sports_facilities',          'SportsFacility::index');
$routes->get('sports_facilities/(:num)',   'SportsFacility::detail/$1');

$routes->get('sitemap/sportsFacilitiesPage/(:num)', 'SitemapController::sportsFacilitiesPage/$1');

//도서관 

$routes->get('LibraryInfo', 'LibraryInfoController::index');
$routes->get('LibraryInfo/detail/(:num)', 'LibraryInfoController::detail/$1');
$routes->get('sitemap/libraryInfoPage/(:num)', 'SitemapController::libraryInfoPage/$1');  // 도서관 사이트맵 라우터 추가

//안경점

// app/Config/Routes.php 에 추가
$routes->get('shops', 'OpenServiceInfoController::index');
$routes->get('shops/(:num)', 'OpenServiceInfoController::detail/$1');
$routes->get('sitemap/shopsPage/(:num)', 'SitemapController::shopsPage/$1');