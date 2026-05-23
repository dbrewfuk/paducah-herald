# Google Analytics + AI Writing Personas

**Date:** 2026-04-10
**Status:** Draft

## Summary

Add two features to the Twill Magazine Starter:

1. **Google Analytics integration** — a GA Measurement ID field in a new Site Settings admin page; conditionally injects the gtag snippet into the public layout.
2. **AI Writing Personas** — a Twill module for creating named writer characters (e.g. "Lucy — Long-form", "Charles — News"). Each persona has a name, specialty, avatar (via Twill media library), and a freeform voice description. In the article editor, writers select a persona and either generate a new article from the title or restyle an existing draft, powered by the Claude API.

## Feature 1: Google Analytics

### What it does

- Adds a **Site Settings** page to the Twill admin sidebar (under a "Settings" nav group).
- The page has two fields:
  - **Google Analytics Measurement ID** — text input, placeholder `G-XXXXXXXXXX`.
  - **Claude API Key** — password input, placeholder `sk-ant-...`. Helper text links to console.anthropic.com.
- Both fields are stored in Twill's built-in `settings` table (no custom migration needed).
- When the GA Measurement ID is set, the public layout (`resources/views/layouts/app.blade.php`) renders the standard gtag.js snippet in `<head>`. When empty, nothing is rendered.

### Implementation approach

- Use `php artisan twill:make:settings SiteSettings` to scaffold the settings section.
- Define the form fields in the settings controller using Twill's Form builder API (`Input::make()` for GA ID, `Input::make()->type('password')` for the API key).
- Register the settings nav item in `AppServiceProvider::boot()`.
- In the Blade layout, read the setting with Twill's settings helper and conditionally render the gtag snippet.

### GA snippet structure

```blade
@php $gaId = TwillAppSettings::get('siteSettings.analytics.ga_measurement_id') @endphp
@if($gaId)
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ $gaId }}');
</script>
@endif
```

## Feature 2: AI Writing Personas

### Data model

**WritingPersona** (Twill module — `writing_personas` table):

| Field | Type | Description |
|-------|------|-------------|
| title (name) | string | The persona's name (e.g. "Lucy") |
| specialty | string | Writing style label (e.g. "Long-form", "News", "Opinion") |
| voice_description | text | Freeform prompt describing tone, style, audience, rules. Sent to Claude as the system prompt. |
| published | boolean | Standard Twill publish toggle |
| position | integer | Sort order for display in the article editor |

The persona also uses Twill's `HasMedias` trait with an `avatar` media role for the character image. Crop ratios: 1:1 default.

### Admin UI

#### Personas list page

- Standard Twill module listing at `/admin/writingPersonas`.
- Shows avatar thumbnail, name, specialty, and truncated voice description.
- Reorderable (drag to set display order in article editor).
- Nav item "Writing Personas" in the main sidebar section (not under Settings).

#### Persona editor

- **Avatar** — Twill media field (`Medias::make()->name('avatar')->label('Avatar')`). Users upload via the media library. Starter ships with a few default placeholder images.
- **Name** — text input.
- **Specialty** — text input with helper text ("e.g. News, Long-form, Opinion, Interview, Review").
- **Voice Description** — textarea. This is the core of the persona — it's sent to Claude as the system instruction when generating/restyling. Helper text: "Describe the tone, style, audience, and rules. This is sent to Claude as the writing instruction."

### Article editor integration

#### AI action bar

A custom UI component injected into the article edit form, positioned between the title field and the body field. Contains:

1. **Header** — "Writing Assistant" label with "Powered by Claude" badge.
2. **Persona cards** — grid of all published personas, each showing avatar, name, specialty tag, and a one-line description (truncated from voice_description). Clicking a card selects it (highlighted border). Only one can be selected at a time.
3. **Info bar** — appears when a persona is selected, showing a brief summary of what the selected writer will do.
4. **Action buttons** (disabled until a persona is selected):
   - **"Generate from Title"** — sends the article title + persona voice description to Claude. Claude generates a full article. The response replaces the body field content.
   - **"Restyle Draft"** — sends the article title + current body content + persona voice description to Claude. Claude rewrites the body in the persona's voice. The response replaces the body field content.

#### States

- **Normal** — persona cards shown, buttons disabled, no persona selected.
- **Persona selected** — one card highlighted, info bar visible, buttons enabled.
- **Loading** — body field hidden, replaced by a loading indicator showing the persona's avatar and "Lucy is writing your article..." text.
- **Complete** — body field reappears with Claude's output. Brief visual highlight (border flash) to signal the change.
- **No API key** — AI bar is replaced by a warning banner: "Claude API key not configured. Configure in Site Settings →" with a link to the settings page.

#### Server-side endpoint

A new route (e.g. `POST /admin/ai/generate`) that:

1. Validates the request (persona_id, action type, title, optional body).
2. Reads the Claude API key from Twill settings.
3. Loads the selected WritingPersona's voice_description.
4. Calls the Claude API:
   - **System prompt:** the persona's voice_description.
   - **User message:** for "generate", just the title with an instruction to write an article. For "restyle", the title + existing body with an instruction to rewrite in the persona's voice.
   - **Model:** `claude-sonnet-4-6` (fast, cost-effective for content generation).
5. Returns the generated text as JSON.

The endpoint is protected by Twill's admin auth middleware — only logged-in CMS users can call it.

#### Claude API integration

- Uses the Anthropic PHP SDK or direct HTTP calls to `https://api.anthropic.com/v1/messages`.
- API key read from Twill settings. The settings table stores it as plain text (Twill's default). The password-type input in the admin UI prevents casual shoulder-surfing. Full encryption at rest is out of scope for the starter but can be added by the template user if needed.
- No streaming for v1 — the full response is returned at once. Streaming can be added later if needed.
- Error handling: if the API call fails (bad key, rate limit, network error), return a user-friendly error message to the frontend.

### Technical notes

- The AI action bar is a **Vue component** injected into Twill's article form. Twill 3's form system is Vue-based, so this is the natural approach. The component will be registered as a custom form field.
- Persona cards in the article editor are loaded via an AJAX call when the form mounts (fetches published personas with their avatars).
- The body field replacement uses Twill's form field API to programmatically set the WYSIWYG/textarea value.

## What ships with the starter

- The Site Settings page with GA + Claude API key fields.
- The Writing Personas module (migration, model, controller, routes).
- The AI action bar Vue component in the article editor.
- The server-side AI generation endpoint.
- 3 example personas as a seeder (optional): a long-form writer, a news reporter, and an opinion columnist. Placeholder avatar images included in `public/img/personas/`.
- Lang strings for both `en` and `it` locales covering all new UI labels.

## Out of scope

- Streaming responses from Claude (can be added later).
- Per-user API keys (site-wide only for now).
- Prompt history / version tracking of generated content.
- Public-facing use of personas (admin-only feature).
- Image generation for avatars (users upload their own).

## Mockups

Conceptual mockups are available in `.superpowers/brainstorm/` (HTML files). These illustrate the interaction flow but not the final visual design, which will follow Twill's admin UI conventions.
