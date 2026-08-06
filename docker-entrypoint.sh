#!/bin/sh

cd /var/www/html

php artisan migrate --force

php artisan optimize

chmod -R 755 storage bootstrap/cache

exit 0
