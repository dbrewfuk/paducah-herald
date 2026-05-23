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
