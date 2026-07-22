#!/bin/sh
set -e

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  AngkorShop — Railway Deployment"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Create required storage directories
echo "→ Creating storage directories..."
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/logs
chmod -R 775 storage

# Storage symlink (idempotent)
echo "→ Linking storage..."
php artisan storage:link --force 2>/dev/null || true

# Cache Laravel config/routes/views for production
echo "→ Caching config & routes..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (safe — only runs pending)
echo "→ Running migrations..."
php artisan migrate --force

# Seed database (idempotent — uses firstOrCreate, safe to run every deploy)
echo "→ Seeding database..."
php artisan db:seed --force

echo "→ Starting Nginx + PHP-FPM..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
