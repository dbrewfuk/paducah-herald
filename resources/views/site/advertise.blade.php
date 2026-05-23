@extends('layouts.app')
@section('title', 'Advertise | The Paducah Herald')
@section('description', 'Reach engaged Western Kentucky readers. Learn about advertising with The Paducah Herald.')

@section('styles')
<style>
  .adv-wrap {
    max-width: var(--max-w); margin: 0 auto;
    padding: 48px var(--gutter) 80px;
    display: grid; grid-template-columns: 1fr 300px; gap: 0 60px;
  }
  .adv-main {}
  .adv-aside { padding-top: 4px; }

  .adv-kicker {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--red); margin-bottom: 16px;
  }
  .adv-title {
    font-family: var(--serif); font-size: 44px; font-weight: 500;
    line-height: 1.1; color: var(--ink-5); margin-bottom: 22px; text-wrap: balance;
  }
  .adv-standfirst {
    font-family: var(--serif); font-size: 19px; line-height: 1.55;
    color: var(--ink-20); margin-bottom: 36px; padding-bottom: 28px;
    border-bottom: 1px solid var(--paris-85);
  }
  .adv-body {
    font-family: var(--serif); font-size: 17px; line-height: 1.7; color: var(--ink-10);
  }
  .adv-body p { margin-bottom: 1.3em; }
  .adv-body h2 {
    font-family: var(--serif); font-size: 24px; font-weight: 600;
    color: var(--ink-5); margin: 2em 0 0.6em;
    border-top: 1px solid var(--paris-85); padding-top: 1.5em;
  }

  /* Ad formats table */
  .adv-table { width: 100%; border-collapse: collapse; margin-bottom: 1.5em; font-family: var(--sans); font-size: 14px; }
  .adv-table th {
    text-align: left; font-weight: 700; font-size: 11px; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--ink-35); padding: 8px 0; border-bottom: 2px solid var(--ink-5);
  }
  .adv-table td { padding: 10px 0; border-bottom: 1px solid var(--paris-85); color: var(--ink-10); }
  .adv-table td:last-child { color: var(--ink-35); }

  /* Aside */
  .adv-panel { border-top: 3px solid var(--ink-5); padding-top: 16px; margin-bottom: 36px; }
  .adv-panel-head {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--ink-35); margin-bottom: 16px;
  }
  .adv-contact-item {
    font-size: 14px; font-family: var(--sans); color: var(--ink-20);
    padding: 10px 0; border-bottom: 1px solid var(--paris-85);
    display: flex; flex-direction: column; gap: 2px;
  }
  .adv-contact-item:last-child { border-bottom: none; }
  .adv-contact-label {
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.08em; color: var(--ink-35);
  }
  .adv-contact-value a { color: var(--red); text-decoration: underline; }

  @media (max-width: 900px) {
    .adv-wrap { grid-template-columns: 1fr; }
    .adv-aside { border-top: 1px solid var(--paris-85); padding-top: 40px; margin-top: 40px; }
    .adv-title { font-size: 32px; }
  }
  @media (max-width: 540px) {
    .adv-wrap { padding-top: 32px; }
    .adv-title { font-size: 26px; }
    .adv-body { font-size: 16px; }
  }
</style>
@endsection

@section('content')
<div class="adv-wrap">
  <main class="adv-main">
    <p class="adv-kicker">Advertising</p>
    <h1 class="adv-title">Reach the readers who shape Western Kentucky</h1>
    <p class="adv-standfirst">
      The Paducah Herald's audience is engaged, local, and loyal. Our readers are
      homeowners, business owners, voters, and community leaders across McCracken,
      Marshall, Graves, Calloway, and surrounding counties.
    </p>

    <div class="adv-body">
      <p>Advertising with The Paducah Herald puts your message in front of an audience that
      actively seeks out local news. Our readers aren't scrolling past — they're here because
      they care about what's happening in their community. That attention is valuable, and
      we work with local businesses to make sure it translates into results.</p>

      <h2>Ad formats</h2>
      <table class="adv-table">
        <thead>
          <tr>
            <th>Format</th>
            <th>Placement</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Leaderboard (728×90)</td>
            <td>Above masthead, sitewide</td>
            <td>High-visibility, every page</td>
          </tr>
          <tr>
            <td>Rectangle (300×250)</td>
            <td>Article sidebar</td>
            <td>Runs alongside content</td>
          </tr>
          <tr>
            <td>Sponsored content</td>
            <td>Homepage + section feeds</td>
            <td>Labeled "Sponsored"</td>
          </tr>
          <tr>
            <td>Newsletter inclusion</td>
            <td>Western Kentucky In Brief</td>
            <td>Daily digest email</td>
          </tr>
          <tr>
            <td>Event listings</td>
            <td>Community calendar</td>
            <td>Local events only</td>
          </tr>
        </tbody>
      </table>

      <h2>Our audience</h2>
      <p>The Herald serves readers across the Purchase Area — McCracken, Marshall, Graves,
      Calloway, Ballard, Carlisle, Hickman, and Fulton counties. Our coverage of local
      government, courts, schools, sports, and economic development draws a consistent
      audience of engaged community members who make decisions about where to shop,
      eat, bank, and build.</p>

      <h2>How to advertise</h2>
      <p>Contact our advertising team to discuss rates, availability, and package options.
      We offer monthly and quarterly commitments, and we work with local businesses of
      all sizes — from sole proprietors to regional employers. Custom packages are available
      for major announcements, event sponsorships, and special sections.</p>

      <p>Email <a href="mailto:advertising@paducahherald.com">advertising@paducahherald.com</a>
      to get started. We respond to all inquiries within one business day.</p>

      <h2>Editorial independence</h2>
      <p>Advertising relationships have no influence on our news coverage. Editorial and
      business operations are kept strictly separate. Sponsored content is always clearly
      labeled and never represents the editorial opinion of The Paducah Herald.</p>
    </div>
  </main>

  <aside class="adv-aside">
    <div class="adv-panel">
      <p class="adv-panel-head">Get in touch</p>
      <div class="adv-contact-item">
        <span class="adv-contact-label">Advertising inquiries</span>
        <span class="adv-contact-value">
          <a href="mailto:advertising@paducahherald.com">advertising@paducahherald.com</a>
        </span>
      </div>
      <div class="adv-contact-item">
        <span class="adv-contact-label">Response time</span>
        <span class="adv-contact-value" style="color:var(--ink-5)">Within one business day</span>
      </div>
      <div class="adv-contact-item">
        <span class="adv-contact-label">Coverage area</span>
        <span class="adv-contact-value" style="color:var(--ink-5)">McCracken, Marshall, Graves, Calloway &amp; surrounding counties</span>
      </div>
    </div>

    <div class="adv-panel">
      <p class="adv-panel-head">Also of interest</p>
      <p style="font-size:14px;font-family:var(--sans);color:var(--ink-20);line-height:1.5;margin-bottom:12px;">
        Subscribe to read everything we publish — from breaking local news to First Region sports.
      </p>
      <a href="{{ route('payment.checkout') }}" class="btn-subscribe"
         style="display:block;text-align:center;padding:12px 20px;border-radius:3px;font-family:var(--sans);font-size:15px;font-weight:700;text-decoration:none;">
        Subscribe now
      </a>
    </div>
  </aside>
</div>
@endsection
