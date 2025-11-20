# Build stage
FROM node:20-alpine AS builder
WORKDIR /app
COPY frontend/package*.json ./
RUN npm ci --legacy-peer-deps
COPY frontend/ .
RUN npm run build

# Runtime stage
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    mariadb-client \
    redis \
    curl \
    git \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql opcache redis

# Copy composer dependencies
COPY --from=builder /app /app
WORKDIR /app

# Copy Composer from builder if available
COPY composer.lock composer.json ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /app

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD curl -f http://localhost:9000/health || exit 1

EXPOSE 9000
USER www-data
CMD ["php-fpm"]