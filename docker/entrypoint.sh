#!/bin/sh
# =============================================
# Higertech — Docker Entrypoint
# =============================================
# Dijalankan setiap kali container start.
# Memastikan direktori storage, symlink, dan permission siap.

set -e

echo "[entrypoint] Ensuring storage directories exist..."
mkdir -p /var/www/html/storage/app/public/articles \
         /var/www/html/storage/app/public/products \
         /var/www/html/storage/app/public/products/brochures \
         /var/www/html/storage/app/public/tutorials \
         /var/www/html/storage/app/public/tutorials/documents \
         /var/www/html/storage/app/private \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs

echo "[entrypoint] Fixing storage permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "[entrypoint] Ensuring storage symlink..."
if [ ! -L /var/www/html/public/storage ]; then
    php artisan storage:link --force 2>/dev/null || ln -sf /var/www/html/storage/app/public /var/www/html/public/storage
    echo "[entrypoint] Storage symlink created."
else
    echo "[entrypoint] Storage symlink already exists."
fi

echo "[entrypoint] Ready. Starting: $@"
exec "$@"
