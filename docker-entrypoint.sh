#!/bin/bash
set -e

# Use PORT from Render (default 10000)
PORT=${PORT:-10000}

# Update Apache to listen on the correct port
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/*.conf

# Run Laravel optimizations
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

# Run migrations if DB is configured
php artisan migrate --force 2>/dev/null || echo "Migration skipped (no DB connection)"

exec "$@"
