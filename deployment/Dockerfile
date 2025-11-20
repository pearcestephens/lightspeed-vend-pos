# Frontend build stage (optional - can fail gracefully)
FROM node:20-alpine AS frontend-builder
WORKDIR /build
COPY frontend/package*.json ./
RUN npm install --legacy-peer-deps 2>/dev/null || true
COPY frontend/ ./
RUN npm run build 2>/dev/null || mkdir -p build

# PHP Runtime stage
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    mariadb-client \
    curl \
    git \
    zip \
    unzip \
    bash

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY --chown=www-data:www-data . /var/www/html

# Copy frontend build artifacts
COPY --from=frontend-builder --chown=www-data:www-data /build/build /var/www/html/public/build

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction || composer update --no-dev --no-interaction

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD curl -f http://localhost:9000/api/health || exit 1

EXPOSE 9000
USER www-data
CMD ["php-fpm"]