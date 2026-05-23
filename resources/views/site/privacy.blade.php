@extends('layouts.app')
@section('title', 'Privacy Policy | The Paducah Herald')
@section('description', 'How The Paducah Herald collects, uses, and protects your information.')

@section('styles')
<style>
  .policy-wrap {
    max-width: 720px; margin: 0 auto;
    padding: 48px var(--gutter) 80px;
  }
  .policy-kicker {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--red);
    margin-bottom: 14px;
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
  <h1 class="policy-title">Privacy Policy</h1>
  <p class="policy-date">Last updated: May 2026</p>

  <div class="policy-body">
    <p>The Paducah Herald ("we," "our," or "us") is committed to protecting your privacy. This policy explains what information we collect, how we use it, and your rights regarding that information.</p>

    <h2>Information we collect</h2>
    <p>We collect information you provide directly to us, including:</p>
    <ul>
      <li>Name and email address when you subscribe or contact us</li>
      <li>Payment information processed securely through Stripe — we never store your card details directly</li>
      <li>Correspondence you send to our editorial team</li>
    </ul>
    <p>We also collect certain information automatically when you visit our site, including your IP address, browser type, pages visited, and referring URL. This is collected through standard server logs and, where applicable, analytics tools.</p>

    <h2>How we use your information</h2>
    <ul>
      <li>To process subscriptions and verify payment status</li>
      <li>To send you newsletters or digest emails you have opted into</li>
      <li>To respond to your inquiries and letters to the editor</li>
      <li>To understand how readers use our site so we can improve coverage</li>
      <li>To comply with legal obligations</li>
    </ul>

    <h2>Cookies</h2>
    <p>We use cookies to maintain your session, remember your subscription status, and track how many free articles you have read. We do not use third-party advertising cookies. You can disable cookies in your browser settings, though doing so may affect your ability to access subscriber content.</p>

    <h2>Sharing of information</h2>
    <p>We do not sell your personal information. We may share information with trusted third-party service providers (such as Stripe for payment processing) who are contractually obligated to protect it. We may disclose information when required by law or to protect the rights and safety of our readers and staff.</p>

    <h2>Data retention</h2>
    <p>We retain subscriber data for the duration of your subscription and for a reasonable period thereafter for accounting and legal purposes. You may request deletion of your account by contacting us at <a href="mailto:news@paducahherald.com">news@paducahherald.com</a>.</p>

    <h2>Your rights</h2>
    <p>You have the right to access, correct, or delete the personal information we hold about you. To make a request, contact us at <a href="mailto:news@paducahherald.com">news@paducahherald.com</a>. We will respond within 30 days.</p>

    <h2>Children</h2>
    <p>Our site is not directed at children under 13, and we do not knowingly collect personal information from children.</p>

    <h2>Changes to this policy</h2>
    <p>We may update this policy from time to time. We will post the revised policy on this page with an updated effective date. Continued use of the site after changes constitutes acceptance of the revised policy.</p>

    <h2>Contact</h2>
    <p>Questions about this policy? Email us at <a href="mailto:news@paducahherald.com">news@paducahherald.com</a> or write to The Paducah Herald, Paducah, Kentucky 42001.</p>
  </div>
</div>
@endsection
