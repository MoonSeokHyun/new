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


