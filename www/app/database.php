<?php

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * defines database connection according to the environment variable pointed
 */

$connection = [
    'development' => [
       'driver'    => $_ENV['DB_DRIVER_DEVELOPMENT'],
       'host'      => $_ENV['DB_HOST_DEVELOPMENT'],
       'database'  => $_ENV['DB_DATABASE_DEVELOPMENT'],
       'username'  => $_ENV['DB_USERNAME_DEVELOPMENT'],
       'password'  => $_ENV['DB_PASSWORD_DEVELOPMENT'],
       'charset'   => $_ENV['DB_CHARSET_DEVELOPMENT'],
       'collation' => $_ENV['DB_CHARSET_COLLECTION'],
       'prefix'    => ''
    ],
    'production' => [
        'driver'    =>  $_ENV['DB_DRIVER_PRODUCTION'],
        'host'      =>  $_ENV['DB_HOST_PRODUCTION'],
        'database'  =>  $_ENV['DB_DATABASE_PRODUCTION'],
        'username'  =>  $_ENV['DB_USERNAME_PRODUCTION'],
        'password'  =>  $_ENV['DB_PASSWORD_PRODUCTION'],
        'charset'   =>  $_ENV['DB_CHARSET_PRODUCTION'],
        'collation' =>  $_ENV['DB_CHARSET_PRODUCTION'],
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
