# Cloudflare Origin Certificate

End-to-end TLS between Cloudflare and your droplet using a **15-year
Cloudflare Origin Certificate** + **Full (strict)** SSL mode. No certbot,
no auto-renewal cron, no Let's Encrypt rate limits.

## One-time setup per site

### 1. Add the domain to Cloudflare

- Cloudflare Dashboard → Add site → enter bare domain
- Choose Free plan
- Cloudflare lists the existing DNS records it detected — review them
- Cloudflare gives you two nameservers like `arely.ns.cloudflare.com`

### 2. Change nameservers at your registrar

Log into whoever manages the domain (GoDaddy, Hostinger, Namecheap, etc.)
and replace the nameservers with the two Cloudflare gave you. Propagation
can take a few hours up to 24h depending on the TLD.

Verify with:

```bash
dig NS yourdomain.com +short
```

### 3. Set SSL mode to "Full (strict)"

Cloudflare → SSL/TLS → Overview → **Full (strict)**

> Do NOT use "Flexible" — that terminates TLS at Cloudflare and sends
> plain HTTP to your origin. Full (strict) is the only safe option.

### 4. Generate an Origin Certificate

Cloudflare → SSL/TLS → Origin Server → **Create Certificate**

- Key type: RSA (2048)
- Hostnames: `yourdomain.com, *.yourdomain.com`
- Validity: **15 years**
- Click Create

You'll be shown the certificate and private key **once**. Copy both.

### 5. Install on the droplet

```bash
sudo mkdir -p /etc/ssl/cloudflare
sudo nano /etc/ssl/cloudflare/yourdomain.com.pem   # paste certificate
sudo nano /etc/ssl/cloudflare/yourdomain.com.key   # paste private key
sudo chmod 644 /etc/ssl/cloudflare/yourdomain.com.pem
sudo chmod 600 /etc/ssl/cloudflare/yourdomain.com.key
sudo chown root:root /etc/ssl/cloudflare/yourdomain.com.*
```

### 6. Reload nginx

```bash
sudo nginx -t && sudo systemctl reload nginx
```

### 7. Verify

```bash
curl -sI https://yourdomain.com/ | head -3
# HTTP/2 200
# server: cloudflare
```

## Gotchas

- **`http2 on;` directive** — some Ubuntu 24.04 nginx builds reject the
  newer `http2 on;` directive. The vhost template uses the older
  `listen 443 ssl http2;` syntax instead. If you switch, test with
  `nginx -t` first.

- **DNS propagation** — some ISPs (notably Fastweb in Italy) aggressively
  cache DNS and also hijack port 53 queries. If a user in a specific
  region can't load the site, have them use a browser with DNS-over-HTTPS
  enabled or install the 1.1.1.1 app.

- **A records must be proxied** — in Cloudflare DNS, the A record for
  your domain must have the orange cloud enabled (proxied) for the origin
  cert to be in the handshake path.

- **Preserve MX, TXT, autoconfig records** when switching nameservers if
  email is hosted elsewhere (e.g. Hostinger, Google Workspace).
