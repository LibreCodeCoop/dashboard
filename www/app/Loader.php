<?php

session_start();

require BASE_PATH . 'vendor/autoload.php';

//invoke dotenv symfony package
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(realpath('/app'). '/.env');


/**
 * invoke router routine
 */
$app = System\App::instance();
$app->request = System\Request::instance();
$app->route = System\Route::instance($app->request);
$route = $app->route;


/**
 *  route group
 */
$route->get(['/', 'index', 'home', 'default'], 'App\Controllers\AuthController@login');

/**
 * route group authentication
 */
$route->group('/auth', function () {
    $this->post('/connect', 'App\Controllers\AuthController@connect');
    $this->get('/disconnect', 'App\Controllers\AuthController@disconnect');
});


/**
 * route control panel
 */
$route->get('panel', 'App\Controllers\PanelController@dashboard');

/**
 * route group
 */
$route->group('/customer', function () {
    $this->get('/', 'App\Controllers\CustomerController@all');    
    $this->get('/create', 'App\Controllers\CustomerController@create');
    $this->post('/create', 'App\Controllers\CustomerController@save');
    $this->post('/find', 'App\Controllers\CustomerController@find');
    $this->get('/edit/{id}/{type}', 'App\Controllers\CustomerController@edit');
    $this->post('/{id}/edit', 'App\Controllers\CustomerController@save');
    $this->get('/{id}/delete', 'App\Controllers\CustomerController@delete');
});


$route->group('/user', function () {

    $this->get('/list/{idCustomer}', 'App\Controllers\UserController@list');
    $this->get('/create/{idCustomer}', 'App\Controllers\UserController@create');
    $this->post('/save', 'App\Controllers\UserController@save');
    $this->get('/edit/{id}/{idCustomer}', 'App\Controllers\UserController@edit');
    $this->get('delete/{id}', 'App\Controllers\UserController@delete');
});



require BASE_PATH . 'app/database.php';
/**
 * run application
 */
$route->end();
