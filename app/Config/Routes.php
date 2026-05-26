<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/',                    'HomeController::index');
$routes->get('/cari',                'NewsController::cari');
$routes->get('/kategori/(:segment)', 'NewsController::kategori/$1');
$routes->get('/berita/(:segment)',   'NewsController::detail/$1');
