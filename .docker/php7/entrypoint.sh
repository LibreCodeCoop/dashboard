#!/bin/bash
. `pwd`/.env
if [ ! -d "vendor" ]; then
    chown -R www-data:www-data storage/ bootstrap/cache
    composer global require hirak/prestissimo
    export COMPOSER_ALLOW_SUPERUSER=1
    composer install
    if [ -z "APP_KEY" ]; then
        php artisan key:generate
    fi
    php .docker/php7/wait-for-mysql.php
    php artisan migrate --force
    php artisan db:seed
fi
php .docker/php7/wait-for-mysql.php
php artisan migrate --force
echo "+----------------------------+"
echo "| Welcome to admin dashboard |"
echo "+----------------------------+"
echo "Application URL: ${APP_URL}"
php-fpm
