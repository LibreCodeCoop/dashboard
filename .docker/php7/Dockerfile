FROM php:7.4-fpm

RUN apt-get update

RUN apt-get install -y \
        git \
        libzip-dev \
        unzip
RUN docker-php-ext-install -j "$(nproc)" \
        zip

# Install MySQL PDO
RUN apt-get install -y git libzip-dev \
    && docker-php-ext-configure mysqli -with-mysqli=mysqlnd \
    && docker-php-ext-configure pdo_mysql -with-pdo-mysql=mysqlnd \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && docker-php-ext-install zip

# Install xdebug
RUN pecl install xdebug-2.9.0 \
    && docker-php-ext-enable xdebug

COPY config/php.ini /usr/local/etc/php/conf.d/

RUN curl https://getcomposer.org/composer.phar --output /usr/bin/composer
RUN chmod +x /usr/bin/composer

WORKDIR /app
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
ENTRYPOINT ["sh", "/usr/local/bin/entrypoint.sh"]
