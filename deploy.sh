#!/bin/bash

# Darvag Project Manager - Deployment Script
# Run this script on your production server

echo "🚀 Starting Darvag Project Manager Deployment..."

# 1. Pull latest changes from git
echo "📥 Pulling latest changes from git..."
git pull origin main

# 2. Install/Update Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# 3. Install/Update NPM dependencies and build assets
echo "🎨 Building frontend assets..."
npm install
npm run build

# 4. Copy environment file
echo "⚙️ Setting up environment..."
cp .env.production .env

# 5. Generate application key if not exists
echo "🔑 Generating application key..."
php artisan key:generate

# 6. Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 7. Clear and cache configurations
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 8. Cache configurations for production
echo "⚡ Caching configurations for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Set proper permissions
echo "🔐 Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache

# 10. Restart services (if using systemd)
echo "🔄 Restarting services..."
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm

echo "✅ Deployment completed successfully!"
echo "🌐 Your application should now be available at your domain."
