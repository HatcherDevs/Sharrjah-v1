#!/bin/bash
# ============================================================
#  Deploy v10 — Pull, Clear Cache, Reset to HEAD, Re-cache
# ============================================================

# 1. Pull latest v10
# git checkout v10
# git fetch origin
git pull origin v10

# 2. Clear all Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# 3. Reset to HEAD (discard any local changes)
git reset --hard HEAD
# git clean -fd

# 4. Pull again (ensure up to date after reset)
git pull origin v10

# 5. Install/update composer dependencies (no dev)
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 6. Re-cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "✅ Deploy done."
