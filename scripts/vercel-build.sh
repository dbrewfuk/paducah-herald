#!/usr/bin/env sh
set -eu

cp .env.vercel .env
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=/tmp --filename=composer
rm composer-setup.php
/tmp/composer install --no-dev --optimize-autoloader
php artisan config:clear
php artisan view:clear
