#!/bin/bash
set -e

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan db:seed --force

# Roda o scheduler a cada minuto em background
(while true; do php artisan schedule:run >> /dev/null 2>&1; sleep 60; done) &

apache2-foreground
