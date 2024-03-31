git pull;

composer install --optimize-autoloader --no-dev

php artisan migrate;

php artisan config:cache;

php artisan event:cache;

php artisan route:cache;

php artisan view:cache;

npm install;

npm run build;