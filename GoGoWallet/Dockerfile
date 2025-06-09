FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Set DocumentRoot ke /var/www/html/public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Copy project ke container
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Set permission
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Dockerfile
FROM composer:2.7 AS composer
WORKDIR /app
COPY . /app
RUN composer install

FROM php:8.2-apache
WORKDIR /var/www/html
COPY . /var/www/html
RUN docker-php-ext-install pdo pdo_mysql
