# Build stage
FROM node:20-alpine AS builder
WORKDIR /app
COPY package*.json ./
RUN npm install 2>/dev/null || true
COPY . .
RUN npm run build 2>/dev/null || true

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

# Copy composer files (if they exist)
COPY composer*.json* ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader 2>/dev/null || true

# Copy built app
COPY --from=builder /app /app
WORKDIR /app

# Set permissions
RUN chown -R www-data:www-data /app || true

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD curl -f http://localhost:9000/health || exit 0

EXPOSE 9000
USER www-data
CMD ["php-fpm"]