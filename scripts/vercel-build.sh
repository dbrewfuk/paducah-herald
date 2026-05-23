#!/usr/bin/env sh
set -eu

cp .env.vercel .env

# Inject Stripe credentials from Vercel project environment variables (PHP handles special chars)
php -r "
\$env = file_get_contents('.env');
\$env = str_replace('__STRIPE_KEY__',    getenv('STRIPE_KEY')    ?: '', \$env);
\$env = str_replace('__STRIPE_SECRET__', getenv('STRIPE_SECRET') ?: '', \$env);
\$env = str_replace('__STRIPE_PRICE__',  getenv('STRIPE_PRICE')  ?: '', \$env);
file_put_contents('.env', \$env);
"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=/tmp --filename=composer
rm composer-setup.php
/tmp/composer install --no-dev --optimize-autoloader --ignore-platform-reqs
php artisan config:clear
php artisan view:clear
