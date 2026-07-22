# ── Build Stage: Composer dependencies ──
FROM composer:2 AS composer

WORKDIR /app

# Copy all files so artisan + app code exist for post-autoload-dump scripts
COPY . .

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --optimize-autoloader

# ── Build Stage: Node / Vite frontend assets ──
FROM node:22-alpine AS node

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts

COPY vite.config.js ./
COPY resources/ resources/
RUN npm run build

# ── Final Stage: PHP + Nginx ──
FROM php:8.4-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    linux-headers \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_pgsql \
    pdo_mysql \
    mbstring \
    xml \
    gd \
    bcmath \
    zip \
    opcache \
    && rm -rf /var/cache/apk/*

# Copy app code
WORKDIR /var/www
COPY --from=composer /app/vendor /var/www/vendor
COPY . .

# Copy built frontend assets
COPY --from=node /app/public/build /var/www/public/build

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Nginx config
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Supervisor config (runs php-fpm + nginx)
COPY docker/supervisord.conf /etc/supervisord.conf

# Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
