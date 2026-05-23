@extends('layouts.app')

@section('title', 'About Us | The Paducah Herald')
@section('description', 'The Paducah Herald covers local news, sports, and community affairs for Paducah, McCracken County, and Western Kentucky.')

@section('styles')
<style>
  .about-wrap {
    max-width: var(--max-w); margin: 0 auto;
    padding: 48px var(--gutter) 80px;
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 0 60px;
  }
  .about-main {}
  .about-aside { padding-top: 4px; }

  .about-kicker {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--red);
    margin-bottom: 16px;
  }
  .about-title {
    font-family: var(--serif); font-size: 48px; font-weight: 500;
    line-height: 1.1; color: var(--ink-5); margin-bottom: 24px;
    text-wrap: balance;
  }
  .about-standfirst {
    font-family: var(--serif); font-size: 20px; line-height: 1.55;
    color: var(--ink-20); margin-bottom: 40px; padding-bottom: 32px;
    border-bottom: 1px solid var(--paris-85);
    text-wrap: pretty;
  }
  .about-body {
    font-family: var(--serif); font-size: 18px; line-height: 1.7;
    color: var(--ink-10);
  }
  .about-body p { margin-bottom: 1.4em; }
  .about-body p:first-child::first-letter {
    font-family: var(--serif); font-size: 64px; font-weight: 700;
    float: left; line-height: 0.85; margin: 6px 8px 0 0;
    color: var(--ink-5);
  }
  .about-body h2 {
    font-family: var(--serif); font-size: 26px; font-weight: 600;
    margin: 2em 0 0.6em; color: var(--ink-5);
    border-top: 1px solid var(--paris-85); padding-top: 1.6em;
  }

  /* Aside panels */
  .about-panel {
    border-top: 3px solid var(--ink-5);
    padding-top: 16px;
    margin-bottom: 36px;
  }
  .about-panel-head {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--ink-35);
    margin-bottom: 16px;
  }
  .about-contact-item {
    font-size: 14px; font-family: var(--sans); color: var(--ink-20);
    padding: 10px 0; border-bottom: 1px solid var(--paris-85);
    display: flex; flex-direction: column; gap: 2px;
  }
  .about-contact-item:last-child { border-bottom: none; }
  .about-contact-label {
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.08em; color: var(--ink-35);
  }
  .about-contact-value { color: var(--ink-5); }
  .about-contact-value a { color: var(--red); text-decoration: underline; }

  @media (max-width: 900px) {
    .about-wrap { grid-template-columns: 1fr; gap: 0; }
    .about-aside { border-top: 1px solid var(--paris-85); padding-top: 40px; margin-top: 40px; }
    .about-title { font-size: 36px; }
    .about-standfirst { font-size: 18px; }
  }
  @media (max-width: 540px) {
    .about-wrap { padding-top: 32px; }
    .about-title { font-size: 28px; }
    .about-standfirst { font-size: 16px; }
    .about-body { font-size: 17px; }
    .about-body p:first-child::first-letter { font-size: 52px; }
  }
</style>
@endsection

@section('content')
<div class="about-wrap">
  <main class="about-main">
    <p class="about-kicker">About The Herald</p>
    <h1 class="about-title">Local journalism for Western Kentucky</h1>
    <p class="about-standfirst">
      The Paducah Herald covers the people, politics, and events that shape life in
      McCracken County and the surrounding region — from City Hall to the high school
      baseball diamond.
    </p>

    <div class="about-body">
      <p>The Paducah Herald was founded with a single purpose: to give Western Kentucky a
      news organization that treats local stories with the same care and rigor usually
      reserved for national publications. We believe a school board vote, a factory
      closure, or a record-breaking spring sports season matters — not just to the people
      directly involved, but to everyone who lives and works in this region.</p>

      <p>Our coverage area stretches from Paducah and McCracken County outward through the
      Purchase Area — Marshall, Graves, Calloway, Ballard, Carlisle, Hickman, Fulton, and
      McCracken counties. We write about government and courts, education, business and
      economic development, crime and public safety, and the community and cultural life
      that makes Western Kentucky distinct.</p>

      <h2>How we work</h2>

      <p>Every story in The Herald is reported by a journalist who lives in or has deep
      ties to this region. We do not republish wire copy or aggregated national content
      as local news. When we cover a story, we make phone calls, attend meetings, and
      ask the questions that matter to readers here.</p>

      <p>We are editorially independent. Our coverage decisions are made in the newsroom,
      not by advertisers or outside interests. When we make mistakes — and we will —
      we correct them promptly and transparently.</p>

      <h2>Sports coverage</h2>

      <p>Western Kentucky has a rich athletic tradition, and we cover it seriously. The
      Herald follows First Region high school athletics across all sports, tracks
      Murray State University and other regional college programs, and provides
      game coverage, scores, and analysis that local fans expect. Our sports desk
      is on the road for region and state tournaments, and we keep a live scores
      board updated throughout each season.</p>

      <h2>Herald Insider</h2>

      <p>Herald Insider is our in-depth reporting arm — long-form video and audio
      journalism that goes deeper than a daily story can. Insider episodes tackle
      the bigger questions facing the region: economic shifts, community health,
      education outcomes, and the stories that take months to report properly.
      Insider is available to subscribers.</p>

      <h2>Subscribe</h2>

      <p>The Herald is reader-supported. A subscription gives you unlimited access to
      all Herald reporting, Herald Insider video and audio, the Western Kentucky In
      Brief daily digest, and the full weekly E-Edition. Subscriptions start at
      $10 for 30 days. Every subscription directly funds local journalism in
      Western Kentucky.</p>
    </div>
  </main>

  <aside class="about-aside">
    <div class="about-panel">
      <p class="about-panel-head">Contact us</p>
      <div class="about-contact-item">
        <span class="about-contact-label">Newsroom</span>
        <span class="about-contact-value">
          <a href="mailto:news@paducahherald.com">news@paducahherald.com</a>
        </span>
      </div>
      <div class="about-contact-item">
        <span class="about-contact-label">Tips & story ideas</span>
        <span class="about-contact-value">
          <a href="mailto:tips@paducahherald.com">tips@paducahherald.com</a>
        </span>
      </div>
      <div class="about-contact-item">
        <span class="about-contact-label">Advertising</span>
        <span class="about-contact-value">
          <a href="mailto:advertising@paducahherald.com">advertising@paducahherald.com</a>
        </span>
      </div>
      <div class="about-contact-item">
        <span class="about-contact-label">Letters to the editor</span>
        <span class="about-contact-value">
          <a href="mailto:letters@paducahherald.com">letters@paducahherald.com</a>
        </span>
      </div>
      <div class="about-contact-item">
        <span class="about-contact-label">Address</span>
        <span class="about-contact-value">Paducah, Kentucky 42001</span>
      </div>
    </div>

    <div class="about-panel">
      <p class="about-panel-head">Subscribe</p>
      <p style="font-size:14px;font-family:var(--sans);color:var(--ink-20);margin-bottom:16px;line-height:1.5;">
        Support local journalism. Full access for $10 / 30 days.
      </p>
      <a href="{{ route('payment.checkout') }}" class="btn-subscribe"
         style="display:block;text-align:center;padding:12px 20px;border-radius:3px;font-family:var(--sans);font-size:15px;font-weight:700;text-decoration:none;">
        Subscribe now
      </a>
    </div>
  </aside>
</div>
@endsection
