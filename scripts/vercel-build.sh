#!/usr/bin/env sh
set -eu

cp .env.vercel .env

# Inject Stripe credentials from Vercel project environment variables
sed -i "s|__STRIPE_KEY__|${STRIPE_KEY:-}|g"     .env
sed -i "s|__STRIPE_SECRET__|${STRIPE_SECRET:-}|g" .env
sed -i "s|__STRIPE_PRICE__|${STRIPE_PRICE:-}|g"   .env
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=/tmp --filename=composer
rm composer-setup.php
/tmp/composer install --no-dev --optimize-autoloader --ignore-platform-reqs
php artisan config:clear
php artisan view:clear
