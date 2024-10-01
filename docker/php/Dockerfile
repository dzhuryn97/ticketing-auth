FROM php:8.3-fpm-alpine as build
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod 755 /usr/local/bin/install-php-extensions

RUN install-php-extensions gd pgsql pdo_pgsql amqp

WORKDIR /app

COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/www.conf /usr/local/etc/php/www.conf
COPY ./ ./

RUN chown -R www-data:www-data /app

FROM build as dev
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
§ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --ignore-platform-reqs

FROM build as prod





