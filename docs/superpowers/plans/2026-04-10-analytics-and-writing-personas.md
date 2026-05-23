# Google Analytics + AI Writing Personas Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add configurable Google Analytics tracking and AI-powered writing personas to the Twill Magazine Starter.

**Architecture:** Two independent features sharing a Site Settings page. GA is a Blade conditional in the layout. Writing Personas is a full Twill module with a custom Vue component in the article editor that calls a server-side endpoint wrapping the Claude API.

**Tech Stack:** Laravel 12, Twill 3 (settings + modules), Anthropic PHP SDK, Vue.js (Twill admin), Blade

---

## File Structure

### New files

| File | Responsibility |
|------|---------------|
| `resources/views/twill/settings/siteSettings/analytics.blade.php` | GA + Claude API key settings form |
| `database/migrations/YYYY_MM_DD_create_writing_personas_tables.php` | WritingPersona schema |
| `app/Models/WritingPersona.php` | Persona model with HasMedias |
| `app/Repositories/WritingPersonaRepository.php` | Persona repository |
| `app/Http/Controllers/Twill/WritingPersonaController.php` | Persona admin CRUD |
| `app/Http/Requests/Twill/WritingPersonaRequest.php` | Persona validation |
| `app/Http/Controllers/Twill/AiGenerateController.php` | Claude API endpoint |
| `resources/assets/js/components/WritingAssistant.vue` | AI action bar Vue component |
| `lang/en/twill.php` | Updated with new nav labels |
| `lang/it/twill.php` | Updated with new nav labels |

### Modified files

| File | Change |
|------|--------|
| `app/Providers/AppServiceProvider.php` | Register settings group + personas nav |
| `resources/views/layouts/app.blade.php` | Conditional GA snippet in `<head>` |
| `routes/twill.php` | Add personas module + AI endpoint route |
| `composer.json` | Add `anthropic-ai/sdk` dependency |
| `app/Http/Controllers/Twill/ArticleController.php` | Inject WritingAssistant into article form |

---

## Task 1: Site Settings — Google Analytics

**Files:**
- Create: `resources/views/twill/settings/siteSettings/analytics.blade.php`
- Modify: `app/Providers/AppServiceProvider.php`
- Modify: `resources/views/layouts/app.blade.php`

- [ ] **Step 1: Create the settings Blade template**

Create `resources/views/twill/settings/siteSettings/analytics.blade.php`:

```blade
@twillBlockTitle('Analytics & API Keys')
@twillBlockIcon('settings')

<x-twill::input
    name="ga_measurement_id"
    label="Google Analytics Measurement ID"
    placeholder="G-XXXXXXXXXX"
    :note="'Leave empty to disable tracking. Find your ID in Google Analytics → Admin → Data Streams.'"
/>

<x-twill::input
    name="claude_api_key"
    label="Claude API Key"
    type="password"
    placeholder="sk-ant-..."
    :note="'Required for AI writing features. Get your key at console.anthropic.com.'"
/>
```

- [ ] **Step 2: Register the settings group in AppServiceProvider**

Modify `app/Providers/AppServiceProvider.php`. Add these imports at the top:

```php
use A17\Twill\Facades\TwillAppSettings;
use A17\Twill\Services\Settings\SettingsGroup;
```

Add this inside the `boot()` method, before the existing `TwillNavigation::addLink` call:

```php
TwillAppSettings::registerSettingsGroup(
    SettingsGroup::make()
        ->name('siteSettings')
        ->label('Site Settings')
);
```

- [ ] **Step 3: Add the GA snippet to the public layout**

Modify `resources/views/layouts/app.blade.php`. Add this block immediately after the opening `<head>` tag and before the existing `<meta charset>`:

```blade
@php
    $gaId = null;
    try {
        $gaId = \A17\Twill\Facades\TwillAppSettings::get('siteSettings.analytics.ga_measurement_id');
    } catch (\Throwable $e) {}
@endphp
@if($gaId)
<script async src="https://www.googletagmanager.com/gtag/js?id={{ e($gaId) }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ e($gaId) }}');
</script>
@endif
```

The `try/catch` handles the case where the settings table hasn't been seeded yet (fresh install).

- [ ] **Step 4: Clear caches and smoke test**

Run:
```bash
cd /Users/new/Desktop/twill-magazine-starter
php artisan config:clear && php artisan route:clear && php artisan view:clear
php artisan serve &
```

Test:
1. Visit `/admin` → "Site Settings" should appear in sidebar
2. Enter a test GA ID like `G-TEST123`, save
3. Visit the public homepage → view page source → confirm the gtag snippet is present with `G-TEST123`
4. Clear the GA ID, save → confirm the snippet is gone from the public site

- [ ] **Step 5: Commit**

```bash
git add resources/views/twill/settings/siteSettings/analytics.blade.php app/Providers/AppServiceProvider.php resources/views/layouts/app.blade.php
git commit -m "feat: add Site Settings page with Google Analytics integration"
```

---

## Task 2: Writing Personas — Twill Module

**Files:**
- Create: migration, model, repository, controller, request (via artisan)
- Modify: `app/Providers/AppServiceProvider.php`
- Modify: `routes/twill.php`
- Modify: `lang/en/twill.php`
- Modify: `lang/it/twill.php`

- [ ] **Step 1: Generate the module scaffold**

```bash
cd /Users/new/Desktop/twill-magazine-starter
php artisan twill:make:module WritingPersona --hasMedias --hasPosition
```

This creates:
- `database/migrations/..._create_writing_personas_tables.php`
- `app/Models/WritingPersona.php`
- `app/Repositories/WritingPersonaRepository.php`
- `app/Http/Controllers/Twill/WritingPersonaController.php`
- `app/Http/Requests/Twill/WritingPersonaRequest.php`

- [ ] **Step 2: Edit the migration**

Open the generated migration in `database/migrations/` (the file ending in `_create_writing_personas_tables.php`). Replace the `up()` method contents with:

```php
public function up(): void
{
    Schema::create('writing_personas', function (Blueprint $table) {
        createDefaultTableFields($table);

        $table->string('title', 200);
        $table->string('specialty', 100);
        $table->text('voice_description');
        $table->integer('position')->unsigned()->default(0);
    });
}
```

Remove the slugs table creation if the scaffold generated one — personas don't need slugs.

- [ ] **Step 3: Edit the model**

Replace the contents of `app/Models/WritingPersona.php` with:

```php
<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Model;

class WritingPersona extends Model
{
    use HasMedias, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'specialty',
        'voice_description',
        'position',
    ];

    public $mediasParams = [
        'avatar' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
        ],
    ];
}
```

- [ ] **Step 4: Edit the repository**

Replace the contents of `app/Repositories/WritingPersonaRepository.php` with:

```php
<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\WritingPersona;

class WritingPersonaRepository extends ModuleRepository
{
    use HandleMedias;

    public function __construct(WritingPersona $model)
    {
        $this->model = $model;
    }
}
```

- [ ] **Step 5: Edit the controller**

Replace the contents of `app/Http/Controllers/Twill/WritingPersonaController.php` with:

```php
<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Forms\Form;

class WritingPersonaController extends ModuleController
{
    protected $moduleName = 'writingPersonas';

    protected function setUpController(): void
    {
        $this->enableReorder();
    }

    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Medias::make()
                ->name('avatar')
                ->label('Avatar')
        );

        $form->add(
            Input::make()
                ->name('specialty')
                ->label('Specialty')
                ->placeholder('e.g. News, Long-form, Opinion, Interview, Review')
                ->required()
        );

        $form->add(
            Input::make()
                ->name('voice_description')
                ->label('Voice Description')
                ->type('textarea')
                ->rows(8)
                ->note('Describe the tone, style, audience, and rules. This is sent to Claude as the writing instruction.')
                ->required()
        );

        return $form;
    }

    protected function additionalIndexTableColumns(): \Illuminate\Support\Collection
    {
        return collect([
            Text::make()->field('specialty')->title('Specialty'),
        ]);
    }
}
```

- [ ] **Step 6: Register the route**

Modify `routes/twill.php` — add below the existing `TwillRoutes::module('articles')`:

```php
TwillRoutes::module('writingPersonas');
```

- [ ] **Step 7: Register the nav link**

Modify `app/Providers/AppServiceProvider.php`. Add this after the existing articles nav link in `boot()`:

```php
TwillNavigation::addLink(
    NavigationLink::make()
        ->forModule('writingPersonas')
        ->title(__('twill.nav.writing_personas'))
);
```

- [ ] **Step 8: Add language strings**

Modify `lang/en/twill.php`:

```php
<?php

return [
    'nav' => [
        'articles' => 'Articles',
        'writing_personas' => 'Writing Personas',
    ],
];
```

Modify `lang/it/twill.php`:

```php
<?php

return [
    'nav' => [
        'articles' => 'Articoli',
        'writing_personas' => 'Persona di Scrittura',
    ],
];
```

- [ ] **Step 9: Run the migration**

```bash
php artisan migrate
```

Expected: table `writing_personas` created successfully.

- [ ] **Step 10: Smoke test**

```bash
php artisan config:clear && php artisan route:clear && php artisan view:clear
```

Test:
1. Visit `/admin` → "Writing Personas" should appear in sidebar
2. Click "Add new" → form should show Avatar, Title, Specialty, Voice Description fields
3. Create a test persona: Name "Lucy", Specialty "Long-form", upload any image as avatar, enter a voice description
4. Save → persona appears in the list with specialty column
5. Verify reordering works (drag handles)

- [ ] **Step 11: Commit**

```bash
git add database/migrations/ app/Models/WritingPersona.php app/Repositories/WritingPersonaRepository.php app/Http/Controllers/Twill/WritingPersonaController.php app/Http/Requests/Twill/WritingPersonaRequest.php routes/twill.php app/Providers/AppServiceProvider.php lang/en/twill.php lang/it/twill.php
git commit -m "feat: add Writing Personas Twill module with avatar, specialty, voice description"
```

---

## Task 3: Claude API Endpoint

**Files:**
- Modify: `composer.json` (add Anthropic SDK)
- Create: `app/Http/Controllers/Twill/AiGenerateController.php`
- Modify: `routes/twill.php`

- [ ] **Step 1: Install the Anthropic PHP SDK**

```bash
cd /Users/new/Desktop/twill-magazine-starter
composer require anthropic-ai/sdk
```

- [ ] **Step 2: Create the AI generation controller**

Create `app/Http/Controllers/Twill/AiGenerateController.php`:

```php
<?php

namespace App\Http\Controllers\Twill;

use App\Http\Controllers\Controller;
use App\Models\WritingPersona;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use A17\Twill\Facades\TwillAppSettings;

class AiGenerateController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'persona_id' => 'required|exists:writing_personas,id',
            'action' => 'required|in:generate,restyle',
            'title' => 'required|string|max:500',
            'body' => 'nullable|string',
        ]);

        $apiKey = TwillAppSettings::get('siteSettings.analytics.claude_api_key');

        if (! $apiKey) {
            return response()->json([
                'error' => 'Claude API key not configured. Set it in Site Settings.',
            ], 422);
        }

        $persona = WritingPersona::findOrFail($request->persona_id);

        $userMessage = $request->action === 'generate'
            ? "Write an article with this title: \"{$request->title}\"\n\nWrite the full article body. Do not include the title in your response."
            : "Rewrite this article in your voice. Keep the same facts and structure but apply your writing style.\n\nTitle: \"{$request->title}\"\n\nCurrent draft:\n{$request->body}";

        try {
            $client = \Anthropic::factory()
                ->withApiKey($apiKey)
                ->make();

            $response = $client->messages()->create([
                'model' => 'claude-sonnet-4-6',
                'max_tokens' => 4096,
                'system' => $persona->voice_description,
                'messages' => [
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);

            $text = $response->content[0]->text;

            return response()->json(['text' => $text]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Claude API error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
```

- [ ] **Step 3: Register the route**

Modify `routes/twill.php`. Add after the module routes:

```php
use App\Http\Controllers\Twill\AiGenerateController;

Route::prefix('admin')
    ->middleware(['twill_auth:twill_users'])
    ->group(function () {
        Route::post('ai/generate', AiGenerateController::class)->name('twill.ai.generate');
    });
```

- [ ] **Step 4: Smoke test the endpoint**

```bash
php artisan route:clear
php artisan route:list --name=ai
```

Expected: `POST admin/ai/generate` route listed with `twill_auth` middleware.

- [ ] **Step 5: Commit**

```bash
git add composer.json composer.lock app/Http/Controllers/Twill/AiGenerateController.php routes/twill.php
git commit -m "feat: add Claude AI generation endpoint for writing personas"
```

---

## Task 4: Writing Assistant Vue Component

**Files:**
- Create: `resources/assets/js/components/WritingAssistant.vue`
- Modify: `app/Http/Controllers/Twill/ArticleController.php`

- [ ] **Step 1: Create the Vue component**

Create directory and file `resources/assets/js/components/WritingAssistant.vue`:

```vue
<template>
  <div class="writing-assistant">
    <!-- No API Key Warning -->
    <div v-if="!hasApiKey" class="wa-warning">
      <strong>Claude API key not configured.</strong>
      AI writing features require a Claude API key.
      <a :href="settingsUrl">Configure in Site Settings →</a>
    </div>

    <!-- Main UI -->
    <div v-else class="wa-bar">
      <div class="wa-header">
        <span class="wa-badge">AI</span>
        <span class="wa-title">Writing Assistant</span>
        <span class="wa-powered">Powered by Claude</span>
      </div>

      <!-- Persona Cards -->
      <div class="wa-personas">
        <div
          v-for="persona in personas"
          :key="persona.id"
          class="wa-persona-card"
          :class="{ selected: selectedPersona?.id === persona.id }"
          @click="selectPersona(persona)"
        >
          <img
            v-if="persona.avatar_url"
            :src="persona.avatar_url"
            :alt="persona.title"
            class="wa-avatar"
          />
          <div v-else class="wa-avatar wa-avatar-placeholder">
            {{ persona.title.charAt(0) }}
          </div>
          <div class="wa-persona-info">
            <div class="wa-persona-name">{{ persona.title }}</div>
            <div class="wa-persona-specialty">{{ persona.specialty }}</div>
            <div class="wa-persona-desc">{{ truncate(persona.voice_description, 80) }}</div>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="wa-actions">
        <button
          class="wa-btn wa-btn-generate"
          :disabled="!selectedPersona || loading"
          @click="generate"
        >
          ✨ Generate from Title
        </button>
        <button
          class="wa-btn wa-btn-restyle"
          :disabled="!selectedPersona || loading"
          @click="restyle"
        >
          🔄 Restyle Draft
        </button>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="wa-loading">
        <img
          v-if="selectedPersona?.avatar_url"
          :src="selectedPersona.avatar_url"
          class="wa-loading-avatar"
        />
        <div class="wa-loading-text">{{ selectedPersona?.title }} is writing...</div>
      </div>

      <!-- Error -->
      <div v-if="error" class="wa-error">
        {{ error }}
        <button @click="error = null" class="wa-error-dismiss">✕</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'WritingAssistant',
  props: {
    hasApiKey: { type: Boolean, default: false },
    settingsUrl: { type: String, default: '/admin/settings' },
    generateUrl: { type: String, default: '/admin/ai/generate' },
  },
  data() {
    return {
      personas: [],
      selectedPersona: null,
      loading: false,
      error: null,
    };
  },
  mounted() {
    this.fetchPersonas();
  },
  methods: {
    async fetchPersonas() {
      try {
        const res = await axios.get('/admin/api/writing-personas');
        this.personas = res.data;
      } catch (e) {
        this.error = 'Failed to load writing personas.';
      }
    },
    selectPersona(persona) {
      this.selectedPersona = persona;
    },
    truncate(text, len) {
      return text.length > len ? text.substring(0, len) + '…' : text;
    },
    getTitle() {
      // Read title from Twill's Vuex store
      const store = this.$root.$store;
      if (store && store.state.form) {
        return store.state.form.fields.find(f => f.name === 'title')?.value || '';
      }
      // Fallback: read from DOM
      const input = document.querySelector('input[name="title"]');
      return input ? input.value : '';
    },
    getBody() {
      const store = this.$root.$store;
      if (store && store.state.form) {
        const field = store.state.form.fields.find(f => f.name === 'body');
        return field?.value || '';
      }
      return '';
    },
    setBody(text) {
      const store = this.$root.$store;
      if (store) {
        store.commit('updateFormField', { name: 'body', value: text });
      }
    },
    async callApi(action) {
      this.loading = true;
      this.error = null;

      try {
        const res = await axios.post(this.generateUrl, {
          persona_id: this.selectedPersona.id,
          action: action,
          title: this.getTitle(),
          body: action === 'restyle' ? this.getBody() : null,
        });

        this.setBody(res.data.text);
      } catch (e) {
        this.error = e.response?.data?.error || 'Something went wrong. Please try again.';
      } finally {
        this.loading = false;
      }
    },
    generate() {
      this.callApi('generate');
    },
    restyle() {
      this.callApi('restyle');
    },
  },
};
</script>

<style scoped>
.writing-assistant {
  margin-bottom: 20px;
}

.wa-warning {
  background: #fffbeb;
  border: 1px solid #fcd34d;
  border-radius: 8px;
  padding: 14px 18px;
  font-size: 13px;
  color: #92400e;
}
.wa-warning a {
  color: #6c63ff;
  font-weight: 500;
}

.wa-bar {
  background: #f8f9fb;
  border: 1px solid #e2e6ee;
  border-radius: 10px;
  padding: 18px;
}

.wa-header {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 14px;
}
.wa-badge {
  background: linear-gradient(135deg, #6c63ff, #a855f7);
  color: #fff;
  font-size: 11px;
  font-weight: 700;
  padding: 4px 8px;
  border-radius: 6px;
}
.wa-title {
  font-size: 14px;
  font-weight: 600;
}
.wa-powered {
  font-size: 10px;
  background: #e8e6ff;
  color: #6c63ff;
  padding: 2px 8px;
  border-radius: 10px;
  font-weight: 600;
}

.wa-personas {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 10px;
  margin-bottom: 14px;
}

.wa-persona-card {
  display: flex;
  gap: 10px;
  align-items: flex-start;
  padding: 12px;
  border: 2px solid #e2e6ee;
  border-radius: 10px;
  background: #fff;
  cursor: pointer;
  transition: all 0.15s;
}
.wa-persona-card:hover {
  border-color: #b0b0e0;
}
.wa-persona-card.selected {
  border-color: #6c63ff;
  background: #faf9ff;
  box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.12);
}

.wa-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  object-fit: cover;
  flex-shrink: 0;
}
.wa-avatar-placeholder {
  display: flex;
  align-items: center;
  justify-content: center;
  background: #e2e6ee;
  color: #666;
  font-weight: 700;
  font-size: 18px;
}

.wa-persona-name {
  font-size: 13px;
  font-weight: 700;
}
.wa-persona-specialty {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #6c63ff;
  margin: 2px 0;
}
.wa-persona-desc {
  font-size: 11px;
  color: #888;
  line-height: 1.4;
}

.wa-actions {
  display: flex;
  gap: 8px;
}

.wa-btn {
  padding: 9px 16px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  border: none;
  transition: all 0.15s;
}
.wa-btn:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}
.wa-btn-generate {
  background: #6c63ff;
  color: #fff;
}
.wa-btn-generate:hover:not(:disabled) {
  background: #5a52d9;
}
.wa-btn-restyle {
  background: #fff;
  color: #6c63ff;
  border: 1px solid #6c63ff;
}
.wa-btn-restyle:hover:not(:disabled) {
  background: #f0eeff;
}

.wa-loading {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-top: 14px;
  padding: 16px;
  background: rgba(108, 99, 255, 0.04);
  border: 1px dashed rgba(108, 99, 255, 0.3);
  border-radius: 8px;
}
.wa-loading-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  animation: pulse 1.5s ease-in-out infinite;
}
@keyframes pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.06); }
}
.wa-loading-text {
  font-size: 13px;
  color: #6c63ff;
  font-weight: 500;
}

.wa-error {
  margin-top: 10px;
  padding: 10px 14px;
  background: #fef2f2;
  border: 1px solid #fecaca;
  border-radius: 6px;
  font-size: 12px;
  color: #dc2626;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.wa-error-dismiss {
  background: none;
  border: none;
  color: #dc2626;
  cursor: pointer;
  font-size: 14px;
}
</style>
```

- [ ] **Step 2: Create an API endpoint for fetching personas**

Add to `routes/twill.php` inside the admin middleware group created in Task 3:

```php
Route::prefix('admin')
    ->middleware(['twill_auth:twill_users'])
    ->group(function () {
        Route::post('ai/generate', AiGenerateController::class)->name('twill.ai.generate');
        Route::get('api/writing-personas', function () {
            $personas = \App\Models\WritingPersona::where('published', true)
                ->ordered()
                ->get()
                ->map(function ($persona) {
                    return [
                        'id' => $persona->id,
                        'title' => $persona->title,
                        'specialty' => $persona->specialty,
                        'voice_description' => $persona->voice_description,
                        'avatar_url' => $persona->hasImage('avatar') ? $persona->image('avatar', 'default') : null,
                    ];
                });
            return response()->json($personas);
        })->name('twill.api.writing-personas');
    });
```

- [ ] **Step 3: Register the Vue component with Twill**

Create `resources/assets/js/app.js`:

```js
import WritingAssistant from './components/WritingAssistant.vue';

window.vm.$options.components['a17-writing-assistant'] = WritingAssistant;
```

Note: The exact Twill 3 component registration may vary. If `window.vm` is not available, check Twill's custom component documentation. An alternative is to register it via the `twill.custom_components_resource_path` config in `config/twill.php`:

```php
return [
    'custom_components_resource_path' => 'assets/js/components',
];
```

- [ ] **Step 4: Inject the component into the article form**

Modify `app/Http/Controllers/Twill/ArticleController.php`. Add this import:

```php
use A17\Twill\Services\Forms\Fields\BladePartial;
```

Add this at the beginning of `getForm()`, after `$form = parent::getForm($model)`:

```php
$form->addFieldBefore(
    BladePartial::make()->view('twill.partials.writing-assistant'),
    'body'
);
```

- [ ] **Step 5: Create the Blade partial**

Create `resources/views/twill/partials/writing-assistant.blade.php`:

```blade
@php
    $hasApiKey = false;
    try {
        $hasApiKey = (bool) \A17\Twill\Facades\TwillAppSettings::get('siteSettings.analytics.claude_api_key');
    } catch (\Throwable $e) {}
@endphp

<a17-writing-assistant
    :has-api-key="{{ $hasApiKey ? 'true' : 'false' }}"
    settings-url="{{ route('twill.app-settings.page', ['group' => 'siteSettings']) }}"
    generate-url="{{ route('twill.ai.generate') }}"
></a17-writing-assistant>
```

- [ ] **Step 6: Build Twill custom assets**

```bash
php artisan twill:build
```

If this fails, check that `config/twill.php` has the custom components path configured. Expected: assets compile without errors.

- [ ] **Step 7: Smoke test the full flow**

```bash
php artisan config:clear && php artisan route:clear && php artisan view:clear
```

Test:
1. Ensure you have at least one published Writing Persona
2. Ensure Claude API key is set in Site Settings
3. Go to `/admin/articles` → edit or create an article
4. The Writing Assistant bar should appear above the body field
5. Persona cards should load with avatars
6. Select a persona → buttons activate
7. Enter a title, click "Generate from Title" → body field populates with Claude's output
8. Click "Restyle Draft" → body field gets rewritten in the persona's voice
9. Test with no API key → warning banner should appear instead

- [ ] **Step 8: Commit**

```bash
git add resources/assets/js/ resources/views/twill/partials/writing-assistant.blade.php app/Http/Controllers/Twill/ArticleController.php routes/twill.php config/twill.php
git commit -m "feat: add Writing Assistant Vue component with Claude AI generation in article editor"
```

---

## Task 5: Language Strings + Seeder

**Files:**
- Modify: `lang/en/site.php`
- Modify: `lang/it/site.php`
- Create: `database/seeders/WritingPersonaSeeder.php`

- [ ] **Step 1: Add English language strings**

Add these keys to `lang/en/site.php`:

```php
'writing_assistant' => 'Writing Assistant',
'powered_by_claude' => 'Powered by Claude',
'generate_from_title' => 'Generate from Title',
'restyle_draft' => 'Restyle Draft',
'select_persona' => 'Select a persona...',
'no_api_key' => 'Claude API key not configured.',
'no_api_key_detail' => 'AI writing features require a Claude API key.',
'configure_settings' => 'Configure in Site Settings',
```

- [ ] **Step 2: Add Italian language strings**

Add these keys to `lang/it/site.php`:

```php
'writing_assistant' => 'Assistente di Scrittura',
'powered_by_claude' => 'Powered by Claude',
'generate_from_title' => 'Genera dal Titolo',
'restyle_draft' => 'Riscrivi Bozza',
'select_persona' => 'Seleziona una persona...',
'no_api_key' => 'Chiave API Claude non configurata.',
'no_api_key_detail' => 'Le funzioni di scrittura AI richiedono una chiave API Claude.',
'configure_settings' => 'Configura nelle Impostazioni',
```

- [ ] **Step 3: Create the seeder**

Create `database/seeders/WritingPersonaSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\WritingPersona;
use Illuminate\Database\Seeder;

class WritingPersonaSeeder extends Seeder
{
    public function run(): void
    {
        $personas = [
            [
                'title' => 'Lucy',
                'specialty' => 'Long-form',
                'voice_description' => "Write warm, curious, narrative-driven pieces. Craft immersive stories with vivid scene-setting, meaningful quotes, and a literary sensibility. Favor human-interest angles. Use rich but accessible language — never academic. Open with a scene, not a summary. Build tension through structure. Close with resonance, not a recap.\n\nYour reader is an intelligent generalist who reads for pleasure and insight. They want to feel like they were there.",
                'published' => true,
                'position' => 1,
            ],
            [
                'title' => 'Charles',
                'specialty' => 'News',
                'voice_description' => "Write concise, objective news copy in AP style. Lead with the most newsworthy fact. Use active voice. Keep sentences short. Attribute all claims. Avoid editorializing or adjectives that imply judgment. One idea per paragraph.\n\nYour reader is busy and wants the facts fast. Respect their time.",
                'published' => true,
                'position' => 2,
            ],
            [
                'title' => 'Elena',
                'specialty' => 'Opinion',
                'voice_description' => "Write bold, first-person opinion columns with a strong point of view. Use rhetorical questions, vivid analogies, and memorable one-liners. Never sit on the fence. Take a clear stance in the opening paragraph. Build your argument with evidence but deliver it with flair. Close with a line that sticks.\n\nYour reader wants to be challenged and entertained. They may disagree — make them think anyway.",
                'published' => true,
                'position' => 3,
            ],
        ];

        foreach ($personas as $data) {
            WritingPersona::firstOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}
```

- [ ] **Step 4: Run the seeder**

```bash
php artisan db:seed --class=WritingPersonaSeeder
```

Expected: 3 personas created (Lucy, Charles, Elena).

- [ ] **Step 5: Commit**

```bash
git add lang/en/site.php lang/it/site.php database/seeders/WritingPersonaSeeder.php
git commit -m "feat: add language strings and default persona seeder (Lucy, Charles, Elena)"
```

---

## Task 6: Final Integration Test

- [ ] **Step 1: Clear all caches**

```bash
php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear
```

- [ ] **Step 2: Run full test suite**

```bash
php artisan test
```

Expected: all existing tests pass. No regressions.

- [ ] **Step 3: Manual end-to-end walkthrough**

Test the complete flow:

1. `/admin` → sidebar shows "Articles", "Writing Personas", "Site Settings"
2. Site Settings → enter GA Measurement ID → save → check public site source for gtag snippet
3. Site Settings → enter Claude API key → save
4. Writing Personas → 3 seeded personas visible (Lucy, Charles, Elena)
5. Edit "Lucy" → upload an avatar image → save
6. Articles → create new article → Writing Assistant bar visible with persona cards
7. Select Lucy → click "Generate from Title" → body field populates
8. Select Charles → click "Restyle Draft" → body rewrites in news style
9. Remove Claude API key from Site Settings → article editor shows warning banner
10. Remove GA ID → public site has no tracking script

- [ ] **Step 4: Commit any fixes**

```bash
git add -A
git commit -m "fix: address issues found during integration testing"
```

Only commit this if fixes were needed. Skip if everything passed clean.
