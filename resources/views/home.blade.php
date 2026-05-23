@extends('layouts.app')

@section('title', 'The Paducah Herald | Local News for Western Kentucky')

@section('styles')
<style>
  /* Override hero image opacity — Economist dims to 0.5 for their palette;
     news photos need to be more visible */
  .hero-main .hero-bg { opacity: 0.82; }

  /* Herald uses navy for section labels, not red */
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
  @media (max-width: 540px) {
    .home-section { padding: 20px 0; }
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
          <div class="hero-sidebar-label">
            {{ $article->fly_title ?: ($article->section ? $article->section->title : 'Article') }}
          </div>
          @if($article->imageObject('hero'))
            <img class="hero-sidebar-img" src="{{ $article->image('hero', 'default') }}" alt="{{ $article->title }}" />
          @elseif($article->hero_image_url)
            <img class="hero-sidebar-img" src="{{ $article->hero_image_url }}" alt="{{ $article->title }}" />
          @endif
          <div class="hero-sidebar-headline">{{ $article->title }}</div>
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
