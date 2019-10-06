<?php

/**
 * creates database connection separating development and production base. Uses eloquent library
 * 
 * @author Samuel Bretas <samuelbretas@gmail.com>
 */

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * defines database connection according to the environment variable pointed
 */
$connection = [
    'development' => [
       'driver'    =>  getenv('DB_DRIVER_DEVELOPMENT'),
       'host'      =>  getenv('DB_HOST_DEVELOPMENT'),
       'database'  =>  getenv('DB_DATABASE_DEVELOPMENT'),
       'username'  =>  getenv('DB_USERNAME_DEVELOPMENT'),
       'password'  =>  getenv('DB_PASSWORD_DEVELOPMENT'),
       'charset'   =>  getenv('DB_CHARSET_DEVELOPMENT'),
       'collation' =>  getenv('DB_CHARSET_COLLECTION'),
       'prefix'    => ''      
    ],
    'production' => [
        'driver'    =>  getenv('DB_DRIVER_PRODUCTION'),
        'host'      =>  getenv('DB_HOST_PRODUCTION'),
        'database'  =>  getenv('DB_DATABASE_PRODUCTION'),
        'username'  =>  getenv('DB_USERNAME_PRODUCTION'),
        'password'  =>  getenv('DB_PASSWORD_PRODUCTION'),
        'charset'   =>  getenv('DB_CHARSET_PRODUCTION'),
        'collation' =>  getenv('DB_CHARSET_PRODUCTION'),
        'prefix'    => ''     
    ]
];



/**
 * run connection database myql
 */
$capsule = new Capsule;
$capsule->addConnection($connection[ENVIRONMENT]);
$capsule->setAsGlobal();
$capsule->bootEloquent();