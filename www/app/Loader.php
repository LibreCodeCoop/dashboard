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
$route->group('/client', function () {
    $this->get('/', 'App\Controllers\ClientController@all');
    $this->get('/create', 'App\Controllers\ClientController@create');
    $this->post('/create', 'App\Controllers\ClientController@save');
    $this->get('/{id}/edit', 'App\Controllers\ClientController@edit');
    $this->post('/{id}/edit', 'App\Controllers\ClientController@save');
    $this->get('/{id}/delete', 'App\Controllers\ClientController@delete');
});

require BASE_PATH . 'app/database.php';
/**
 * run application
 */
$route->end();
