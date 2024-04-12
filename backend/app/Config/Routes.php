<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {    
    $routes->options('login', 'Api::options');
    $routes->post('login', 'Api::login');    
    $routes->post('insert', 'Api::insert');
    $routes->get('get', 'Api::get');
    $routes->delete('delete', 'Api::delete');
});
