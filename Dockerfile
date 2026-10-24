# syntax=docker/dockerfile:1

# ---------- Stage 1: PHP dependencies (from composer.lock) ----------
FROM composer:2.8 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
# Install the full dependency set here because dev packages such as laravel/breeze
# are required when the app is bootstrapped in the container.
RUN composer install --no-interaction --prefer-dist \
    --no-scripts --no-autoloader
COPY . .
RUN rm -f bootstrap/cache/packages.php bootstrap/cache/services.php \
    && composer dump-autoload --optimize --classmap-authoritative --no-scripts \
    && rm -f bootstrap/cache/packages.php bootstrap/cache/services.php

# ---------- Stage 2: frontend assets (from package-lock.json) ----------
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js ./
COPY public ./public
RUN npm run build

# ---------- Stage 3: runtime image (PHP-FPM, non-root) ----------
FROM php:8.3-fpm-alpine AS app
RUN apk add --no-cache libzip-dev oniguruma-dev \
    && docker-php-ext-install pdo_mysql mbstring zip opcache bcmath

WORKDIR /var/www/html
COPY --from=vendor /app /var/www/html
COPY --from=assets /app/public/build /var/www/html/public/build
RUN rm -f bootstrap/cache/packages.php bootstrap/cache/services.php

# Non-root user; only storage and bootstrap/cache are writable
RUN addgroup -g 1000 laravel && adduser -D -u 1000 -G laravel laravel \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R laravel:laravel storage bootstrap/cache

USER laravel
EXPOSE 9000
CMD ["php-fpm"]

# ---------- Stage 4: web server (Nginx, non-root, serves only public/) ----------
FROM nginxinc/nginx-unprivileged:1.27-alpine AS web
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=app /var/www/html/public /var/www/html/public
EXPOSE 8080
