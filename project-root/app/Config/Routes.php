<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('api/coasters', 'Coaster::create');
$routes->put('api/coasters/(:num)', 'Coaster::update/$1');
$routes->post('api/coasters/(:num)/wagons', 'Wagon::create/$1');
$routes->delete('api/coasters/(:num)/wagons/(:num)', 'Wagon::remove/$1/$2');

$routes->get('api/coasters/(:num)/status', 'CoasterStatusController::show/$1');
