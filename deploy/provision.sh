#!/usr/bin/env bash
# ==============================================================================
# provision.sh — bootstrap a fresh Ubuntu 24.04 droplet for Twill Magazine
# ------------------------------------------------------------------------------
# Run as root on a fresh DigitalOcean Ubuntu 24.04 droplet:
#
#     curl -fsSL https://raw.githubusercontent.com/<you>/twill-magazine-starter/main/deploy/provision.sh | bash -s -- example.com
#
# Or copy the repo up first and run:
#
#     sudo bash deploy/provision.sh example.com
#
# Arguments:
#   $1 — bare domain (no www, no https)
#
# This script is idempotent-ish — you can re-run it, but review the output.
# ==============================================================================
set -euo pipefail

DOMAIN="${1:-}"
if [[ -z "$DOMAIN" ]]; then
    echo "Usage: provision.sh <domain>"
    echo "Example: provision.sh example.com"
    exit 1
fi

APP_DIR="/var/www/$DOMAIN"
DEPLOY_USER="deploy"

echo "==> Provisioning $DOMAIN into $APP_DIR"

# ---------- 1. System packages ----------
echo "==> Installing LEMP stack"
export DEBIAN_FRONTEND=noninteractive
apt-get update
apt-get install -y \
    nginx \
    mysql-server \
    php8.3 php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring php8.3-xml \
    php8.3-curl php8.3-zip php8.3-gd php8.3-bcmath php8.3-intl \
    composer \
    git curl unzip ufw

# ---------- 2. Deploy user ----------
if ! id "$DEPLOY_USER" &>/dev/null; then
    echo "==> Creating $DEPLOY_USER user"
    adduser --disabled-password --gecos "" "$DEPLOY_USER"
    usermod -aG www-data "$DEPLOY_USER"
    mkdir -p "/home/$DEPLOY_USER/.ssh"
    if [[ -f /root/.ssh/authorized_keys ]]; then
        cp /root/.ssh/authorized_keys "/home/$DEPLOY_USER/.ssh/authorized_keys"
    fi
    chown -R "$DEPLOY_USER:$DEPLOY_USER" "/home/$DEPLOY_USER/.ssh"
    chmod 700 "/home/$DEPLOY_USER/.ssh"
    chmod 600 "/home/$DEPLOY_USER/.ssh/authorized_keys" || true
fi

# ---------- 3. Database ----------
DB_NAME="twill"
DB_USER="twill"
DB_PASS_FILE="/root/.twill-db-password"
if [[ ! -f "$DB_PASS_FILE" ]]; then
    echo "==> Creating MySQL database + user"
    DB_PASS=$(openssl rand -base64 24 | tr -d '/+=' | head -c 32)
    echo "$DB_PASS" > "$DB_PASS_FILE"
    chmod 600 "$DB_PASS_FILE"
    mysql <<SQL
CREATE DATABASE IF NOT EXISTS \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
ALTER USER '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
SQL
    echo "    DB password written to $DB_PASS_FILE"
else
    DB_PASS=$(cat "$DB_PASS_FILE")
    echo "==> Reusing existing DB password from $DB_PASS_FILE"
fi

# ---------- 4. App directory ----------
if [[ ! -d "$APP_DIR" ]]; then
    echo "==> Creating $APP_DIR"
    mkdir -p "$APP_DIR"
    chown -R "$DEPLOY_USER:www-data" "$APP_DIR"
fi

# ---------- 5. nginx vhost ----------
VHOST_SRC="$(dirname "$0")/nginx.conf.template"
VHOST_DEST="/etc/nginx/sites-available/$DOMAIN"
if [[ ! -f "$VHOST_DEST" ]]; then
    echo "==> Installing nginx vhost for $DOMAIN"
    sed "s/{{DOMAIN}}/$DOMAIN/g" "$VHOST_SRC" > "$VHOST_DEST"
    ln -sf "$VHOST_DEST" "/etc/nginx/sites-enabled/$DOMAIN"
    [[ -f /etc/nginx/sites-enabled/default ]] && rm /etc/nginx/sites-enabled/default
    echo "    (!) Install Cloudflare Origin Cert at /etc/ssl/cloudflare/$DOMAIN.{pem,key}"
    echo "    (!) Then run: nginx -t && systemctl reload nginx"
fi

# ---------- 6. Firewall ----------
echo "==> Configuring UFW"
ufw allow OpenSSH
ufw allow 'Nginx Full'
ufw --force enable

echo ""
echo "=================================================================="
echo "  Provisioning complete for $DOMAIN"
echo "=================================================================="
echo ""
echo "Next steps (run as $DEPLOY_USER):"
echo ""
echo "  1. Clone this starter into $APP_DIR:"
echo "       sudo -u $DEPLOY_USER git clone <your-repo> $APP_DIR"
echo ""
echo "  2. Install and configure:"
echo "       cd $APP_DIR"
echo "       composer install --no-dev --optimize-autoloader"
echo "       cp .env.example .env"
echo "       # Edit .env with APP_URL, SITE_NAME, DB_PASSWORD (from $DB_PASS_FILE)"
echo "       php artisan key:generate"
echo "       php artisan migrate --force"
echo "       php artisan twill:superadmin"
echo "       php artisan config:cache route:cache view:cache"
echo ""
echo "  3. Install Cloudflare Origin Cert, then reload nginx:"
echo "       sudo mkdir -p /etc/ssl/cloudflare"
echo "       sudo nano /etc/ssl/cloudflare/$DOMAIN.pem   # paste cert"
echo "       sudo nano /etc/ssl/cloudflare/$DOMAIN.key   # paste key"
echo "       sudo chmod 644 /etc/ssl/cloudflare/$DOMAIN.pem"
echo "       sudo chmod 600 /etc/ssl/cloudflare/$DOMAIN.key"
echo "       sudo nginx -t && sudo systemctl reload nginx"
echo ""
echo "DB credentials saved at: $DB_PASS_FILE"
echo ""
