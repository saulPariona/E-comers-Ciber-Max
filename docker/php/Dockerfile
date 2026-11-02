# syntax=docker/dockerfile:1

# ---------- Base: PHP-FPM con las extensiones del proyecto ----------
FROM php:8.4-fpm-alpine AS base

ARG UID=1000
ARG GID=1000

RUN apk add --no-cache icu-dev libzip-dev libpng-dev libjpeg-turbo-dev freetype-dev libpq-dev \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS linux-headers \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_pgsql intl zip gd bcmath opcache pcntl exif \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-app.ini

RUN addgroup -g "${GID}" app && adduser -D -u "${UID}" -G app app

WORKDIR /var/www/html
USER app

# ---------- Assets: compila Vite para producción ----------
FROM node:22-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---------- Prod: código + dependencias sin herramientas de desarrollo ----------
FROM base AS prod
COPY --chown=app:app . .
COPY --from=assets --chown=app:app /app/public/build ./public/build
COPY docker/php/php-prod.ini /usr/local/etc/php/conf.d/zz-prod.ini
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# ---------- Web prod: Nginx con los archivos públicos ----------
FROM nginx:stable-alpine AS web-prod
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=prod /var/www/html/public /var/www/html/public
