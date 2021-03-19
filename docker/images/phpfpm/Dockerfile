FROM bitnami/php-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y bash curl vim

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER 1

COPY composer.json .

RUN composer install --no-scripts --no-dev --prefer-dist --optimize-autoloader && composer clear-cache

COPY . .
#COPY ../.. .
