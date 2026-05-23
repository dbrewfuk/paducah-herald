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

  /* ── Mobile hero: compact cover card ──────────────────────────────────
     These rules live HERE (inline, loads last) so they beat economist.css
     regardless of cascade order. Uses section.hero specificity bump.    */
  @media (max-width: 540px) {
    .home-section { padding: 20px 0; }

    section.hero { background: #fff; border-bottom: 1px solid var(--paris-85); }
    section.hero .hero-inner { display: block; }

    section.hero .hero-main {
      min-height: 0;
      display: grid;
      grid-template-columns: 1fr 110px;
      column-gap: 14px;
      align-items: start;
      padding: 16px var(--gutter) 20px;
      overflow: visible;
      background: #fff;
    }
    section.hero .hero-bg {
      position: relative;
      inset: auto;
      width: 100%;
      height: 78px;
      object-fit: cover;
      opacity: 1;
      grid-column: 2;
      grid-row: 1;
    }
    section.hero .hero-gradient { display: none; }
    section.hero .hero-content {
      position: static;
      padding: 0;
      grid-column: 1;
      grid-row: 1;
    }
    section.hero .hero-flytitle { color: var(--red); margin-bottom: 5px; }
    section.hero .hero-headline {
      font-size: 19px;
      color: var(--ink-5);
      margin-bottom: 6px;
      line-height: 1.2;
    }
    section.hero .hero-desc {
      display: block;
      font-size: 13px;
      color: var(--ink-35);
      font-family: var(--serif);
      -webkit-line-clamp: 2;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    /* Sidebar as stacked compact rows */
    section.hero .hero-sidebar {
      display: block;
      overflow: visible;
      background: #fff;
      padding: 0 var(--gutter);
      border-top: none;
    }
    section.hero .hero-sidebar-item {
      display: flex;
      flex-direction: row;
      gap: 12px;
      align-items: flex-start;
      min-width: 0;
      border-top: 1px solid var(--paris-85);
      border-right: none;
      padding: 13px 0;
    }
    section.hero .hero-sidebar-text { flex: 1 1 0; min-width: 0; }
    section.hero .hero-sidebar-img {
      order: 2;
      flex: 0 0 72px;
      width: 72px;
      height: 54px;
      object-fit: cover;
      aspect-ratio: unset;
      margin-bottom: 0;
    }
    section.hero .hero-sidebar-label { color: var(--red); }
    section.hero .hero-sidebar-headline { font-size: 14px; color: var(--ink-5); }
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
      </div>
    </a>

    {{-- Sidebar stories --}}
    <aside class="hero-sidebar">
      @foreach($rest->take(3) as $article)
        <a class="hero-sidebar-item" href="{{ route('articles.show', $article->slug) }}">
          <div class="hero-sidebar-text">
            <div class="hero-sidebar-label">
              {{ $article->fly_title ?: ($article->section ? $article->section->title : 'Article') }}
            </div>
            <div class="hero-sidebar-headline">{{ $article->title }}</div>
          </div>
          @if($article->imageObject('hero'))
            <img class="hero-sidebar-img" src="{{ $article->image('hero', 'default') }}" alt="{{ $article->title }}" />
          @elseif($article->hero_image_url)
            <img class="hero-sidebar-img" src="{{ $article->hero_image_url }}" alt="{{ $article->title }}" />
          @endif
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
