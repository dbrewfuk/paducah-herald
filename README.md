# Twill Magazine Starter

Opinionated Laravel 12 + Twill 3 starter for launching a small editorial
magazine in under an hour. Ships with:

- **Laravel 12** + **Twill 3** CMS (Article module: title, hero image, WYSIWYG body, publish date)
- **Server-rendered Blade** templates — no JS framework, no build step for the front end
- **Editorial CSS** with a single brand-tokens block you can recolor in 30 seconds
- **Google Fonts** — Playfair Display (display), Source Serif 4 (body), Inter (metadata)
- **Italian locale** by default (easy to swap)
- **Full deploy recipe** for DigitalOcean + Cloudflare (Origin Cert, Full strict SSL)
- A `CLAUDE.md` with every gotcha I've hit, so the next build avoids them
- A `.claude/skills/magazine-init` skill that walks Claude Code through rebranding the starter for a new site

Built to launch [Il Giornale del Golf](https://ilgiornaledelgolf.com) in
a single afternoon. Re-used the next one takes an afternoon too, but for
a different reason: because it's that fast.

---

## Quick start (new site)

```bash
# 1. Clone the starter
gh repo create my-magazine --template you/twill-magazine-starter --private --clone
cd my-magazine

# 2. Rebrand (see "Rebranding" below, or run the magazine-init skill in Claude Code)
$EDITOR .env                # SITE_NAME, SITE_WORDMARK_*, APP_LOCALE
$EDITOR public/css/site.css # --brand-primary, --brand-accent

# 3. Ship it (see "Deploy" below)
```

---

## Local development

```bash
composer install
cp .env.example .env
php artisan key:generate
# Edit .env: set DB_CONNECTION=sqlite and touch database/database.sqlite if you prefer
php artisan migrate
php artisan twill:superadmin
php artisan serve
```

Admin: `http://localhost:8000/admin`
Public: `http://localhost:8000`

---

## Rebranding

Everything site-specific lives in **three files**:

### 1. `.env`

```env
SITE_NAME="Il Giornale del Golf"
SITE_TAGLINE="Notizie, cronaca e approfondimenti dal mondo del golf."
SITE_WORDMARK_MAIN="Il Giornale"
SITE_WORDMARK_SUB="del Golf"

APP_LOCALE=it
APP_FALLBACK_LOCALE=it
APP_FAKER_LOCALE=it_IT
```

### 2. `public/css/site.css` — brand tokens at the top

```css
:root {
    --brand-primary:      #2C5F2D; /* headers, links, nav */
    --brand-primary-dark: #1F4420; /* footer, hover */
    --brand-accent:       #FFC72C; /* highlights, rules */
    /* ... */
}
```

That's it. Every component inherits from those three colors.

### 3. `config/translatable.php` — CMS locales

```php
'locales' => ['it'],
```

**This is not automatic.** Twill creates slug rows tagged with whatever
locale is listed here, regardless of `APP_LOCALE`. If you change
`APP_LOCALE` but forget this file, the public `/articles/{slug}` route
will 404 for every article. See `CLAUDE.md` for the full story.

### 4. `lang/<locale>/site.php` — front-end strings

Ships with `en/` and `it/`. Copy either folder to add a new language.

---

## Content model

The starter ships with a single **Article** module:

| Field                | Type       | Notes                             |
|----------------------|------------|-----------------------------------|
| `title`              | string     | Also the slug source              |
| `body`               | longText   | WYSIWYG, HTML, `{!! $article->body !!}` |
| `hero` (media)       | image      | Role name `hero`, 16:9 + 1:1 crops |
| `publish_start_date` | datetime   | Sorts the homepage                |
| `published`          | bool       | Draft/published toggle            |

Add new fields in three places:

1. A migration (`database/migrations/`)
2. `app/Models/Article.php` `$fillable`
3. `app/Http/Controllers/Twill/ArticleController.php` `getForm()`

Twill 3 uses the **Form builder API in the controller**, not Blade form
files. If you see a generic "Description" text field in the admin, the
controller still has the default stub — delete that line.

---

## Deploy (DigitalOcean + Cloudflare)

The full playbook:

1. **Spin up a droplet** — Ubuntu 24.04, cheapest shared-CPU tier is fine for an editorial site.
2. **Run the provisioning script:**
   ```bash
   sudo bash deploy/provision.sh yourdomain.com
   ```
   Installs LEMP, creates DB + user, writes nginx vhost, creates deploy user, enables UFW.
3. **Clone this starter** into `/var/www/yourdomain.com` and run:
   ```bash
   composer install --no-dev --optimize-autoloader
   cp .env.example .env
   # Edit .env — DB_PASSWORD is at /root/.twill-db-password
   php artisan key:generate
   php artisan migrate --force
   php artisan twill:superadmin
   php artisan config:cache route:cache view:cache
   ```
4. **Cloudflare DNS + Origin Cert** — see `deploy/cloudflare-origin-cert.md`.
5. **Reload nginx** — `sudo nginx -t && sudo systemctl reload nginx`.
6. **Smoke test** — `curl -sI https://yourdomain.com/` should return `200`.

End-to-end TLS. No certbot cron. 15-year origin cert.

---

## What's in the box

```
.
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php        # Public home
│   │   ├── ArticleController.php     # Public article detail
│   │   └── Twill/ArticleController.php  # CMS article admin (Form builder API)
│   ├── Models/Article.php            # HasSlug + HasMedias + mediasParams
│   └── Providers/AppServiceProvider.php  # Registers Articles nav link
├── config/
│   ├── site.php                      # .env-backed site identity
│   ├── translatable.php              # CMS locales (MUST match APP_LOCALE)
│   └── twill.php
├── database/migrations/              # articles + article_slugs tables
├── lang/
│   ├── en/site.php
│   └── it/site.php
├── public/css/site.css               # All front-end styles, brand tokens at top
├── resources/views/
│   ├── layouts/app.blade.php         # Google Fonts + header/footer
│   ├── home.blade.php                # Featured + 3-col grid
│   ├── article.blade.php             # Detail page (drop cap, blockquote styling)
│   └── twill/articles/form.blade.php # (fallback — controller Form builder wins)
├── routes/
│   ├── web.php                       # /, /articles/{slug}
│   └── twill.php                     # /admin/articles
├── deploy/
│   ├── nginx.conf.template
│   ├── provision.sh
│   └── cloudflare-origin-cert.md
├── .claude/skills/magazine-init/     # Claude Code rebrand skill
├── CLAUDE.md                         # Conventions + gotchas for AI pair sessions
└── README.md                         # You are here
```

---

## License

MIT. Do whatever you want.
