# Production Server Fix - Quick Commands for Hosting Control Panel

Run these commands via SSH on your Hostinger/production server:

## Quick Fix (Copy & Paste):

```bash
cd ~/websites/rZAXlsj79/public_html

# Step 1: Remove old cache
rm -rf bootstrap/cache/*

# Step 2: Regenerate autoloader
composer dump-autoload -o

# Step 3: Clear everything
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Step 4: Regenerate optimized cache
php artisan config:cache
php artisan route:cache

# Step 5: Test
php artisan list | head -1 && echo "✓ Success! App is working"
```

## More Complete Fix (if above doesn't work):

```bash
cd ~/websites/rZAXlsj79/public_html

# 1. Kill any stuck processes
pkill -f 'php artisan queue' || true

# 2. Backup cache
mkdir -p backups
cp -r bootstrap/cache backups/cache-backup-$(date +%s) || true

# 3. Clean everything
rm -rf bootstrap/cache/*
mkdir -p bootstrap/cache

# 4. Regenerate
composer dump-autoload -o
php artisan config:cache
php artisan route:cache  
php artisan cache:clear

# 5. Set permissions
chmod -R 755 bootstrap/cache
chmod -R 755 storage

# 6. Verify
php artisan tinker --execute="echo 'App working!';"
```

## Troubleshooting

If you still get "Target class [cache] does not exist":

```bash
cd ~/websites/rZAXlsj79/public_html

# Check your .env file has these critical variables:
cat .env | grep -E "APP_NAME|APP_KEY|DB_"

# Make sure cache driver is correct
grep CACHE_DRIVER .env

# Try rebuilding from scratch
rm bootstrap/cache/*
php -r "require 'vendor/autoload.php'; require 'bootstrap/app.php';" 2>&1 | head -10

# If that fails, check PHP version
php -v

# And check permissions
ls -la bootstrap/cache/
ls -la storage/
```

## Key Points

- Bootstrap cache files are auto-generated (not in Git)
- They must exist on production server
- The file `bootstrap/cache/services.php` is critical
- If permissions are wrong, cache can't be created

## Final Check

Visit: https://www.sharjaharchitecture.org

If it shows the website, the fix worked!
If still 500 error, check server error logs:
- /home/u367625671/logs/error_log
- Or use hosting control panel to view error logs
