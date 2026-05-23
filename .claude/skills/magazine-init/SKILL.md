---
name: magazine-init
description: Rebrand the Twill Magazine Starter for a new site. Use when the user has just cloned this starter and wants to turn it into a specific publication — asks for help "setting up a new magazine", "rebranding", "changing the colors/name/language", or says something like "this is for <publication name>".
---

# magazine-init

Walk the user through turning this starter into a specific, named publication.
The starter ships with placeholder values in every site-specific location, and
this skill's job is to replace them in a consistent, low-friction way.

## When to trigger

Activate this skill when any of these are true:

- The user just cloned the starter and is setting up a new site
- The user mentions rebranding, recoloring, renaming, or changing languages
- The user gives you the name of a publication and wants to "make it that"
- `.env` still contains `SITE_NAME="Magazine"` (the starter default)

## Required information

Before editing anything, gather these from the user. Ask all at once in a
single question block, not one-by-one — they're fast to answer together.

1. **Publication name** — the full name shown in `<title>` and footer (e.g. `Il Giornale del Golf`)
2. **Tagline** — one-sentence description for `<meta description>`
3. **Wordmark** — how the header should display. The starter uses two lines: a primary word and an italic secondary word. Examples:
   - `Il Giornale` / `del Golf`
   - `The` / `Offhand`
   - `Field` / `Notes`
   If they only want one line, put the whole name in `main` and leave `sub` empty.
4. **Language** — ISO code (`en`, `it`, `fr`, `es`, ...). If not English or Italian, you'll need to create a new `lang/<locale>/site.php`.
5. **Brand colors** — primary, accent, and (optional) primary-dark. Accept hex codes. If they don't have specific colors, offer to pick a palette (use the `color-expert` skill if available) or stick with the Augusta defaults.
6. **Domain** — the production domain (e.g. `ilgiornaledelgolf.com`). Used for `APP_URL` and the deploy notes.

## Execution checklist

Once you have answers, make these edits. Each step is a single Edit tool call:

### 1. `.env` (and `.env.example` if they want the defaults to change)

Update these keys with the user's values:

```env
APP_NAME="<publication name>"
APP_URL=https://<domain>
APP_LOCALE=<locale>
APP_FALLBACK_LOCALE=<locale>
APP_FAKER_LOCALE=<locale>_<COUNTRY>

SITE_NAME="<publication name>"
SITE_TAGLINE="<tagline>"
SITE_WORDMARK_MAIN="<wordmark main>"
SITE_WORDMARK_SUB="<wordmark sub>"
```

If `.env` doesn't exist yet, `cp .env.example .env` first.

### 2. `config/translatable.php`

Critical — this MUST match `APP_LOCALE` or every article page will 404.
See CLAUDE.md §1.

```php
'locales' => ['<locale>'],
```

### 3. `public/css/site.css`

Replace the three brand-token values in the `:root` block at the top of
the file. Don't touch anything else — every component inherits from these.

```css
--brand-primary:      <primary hex>;
--brand-primary-dark: <primary-dark hex>;
--brand-accent:       <accent hex>;
```

If the user didn't give a primary-dark, derive it by darkening the primary
by ~15% manually (or just use the same value as primary).

### 4. `lang/<locale>/site.php` + `lang/<locale>/twill.php`

If the locale is `en` or `it`, these already exist — nothing to do.

Otherwise, copy `lang/en/site.php` and `lang/en/twill.php` to
`lang/<locale>/` and translate the values. The keys must remain identical.

Required keys in `site.php`:

- `featured`
- `more_articles`
- `article`
- `back_to_home`
- `empty_state`
- `rights_reserved`

Required keys in `twill.php`:

- `nav.articles`

### 5. `composer.json`

Update `name` from `you/twill-magazine-starter` to something project-specific
like `<user>/<publication-slug>`.

### 6. Clear config cache if running locally

```bash
php artisan config:clear
php artisan view:clear
```

## What NOT to touch

- Don't edit any Blade templates unless the user specifically asks — they're
  already abstracted via `config('site.*')` and `__('site.*')`.
- Don't edit any controllers.
- Don't touch `composer.lock` — the pinned versions are deliberate.
- Don't rename CSS classes. The CSS is written with generic class names
  (`site-header`, `article-card`, etc.) on purpose.
- Don't add JS libraries, Vite config, or Tailwind. The starter is
  deliberately Blade + a single CSS file.

## Verification

After all edits, run through this checklist with the user:

1. Does `grep -rn "Magazine" .env` show only the new name?
2. Does `grep -n "brand-primary" public/css/site.css` show the new color?
3. Does `grep -n "'locales'" config/translatable.php` match `APP_LOCALE`?
4. If new locale: do `lang/<locale>/site.php` and `lang/<locale>/twill.php` exist with all required keys?

If running locally: `php artisan serve` → visit `/` → confirm the header
shows the new wordmark and the colors are applied.

## Follow-up suggestions

After rebranding is done, offer these as next steps:

- "Want me to generate a first article in the CMS so you can see it live?"
- "Want me to run through the deploy playbook for a new DigitalOcean droplet?"
- "Want me to add a second content type (reviews, interviews, photo galleries)?"
- "Want a second language added now, or later?"
