<?php

define('ENVIRONMENT', 'development');
date_default_timezone_set('Brazil/East');
/**
 * define the project path
 */
define('DS', DIRECTORY_SEPARATOR, true);
define('BASE_PATH', __DIR__ . DS . '..' . DS, true);

/**
 * handles display errors
 */
switch (ENVIRONMENT) {
    case 'development':
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        break;
    case 'production':
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
        break;
}

require BASE_PATH.'app/Loader.php';
