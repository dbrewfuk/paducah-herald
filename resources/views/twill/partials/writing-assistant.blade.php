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
