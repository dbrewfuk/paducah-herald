#!/usr/bin/env sh
set -eu

dnf install -y \
  php-cli \
  php-common \
  php-bcmath \
  php-curl \
  php-gmp \
  php-intl \
  php-mbstring \
  php-pdo \
  php-process \
  php-soap \
  php-sqlite3 \
  php-sockets \
  php-xml \
  php-zip
