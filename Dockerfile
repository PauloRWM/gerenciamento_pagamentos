FROM php:8.0

RUN apt-get update -y && apt-get install -y \
    openssl zip unzip git libpng-dev libzip-dev libonig-dev libgmp-dev default-mysql-client && \
    docker-php-ext-install pdo_mysql gd zip gmp

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . /app

RUN chown -R www-data:www-data /app

RUN composer install --no-dev --optimize-autoloader

RUN php artisan cache:clear && php artisan config:clear && php artisan route:clear

CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181
