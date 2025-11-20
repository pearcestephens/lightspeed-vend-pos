#!/bin/bash
set -e

echo "🚀 Starting deployment..."

# Variables
APP_DIR="/var/www/app"
BACKUP_DIR="/var/backups/app"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

# Backup
echo "📦 Creating backup..."
cp -r $APP_DIR "$BACKUP_DIR/backup_$TIMESTAMP"

# Pull latest code
echo "📥 Pulling latest code..."
cd $APP_DIR
git pull origin main

# Install dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader
npm install --production

# Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# Clear caches
echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Build frontend
echo "🎨 Building frontend..."
npm run build

# Restart services
echo "🔄 Restarting services..."
systemctl restart php-fpm
systemctl restart nginx

# Health check
echo "🏥 Health checking..."
sleep 5
curl -f http://localhost/health || exit 1

echo "✅ Deployment completed successfully!"