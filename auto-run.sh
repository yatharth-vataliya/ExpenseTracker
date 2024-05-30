composer install --optimize-autoloader --no-dev;

composer run-script clearAllCache;

php artisan migrate;

php artisan config:cache;

php artisan event:cache;

php artisan route:cache;

php artisan view:cache;

bun install;

bun run build;
