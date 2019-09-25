FROM php:7.3-fpm

RUN apt-get update

RUN apt-get install -y \
        git \
        libzip-dev
RUN docker-php-ext-install -j "$(nproc)" \
        zip

# Install MySQL PDO
RUN apt-get install -y git libzip-dev \
    && docker-php-ext-configure mysqli -with-mysqli=mysqlnd \
    && docker-php-ext-configure pdo_mysql -with-pdo-mysql=mysqlnd \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && docker-php-ext-install zip

RUN git clone https://github.com/nikic/php-ast.git \
    && cd php-ast \
    && phpize \
    && ./configure \
    && make install \
    && echo 'extension=ast.so' > /usr/local/etc/php/php.ini \
    && cd .. && rm -rf php-ast

# Install xdebug
RUN pecl install xdebug-2.8.0beta2 \
    && docker-php-ext-enable xdebug

# Install ds
RUN pecl install ds \   
    && docker-php-ext-enable ds

COPY config/php.ini /usr/local/etc/php/conf.d/

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /app
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
ENTRYPOINT ["sh", "/usr/local/bin/entrypoint.sh"]
