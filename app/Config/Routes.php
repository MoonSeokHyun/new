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

//미용실

$routes->get('/hairsalon', 'HairSalonController::index');  // 미용실 목록 페이지 (페이징 + 검색 기능 포함)
$routes->get('/hairsalon/detail/(:segment)', 'HairSalonController::detail/$1');  // 미용실 디테일 페이지



