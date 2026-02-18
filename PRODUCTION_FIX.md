# Production Fix for "Target class [cache] does not exist"

The error occurs because bootstrap/cache files are missing or corrupted on the production server.

## Fix Steps (Run on Production Server):

```bash
# 1. Remove corrupted cache files
rm -rf bootstrap/cache/*

# 2. Recreate the cache directory
mkdir -p bootstrap/cache
touch bootstrap/cache/.gitkeep

# 3. Verify .env file exists and is readable
ls -la .env

# 4. Clear application cache without using the cache (use file operations)
cd bootstrap/cache && rm -f *.php && cd ../..

# 5. Run composer dump-autoload to regenerate autoloader
composer dump-autoload -o

# 6. Now you can safely run config and cache clear
php artisan config:clear
php artisan cache:clear

# 7. Test the application
php artisan route:list | head -5

# 8. Regenerate cache if production
php artisan config:cache
php artisan route:cache
```

## What was the issue?

- The `.gitignore` was recently updated to exclude `bootstrap/cache/*` files
- These files are auto-generated when the application runs
- If the production server didn't have these files, or they got corrupted, the Container couldn't find the 'cache' service binding
- Running `php artisan config:clear` before any cache files exist causes the error

## Prevention:

The bootstrap/cache files should NEVER be committed to Git (they're auto-generated).
They need to exist on the production server - they're created by running:
- `php artisan config:cache` (generates services.php, packages.php)
- `php artisan route:cache` (generates routes-v7.php)
