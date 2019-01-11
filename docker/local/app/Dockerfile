FROM composer:1.7 as composer

FROM codemistake/php-base:latest

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apk update && apk add \
    autoconf \
    g++ \
    make \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./php.ini /usr/local/etc/php/

WORKDIR /var/www
