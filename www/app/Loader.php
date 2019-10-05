<?php

/**
 * File loads project via autoload composer psr4, and database file. 
 * Instantiates router and directs routes with its verbs
 * 
 * @author Samuel Bretas <samuelbretas@gmail.com>
 */

session_start();

require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'app/database.php';

/**
 * Instancia o roteador.
 */
$app = System\App::instance();
$app->request = System\Request::instance();
$app->route = System\Route::instance($app->request);
$route = $app->route;

/**
 * create routes and arrow main route
 */
/**
 *  route group authentication
 */
$route->group(['/', 'index', 'home', 'default'], function(){
    $this->get('/', 'App\Controllers\AuthController@login');
    $this->get('/connect', 'App\Controller\AuthController@connect');
    $this->get('/disconnect', 'App\Controller\AuthController@disconnect');
});


/**
 * route control panel
 */
$route->get('panel', 'App\Controllers\PanelController@dashboard');

/**
 * route group
 */
$route->group('/client', function(){
    $this->get ('/',            'App\Controllers\ClientController@all');
    $this->get ('/create',      'App\Controllers\ClientController@create');
    $this->post('/create',      'App\Controllers\ClientController@save');
    $this->get ('/{id}/edit',   'App\Controllers\ClientController@edit');
    $this->post('/{id}/edit',   'App\Controllers\ClientController@save');
    $this->get ('/{id}/delete', 'App\Controllers\ClientController@delete');
});


/**
 * run application
 */
$route->end();


