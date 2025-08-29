#!/bin/sh
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=$PORT
