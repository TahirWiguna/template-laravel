ARG PHP_EXTENSIONS="apcu bcmath pdo_pgsql pdo_mysql redis imagick gd zip"

FROM thecodingmachine/php:8.0-v4-fpm as php_base

COPY --chown=docker:docker . /var/www/html
RUN composer install --quiet --optimize-autoloader --no-dev --ignore-platform-reqs

FROM php_base
ENV PHP_EXTENSION_PGSQL=1
ENV PHP_EXTENSION_PDO_PGSQL=1