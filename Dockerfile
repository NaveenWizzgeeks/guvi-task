FROM php:8.1-apache

RUN apt-get update && apt-get install -y libzip-dev zip unzip libssl-dev && \
    docker-php-ext-install zip mysqli && \
    pecl install mongodb redis && \
    docker-php-ext-enable mongodb redis

RUN a2enmod rewrite

COPY . /var/www/html/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

RUN chown -R www-data:www-data /var/www/html
