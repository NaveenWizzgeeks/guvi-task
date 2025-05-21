FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev unzip curl \
    && docker-php-ext-install zip mysqli \
    && pecl install redis mongodb-1.15.0 \
    && docker-php-ext-enable redis mongodb

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . /var/www/html/

RUN composer install
