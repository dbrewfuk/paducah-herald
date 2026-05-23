<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Subscribe to continue | The Paducah Herald</title>
  <link rel="stylesheet" href="{{ asset('css/economist-1e1bb3.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/economist-1e4acd.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/economist-25a99e.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/economist-bed931.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/economist-cfb5b9.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/economist-da5457.css') }}" />
  <link rel="stylesheet" href="{{ asset('economist.css') }}" />
  <style>
    :root {
      --red: #1a4a7a;
      --navy-20: #1a4a7a;
      --navy-30: #2a5a8a;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      min-height: 100vh;
      background: #f5f0e8;
      font-family: var(--sans);
      display: flex;
      flex-direction: column;
    }

    /* ── Masthead ─────────────────────────────────────────── */
    .pw-nav {
      background: #fff;
      border-bottom: 3px solid #1a4a7a;
      padding: 0 24px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .pw-wordmark {
      font-family: var(--serif);
      font-size: 22px;
      font-weight: 700;
      color: #1a4a7a;
      letter-spacing: -0.02em;
      line-height: 1;
      text-decoration: none;
    }
    .pw-wordmark span {
      display: block;
      font-size: 9px;
      font-family: var(--sans);
      font-weight: 600;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--ink-35);
      margin-top: 2px;
    }
    .pw-nav-login {
      font-size: 13px;
      color: var(--ink-35);
    }
    .pw-nav-login a { color: #1a4a7a; text-decoration: underline; }

    /* ── Page layout ──────────────────────────────────────── */
    .pw-page {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 48px 24px;
    }

    .pw-card {
      background: #fff;
      border-top: 4px solid #1a4a7a;
      max-width: 560px;
      width: 100%;
      padding: 48px 52px;
      text-align: center;
      box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    }

    /* ── Meter ────────────────────────────────────────────── */
    .pw-meter {
      display: flex;
      justify-content: center;
      gap: 8px;
      margin-bottom: 32px;
    }
    .pw-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #1a4a7a;
    }
    .pw-dot.empty {
      background: #ddd;
    }

    /* ── Headline block ───────────────────────────────────── */
    .pw-kicker {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #1a4a7a;
      margin-bottom: 16px;
    }
    .pw-headline {
      font-family: var(--serif);
      font-size: 34px;
      font-weight: 500;
      line-height: 1.15;
      color: var(--ink-5);
      margin-bottom: 16px;
      text-wrap: balance;
    }
    .pw-sub {
      font-size: 15px;
      color: var(--ink-35);
      line-height: 1.55;
      margin-bottom: 36px;
      max-width: 400px;
      margin-left: auto;
      margin-right: auto;
    }

    /* ── Price block ──────────────────────────────────────── */
    .pw-price-wrap {
      background: #f5f0e8;
      border-radius: 4px;
      padding: 20px 28px;
      margin-bottom: 28px;
      text-align: left;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
    }
    .pw-price-label {
      font-size: 14px;
      font-weight: 600;
      color: var(--ink-10);
    }
    .pw-price-desc {
      font-size: 12px;
      color: var(--ink-35);
      margin-top: 3px;
    }
    .pw-price-amount {
      font-family: var(--serif);
      font-size: 32px;
      font-weight: 700;
      color: #1a4a7a;
      white-space: nowrap;
    }
    .pw-price-amount span {
      font-size: 15px;
      font-weight: 400;
      font-family: var(--sans);
      color: var(--ink-35);
    }

    /* ── What you get ─────────────────────────────────────── */
    .pw-perks {
      list-style: none;
      margin-bottom: 32px;
      text-align: left;
    }
    .pw-perks li {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      font-size: 14px;
      color: var(--ink-20);
      padding: 7px 0;
      border-bottom: 1px solid #f0ebe0;
    }
    .pw-perks li:last-child { border-bottom: none; }
    .pw-perk-icon {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: #1a4a7a;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      margin-top: 1px;
    }
    .pw-perk-icon svg { width: 10px; height: 10px; fill: none; stroke: #fff; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

    /* ── CTA ──────────────────────────────────────────────── */
    .pw-cta {
      display: block;
      width: 100%;
      background: #1a4a7a;
      color: #fff;
      font-family: var(--sans);
      font-size: 16px;
      font-weight: 700;
      padding: 16px 24px;
      border-radius: 3px;
      text-decoration: none;
      transition: background 0.15s;
      letter-spacing: 0.01em;
      margin-bottom: 16px;
    }
    .pw-cta:hover { background: #2a5a8a; }

    .pw-stripe-note {
      font-size: 12px;
      color: var(--ink-70);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      margin-bottom: 24px;
    }
    .pw-stripe-note svg { width: 14px; height: 14px; opacity: 0.5; }

    .pw-back {
      font-size: 13px;
      color: var(--ink-35);
    }
    .pw-back a { color: #1a4a7a; }

    /* ── Footer ───────────────────────────────────────────── */
    .pw-footer {
      text-align: center;
      padding: 24px;
      font-size: 11px;
      color: var(--ink-70);
      border-top: 1px solid #e8e0d0;
    }
  </style>
</head>
<body>

<nav class="pw-nav">
  <a class="pw-wordmark" href="{{ route('home') }}">
    The Paducah Herald
    <span>Paducah, Kentucky</span>
  </a>
  <p class="pw-nav-login">Already subscribed? <a href="#">Log in</a></p>
</nav>

<div class="pw-page">
  <div class="pw-card">

    {{-- Article meter: 2 filled dots, 1 empty --}}
    <div class="pw-meter" aria-label="You have read 2 of 2 free articles">
      <div class="pw-dot" title="Article 1 – read"></div>
      <div class="pw-dot" title="Article 2 – read"></div>
      <div class="pw-dot empty" title="Article 3 – locked"></div>
    </div>

    <p class="pw-kicker">You've read your 2 free articles</p>
    <h1 class="pw-headline">Support local journalism in Western Kentucky</h1>
    <p class="pw-sub">
      The Paducah Herald covers the stories that matter to McCracken County
      and the surrounding region — and we depend on readers like you.
    </p>

    <div class="pw-price-wrap">
      <div>
        <p class="pw-price-label">30-day full access</p>
        <p class="pw-price-desc">One payment. Unlimited articles.</p>
      </div>
      <div class="pw-price-amount">$10 <span>/ 30 days</span></div>
    </div>

    <ul class="pw-perks">
      <li>
        <div class="pw-perk-icon">
          <svg viewBox="0 0 12 12"><polyline points="1.5,6 4.5,9 10.5,3"/></svg>
        </div>
        Unlimited access to all Herald articles
      </li>
      <li>
        <div class="pw-perk-icon">
          <svg viewBox="0 0 12 12"><polyline points="1.5,6 4.5,9 10.5,3"/></svg>
        </div>
        Herald Insider — in-depth video & audio reporting
      </li>
      <li>
        <div class="pw-perk-icon">
          <svg viewBox="0 0 12 12"><polyline points="1.5,6 4.5,9 10.5,3"/></svg>
        </div>
        Western Kentucky In Brief — daily news digest
      </li>
      <li>
        <div class="pw-perk-icon">
          <svg viewBox="0 0 12 12"><polyline points="1.5,6 4.5,9 10.5,3"/></svg>
        </div>
        E-Edition — the full weekly print edition online
      </li>
    </ul>

    <a class="pw-cta" href="{{ route('payment.checkout') }}">
      Continue reading — $10 for 30 days
    </a>

    <p class="pw-stripe-note">
      <svg viewBox="0 0 16 16" fill="currentColor"><path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm3.5 5.5l-4 5L4 7.5l1-1 2.5 2.5 3-3.5 1 1z"/></svg>
      Secure payment via Stripe
    </p>

    <p class="pw-back">
      <a href="{{ url()->previous(route('home')) }}">&larr; Go back</a>
    </p>
  </div>
</div>

<footer class="pw-footer">
  © The Paducah Herald {{ date('Y') }} &nbsp;·&nbsp;
  <a href="#" style="color:inherit">Privacy policy</a> &nbsp;·&nbsp;
  <a href="#" style="color:inherit">Terms of use</a>
</footer>

</body>
</html>
