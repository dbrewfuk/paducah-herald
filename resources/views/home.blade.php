@extends('layouts.app')

@section('title', 'The Paducah Herald | Local News for Western Kentucky')

@section('styles')
<style>
  /* Desktop hero tweaks — news photos need more visibility than Economist's 0.5 */
  .hero-main .hero-bg { opacity: 0.82; }
  .hero-main .hero-flytitle { color: rgba(255,255,255,0.7); }

  .home-section { padding: 40px 0; }
  .home-section + .home-section { border-top: 1px solid var(--paris-85); }
  .home-section-inner { max-width: var(--max-w); margin: 0 auto; padding: 0 var(--gutter); }
  .home-empty {
    max-width: var(--max-w); margin: 80px auto;
    padding: 0 var(--gutter); text-align: center;
    font-family: var(--serif); font-size: 22px; color: var(--ink-35);
  }

  @media (max-width: 900px) {
    .home-section { padding: 28px 0; }
  }

  /* ── Mobile hero: Economist stacked card layout ─────────────────────
     Full-width image on top, section label + headline + standfirst below.
     Each sidebar story gets the same treatment.
     Uses section.hero prefix (specificity 0,2,1) + !important to beat
     economist.css's own !important rules.                              */
  @media (max-width: 540px) {
    .home-section { padding: 20px 0; }

    /* Outer shell */
    section.hero { background: #fff; border-bottom: none; }
    section.hero .hero-inner {
      display: flex !important;
      flex-direction: column;
    }

    /* ── Main card ── */
    section.hero .hero-main {
      min-height: 0 !important;
      display: flex !important;
      flex-direction: column !important;
      padding: 0 !important;
      overflow: visible;
      background: #fff;
      border-bottom: 1px solid var(--paris-85);
    }
    section.hero .hero-bg {
      position: relative !important;
      inset: auto !important;
      /* Inset from the viewport edges — matches text content gutters */
      width: calc(100% - 2 * var(--gutter)) !important;
      margin: 12px var(--gutter) 0 !important;
      aspect-ratio: 3/2;
      height: auto !important;
      max-height: none !important;
      object-fit: cover;
      opacity: 1 !important;
      order: 0;
      grid-column: unset;
      grid-row: unset;
      flex-shrink: 0;
    }
    section.hero .hero-gradient { display: none !important; }
    section.hero .hero-content {
      position: static !important;
      inset: auto !important;
      padding: 14px var(--gutter) 22px !important;
      background: #fff;
      grid-column: unset;
      grid-row: unset;
    }
    section.hero .hero-flytitle {
      color: var(--red) !important;
      margin-bottom: 6px;
    }
    section.hero .hero-headline {
      font-size: 22px !important;
      color: var(--ink-5) !important;
      margin-bottom: 8px;
      line-height: 1.2;
    }
    section.hero .hero-desc {
      display: -webkit-box !important;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      font-size: 15px;
      color: var(--ink-20);
      font-family: var(--serif);
      line-height: 1.5;
    }
    section.hero .hero-read-time {
      display: block;
      margin-top: 10px;
      font-size: 12px;
      font-family: var(--sans);
      color: var(--ink-35);
    }

    /* ── Sidebar cards: 2-column grid ── */
    section.hero .hero-sidebar {
      display: grid !important;
      grid-template-columns: 1fr 1fr !important;
      overflow: visible;
      background: #fff;
      padding: 0 !important;
      border-top: 1px solid var(--paris-85);
      gap: 0;
    }
    section.hero .hero-sidebar-item {
      display: flex !important;
      flex-direction: column !important;
      gap: 0 !important;
      min-width: 0;
      border-top: none;
      border-right: none !important;
      border-bottom: 1px solid var(--paris-85);
      padding: 0 !important;
      align-items: stretch;
    }
    /* Left column: right border as column divider */
    section.hero .hero-sidebar-item:nth-child(odd) {
      border-right: 1px solid var(--paris-85) !important;
    }
    section.hero .hero-sidebar-img {
      order: -1;
      width: 100% !important;
      aspect-ratio: 4/3;
      height: auto !important;
      max-height: none !important;
      object-fit: cover;
      flex: none;
      margin-bottom: 0 !important;
    }
    section.hero .hero-sidebar-text {
      flex: 1;
      padding: 9px 10px 12px;
      min-width: 0;
    }
    section.hero .hero-sidebar-label {
      color: var(--red) !important;
      margin-bottom: 4px;
    }
    section.hero .hero-sidebar-headline {
      font-size: 14px !important;
      color: var(--ink-5) !important;
      line-height: 1.3;
    }
    section.hero .hero-sidebar-readtime {
      display: block;
      margin-top: 6px;
      font-size: 11px;
      font-family: var(--sans);
      color: var(--ink-35);
    }
  }
</style>
@endsection

@section('content')

@if($featured)
<section class="hero">
  <div class="hero-inner">

    {{-- Main feature --}}
    <a class="hero-main" href="{{ route('articles.show', $featured->slug) }}">
      @if($featured->imageObject('hero'))
        <img class="hero-bg" src="{{ $featured->image('hero', 'default') }}" alt="{{ $featured->title }}" />
      @elseif($featured->hero_image_url)
        <img class="hero-bg" src="{{ $featured->hero_image_url }}" alt="{{ $featured->title }}" />
      @else
        <div style="position:absolute;inset:0;background:var(--ink-20)"></div>
      @endif
      <div class="hero-gradient"></div>
      <div class="hero-content">
        @if($featured->fly_title)
          <div class="hero-flytitle">{{ $featured->fly_title }}</div>
        @elseif($featured->section)
          <div class="hero-flytitle">{{ $featured->section->title }}</div>
        @endif
        <h1 class="hero-headline">{{ $featured->title }}</h1>
        @if($featured->standfirst)
          <p class="hero-desc">{{ $featured->standfirst }}</p>
        @endif
        @if($featured->read_time)
          <span class="hero-read-time">{{ $featured->read_time }} min read</span>
        @endif
      </div>
    </a>

    {{-- Sidebar stories --}}
    <aside class="hero-sidebar">
      @foreach($rest->take(4) as $article)
        <a class="hero-sidebar-item" href="{{ route('articles.show', $article->slug) }}">
          @if($article->imageObject('hero'))
            <img class="hero-sidebar-img" src="{{ $article->image('hero', 'default') }}" alt="{{ $article->title }}" />
          @elseif($article->hero_image_url)
            <img class="hero-sidebar-img" src="{{ $article->hero_image_url }}" alt="{{ $article->title }}" />
          @endif
          <div class="hero-sidebar-text">
            <div class="hero-sidebar-label">
              {{ $article->fly_title ?: ($article->section ? $article->section->title : 'Article') }}
            </div>
            <div class="hero-sidebar-headline">{{ $article->title }}</div>
            @if($article->read_time)
              <span class="hero-sidebar-readtime">{{ $article->read_time }} min read</span>
            @endif
          </div>
        </a>
      @endforeach
    </aside>

  </div>
</section>

@if($rest->count() > 3)
<section class="home-section">
  <div class="home-section-inner">
    <div class="sec-head" style="border-top-color:var(--paris-85)">
      <span class="sec-head-title" style="font-size:14px;font-weight:400;color:var(--ink-35)">More articles</span>
    </div>
    <div class="grid-3">
      @foreach($rest->skip(3) as $article)
        <a class="teaser" href="{{ route('articles.show', $article->slug) }}">
          @if($article->imageObject('hero'))
            <div class="t-img-wrap">
              <img class="t-img" src="{{ $article->image('hero', 'default') }}" alt="{{ $article->title }}" />
            </div>
          @elseif($article->hero_image_url)
            <div class="t-img-wrap">
              <img class="t-img" src="{{ $article->hero_image_url }}" alt="{{ $article->title }}" />
            </div>
          @endif
          <p class="t-flytitle">{{ $article->fly_title ?: ($article->section ? $article->section->title : '') }}</p>
          <h3 class="t-headline">{{ $article->title }}</h3>
          @if($article->standfirst)
            <p class="t-desc">{{ Str::limit($article->standfirst, 100) }}</p>
          @endif
          @if($article->read_time)
            <div class="t-meta">{{ $article->read_time }} min read</div>
          @endif
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

@else
<div class="home-empty">
  <p>No articles published yet.</p>
</div>
@endif

@endsection
