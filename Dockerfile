FROM php:8.2-cli
RUN docker-php-ext-install pcntl
COPY . /var/www/html
WORKDIR /var/www/html
RUN composer install
