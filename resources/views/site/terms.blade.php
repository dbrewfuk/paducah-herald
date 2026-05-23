@extends('layouts.app')
@section('title', 'Terms of Use | The Paducah Herald')
@section('description', 'Terms and conditions for using The Paducah Herald website and subscription services.')

@section('styles')
<style>
  .policy-wrap {
    max-width: 720px; margin: 0 auto; padding: 48px var(--gutter) 80px;
  }
  .policy-kicker {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--red); margin-bottom: 14px;
  }
  .policy-title {
    font-family: var(--serif); font-size: 42px; font-weight: 500;
    line-height: 1.1; color: var(--ink-5); margin-bottom: 10px;
  }
  .policy-date {
    font-size: 13px; font-family: var(--sans); color: var(--ink-35);
    margin-bottom: 36px; padding-bottom: 28px; border-bottom: 1px solid var(--paris-85);
  }
  .policy-body {
    font-family: var(--serif); font-size: 17px; line-height: 1.7; color: var(--ink-10);
  }
  .policy-body p { margin-bottom: 1.3em; }
  .policy-body h2 {
    font-family: var(--serif); font-size: 22px; font-weight: 600;
    color: var(--ink-5); margin: 2em 0 0.5em;
    border-top: 1px solid var(--paris-85); padding-top: 1.4em;
  }
  .policy-body ul { padding-left: 1.4em; margin-bottom: 1.3em; }
  .policy-body ul li { margin-bottom: 0.5em; }
  @media (max-width: 540px) {
    .policy-wrap { padding-top: 32px; }
    .policy-title { font-size: 30px; }
    .policy-body { font-size: 16px; }
  }
</style>
@endsection

@section('content')
<div class="policy-wrap">
  <p class="policy-kicker">Legal</p>
  <h1 class="policy-title">Terms of Use</h1>
  <p class="policy-date">Last updated: May 2026</p>

  <div class="policy-body">
    <p>By accessing or using The Paducah Herald website ("Site"), you agree to be bound by these Terms of Use. If you do not agree, please do not use the Site.</p>

    <h2>Use of content</h2>
    <p>All content published on this Site — including articles, photographs, graphics, and data — is the intellectual property of The Paducah Herald or its licensors. You may not reproduce, republish, distribute, or transmit any content without prior written permission, except for personal, non-commercial use. Brief quotations with attribution are permitted under standard fair use principles.</p>

    <h2>Subscriptions</h2>
    <p>A subscription grants you personal, non-transferable access to subscriber content for the duration of your paid period. Subscriptions are not refundable after access has been granted. You are responsible for keeping your access credentials secure. Do not share your subscription access with others.</p>

    <h2>User conduct</h2>
    <p>You agree not to use the Site to:</p>
    <ul>
      <li>Transmit unlawful, harassing, defamatory, or abusive content</li>
      <li>Impersonate any person or entity</li>
      <li>Circumvent paywalls or access controls by technical means</li>
      <li>Collect or harvest personal data from other users</li>
      <li>Introduce malware or otherwise interfere with Site operations</li>
    </ul>

    <h2>Letters to the editor</h2>
    <p>By submitting a letter to the editor, you grant The Paducah Herald a non-exclusive, royalty-free license to publish, edit for length and clarity, and archive your submission in print and digital formats. We reserve the right to decline any submission.</p>

    <h2>Third-party links</h2>
    <p>The Site may contain links to external websites. We are not responsible for the content or privacy practices of those sites.</p>

    <h2>Disclaimer</h2>
    <p>Content on this Site is provided for informational purposes. The Paducah Herald makes no warranties regarding the accuracy, completeness, or timeliness of any content. We are not liable for any damages arising from your use of the Site or reliance on its content.</p>

    <h2>Changes</h2>
    <p>We may modify these Terms at any time. Continued use of the Site after changes are posted constitutes acceptance of the revised Terms.</p>

    <h2>Contact</h2>
    <p>Questions? Email <a href="mailto:news@paducahherald.com">news@paducahherald.com</a>.</p>
  </div>
</div>
@endsection
