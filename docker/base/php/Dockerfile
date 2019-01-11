FROM php:7.2.8-fpm-alpine

RUN apk update && apk add \
    openssh \
    bash \
    git \
    libpng-dev \
    zlib-dev

RUN apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/testing/ --allow-untrusted gnu-libiconv
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

RUN docker-php-ext-install \
    mbstring \
    iconv \
    pcntl \
    pdo \
    pdo_mysql \
    zip \
    gd

WORKDIR /var/www
