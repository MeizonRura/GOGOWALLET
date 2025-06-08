# Dockerfile
FROM composer:2.7 AS composer
WORKDIR /app
COPY . /app
RUN composer install

FROM php:8.2-apache
WORKDIR /var/www/html
COPY . /var/www/html
RUN docker-php-ext-install pdo pdo_mysql