FROM composer as builder
WORKDIR /app
COPY composer.* ./
RUN composer install --ignore-platform-reqs --no-scripts

FROM php:8.3-fpm-alpine as build
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod 755 /usr/local/bin/install-php-extensions

RUN install-php-extensions gd pgsql pdo_pgsql amqp

WORKDIR /app

COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/www.conf /usr/local/etc/php/www.conf
COPY ./ ./
COPY --from=builder /app/vendor /app/vendor
RUN chown -R www-data:www-data /app

FROM build as dev
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

FROM build as prod





