#!/usr/bin/env sh
set -eu

dnf install -y \
  php-cli \
  php-common \
  php-bcmath \
  php-curl \
  php-intl \
  php-mbstring \
  php-pdo \
  php-process \
  php-sqlite3 \
  php-xml
