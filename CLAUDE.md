# CLAUDE.md — Twill Magazine Starter

Conventions and hard-won gotchas for Claude Code sessions working in this
starter. Read this before you touch anything.

## Stack

- **PHP 8.3** (the droplet runs `php8.3-fpm`; don't assume 8.4+ features)
- **Laravel 12** — Laravel 13 is not compatible with Twill 3 yet. Do not upgrade.
- **Twill 3** (`area17/twill:^3.0`) — CMS layer
- **MySQL 8** in production, SQLite fine for local dev
- **nginx 1.24** on Ubuntu 24.04
- **Cloudflare** in front, **Full (strict)** SSL mode, **Origin Certificate** (15-year)
- **Server-rendered Blade**, no Vite/React/Vue for the public site

## Known gotchas (each cost hours to discover)

### 1. `config/translatable.php` MUST match `APP_LOCALE`

Twill writes `article_slugs` rows with `locale = <translatable.locales[0]>`,
**not** `APP_LOCALE`. If they don't match, the public `ArticleController::show`
route does `Article::forSlug($slug)->first()` which filters by the *app*
locale and returns `null`, resulting in a 404 on every article page.

**Fix:** when you change `APP_LOCALE=it` in `.env`, also set
`'locales' => ['it']` in `config/translatable.php`. Then existing slug
rows need migration:

```php
DB::table('article_slugs')->where('locale', 'en')->update(['locale' => 'it', 'active' => 1]);
DB::table('article_slugs')->where('locale', 'it')->where('active', 0)->delete();
```

### 2. `forSlug()` returns a query builder, not a model

`Article::forSlug($slug)` returns an Eloquent builder. You **must** call
`->first()` to materialize it. Forgetting this throws:

> Property [published] does not exist on the Eloquent builder instance.

Wrong: `$article = Article::forSlug($slug); if (! $article->published) ...`

Right: `$article = Article::forSlug($slug)->first();`

### 3. Laravel 12 reads locale from `.env`, not `config/app.php`

Don't edit `config/app.php` to change locale. Laravel 12 uses
`env('APP_LOCALE', 'en')` at the default. Set it in `.env`:

```env
APP_LOCALE=it
APP_FALLBACK_LOCALE=it
APP_FAKER_LOCALE=it_IT
```

Then `php artisan config:clear && php artisan config:cache`.

### 4. Twill 3 uses a Form builder API in controllers, NOT Blade form files

When you run `php artisan twill:make:module Article`, Twill generates a
controller with a `getForm()` method that adds an `Input` for `description`.
It does **not** generate a form Blade file by default.

Adding form fields via `resources/views/twill/articles/form.blade.php`
has no effect — the controller's `getForm()` wins.

The right way:

```php
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fields\Wysiwyg;

public function getForm(TwillModelContract $model): Form
{
    $form = parent::getForm($model);

    $form->add(Medias::make()->name('hero')->label('Hero image'));
    $form->add(Wysiwyg::make()->name('body')->label('Body'));

    return $form;
}
```

And in the Article model you need matching fillable + `$mediasParams`:

```php
protected $fillable = ['published', 'title', 'body', 'publish_start_date'];

public $mediasParams = [
    'hero' => [
        'default' => [['name' => 'default', 'ratio' => 16 / 9]],
        'mobile'  => [['name' => 'mobile',  'ratio' => 1]],
    ],
];
```

### 5. nginx `http2 on;` directive is rejected on some Ubuntu 24.04 builds

The Laravel docs show:

```nginx
listen 443 ssl;
http2 on;
```

That fails `nginx -t` on the stock Ubuntu 24.04 nginx 1.24 build:

> nginx: [emerg] unknown directive "http2"

**Use the old syntax instead:**

```nginx
listen 443 ssl http2;
```

The vhost template in `deploy/nginx.conf.template` already does this.

### 6. Italian ISP DNS hijacking (Fastweb, etc.)

If an Italian user reports "can't provide a secure connection" after a
nameserver change, it's almost always their ISP's DNS cache or router
intercepting port 53. Solutions, in order:

1. Enable DNS-over-HTTPS in their browser (Chrome: Settings → Privacy → Security → Use secure DNS → Cloudflare)
2. Install the 1.1.1.1 app from the Mac App Store (OS-level DoH)
3. Wait (a few hours, up to 24)

It's **not** a server problem — curl from anywhere will confirm the site is fine.

### 7. Laravel 12 strips the base `app/Http/Controllers/Controller.php`

Laravel 12's default skeleton doesn't ship with a base Controller class.
`HomeController extends Controller` will break unless you create it:

```php
<?php
namespace App\Http\Controllers;
abstract class Controller {}
```

The starter already includes this file. Don't delete it.

### 8. File permissions when deploying as `deploy` user

`mv` preserves 644 perms, which is readable to `www-data`, so normal file
moves work. But if you ever `chmod 600` something by accident, nginx will
return 403 for that file. Keep views/assets at 644, dirs at 755, and
`storage/` + `bootstrap/cache/` at 775 owned by `deploy:www-data`.

## Working in this repo as Claude

### SSH workflow to the droplet

The user has SSH key auth set up as `deploy@<droplet-ip>`. To make changes
on the droplet:

1. Write files **locally** in the starter repo or to `/tmp/<something>/`.
2. `scp` them up to `/tmp/` on the droplet.
3. SSH in and `mv` them into place.
4. Run `php artisan config:clear && route:clear && view:clear`, then
   re-cache if production mode.

Do **not** try to heredoc complex files through `ssh … '<<EOF'` — escaping
PHP, Blade, and bash all at once is a nightmare.

### Prompt checklists for common operations

- **New Twill module:**
  - `php artisan twill:make:module <ModelName>`
  - Edit the migration (rename `description` → whatever, uncomment `publish_start_date`)
  - Rewrite `getForm()` in the controller using Form builder fields
  - Update the Model `$fillable` + `$mediasParams`
  - Add nav link in `AppServiceProvider::boot()`
  - Run migrations, clear caches, smoke test in `/admin`

- **New public route:**
  - Add to `routes/web.php`
  - Create the controller (extends `App\Http\Controllers\Controller`)
  - Create the Blade view in `resources/views/`
  - `php artisan route:clear && route:cache`

- **Rebrand for a new site:**
  - Run the `.claude/skills/magazine-init` skill, or
  - Edit `.env` (SITE_*, APP_LOCALE), `public/css/site.css` (brand tokens),
    `config/translatable.php` (locales), and add new `lang/<locale>/site.php`

## Anti-goals

- Don't add a JS framework to the public site. Blade + a single CSS file is the entire point.
- Don't add Vite to the public assets pipeline. `public/css/site.css` is served as-is.
- Don't upgrade Laravel past 12 until Twill 3 explicitly supports it.
- Don't add Redis, Horizon, or a separate queue worker unless there's a real need — sessions/cache/queue all default to the database driver, which is fine for an editorial site.
- Don't add Let's Encrypt / certbot. The Cloudflare Origin Cert is the answer.
