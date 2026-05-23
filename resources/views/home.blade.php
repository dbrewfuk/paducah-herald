@extends('layouts.app')

@section('title', 'The Paducah Herald | Local News for Western Kentucky')

@section('styles')
<style>
  .home-hero {
    background: var(--ink-5); color: #fff;
    padding: 40px 0 0;
  }
  .home-hero-inner {
    max-width: var(--max-w); margin: 0 auto;
    padding: 0 var(--gutter) 40px;
    display: grid; grid-template-columns: 1fr 320px; gap: 48px; align-items: start;
  }
  @media (max-width: 900px) {
    .home-hero-inner { grid-template-columns: 1fr; gap: 0; padding-bottom: 0; }
    .hero-sidebar { display: flex; overflow-x: auto; scrollbar-width: none; gap: 0; padding: 0; background: var(--ink-10); }
    .hero-sidebar::-webkit-scrollbar { display: none; }
    .hero-sidebar-item { min-width: 220px; flex-shrink: 0; border-top: none; border-right: 1px solid rgba(255,255,255,0.1); padding: 16px; }
    .hero-headline { font-size: 26px; }
    .hero-desc { font-size: 14px; }
  }
  @media (max-width: 540px) {
    .home-hero-img { aspect-ratio: 4/3; }
    .hero-content { padding: 20px 16px; }
    .hero-headline { font-size: 22px; }
    .hero-desc { display: none; }
    .hero-sidebar-item { min-width: 180px; }
    .hero-sidebar-headline { font-size: 15px; }
  }
  .hero-main-link { display: block; position: relative; }
  .home-hero-img {
    width: 100%; aspect-ratio: 16/9; object-fit: cover; display: block;
    position: relative; height: auto; opacity: 1;
  }
  .hero-gradient {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.1) 60%, transparent 100%);
  }
  .hero-content {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 28px 24px;
  }
  .hero-flytitle {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.65);
    margin-bottom: 10px;
  }
  .hero-headline {
    font-family: var(--serif); font-size: 32px; font-weight: 500;
    line-height: 1.12; color: #fff; margin-bottom: 10px;
    text-wrap: balance;
  }
  .hero-desc {
    font-family: var(--sans); font-size: 15px; color: rgba(255,255,255,0.75);
    line-height: 1.4; margin-bottom: 0;
  }
  .hero-sidebar { padding-top: 8px; }
  .hero-sidebar-item {
    display: block; padding: 16px 0; border-top: 1px solid rgba(255,255,255,0.15);
  }
  .hero-sidebar-item:first-child { border-top: none; padding-top: 0; }
  .hero-sidebar-label {
    font-size: 10px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.45);
    margin-bottom: 8px;
  }
  .hero-sidebar-img {
    width: 100%; aspect-ratio: 3/2; object-fit: cover; display: block; margin-bottom: 10px;
  }
  .hero-sidebar-headline {
    font-family: var(--serif); font-size: 17px; color: rgba(255,255,255,0.9);
    line-height: 1.3; text-wrap: balance;
  }
  .home-section { padding: 40px 0; }
  .home-section + .home-section { border-top: 1px solid var(--paris-85); }
  .home-section-inner { max-width: var(--max-w); margin: 0 auto; padding: 0 var(--gutter); }
  .home-empty {
    max-width: var(--max-w); margin: 80px auto;
    padding: 0 var(--gutter); text-align: center;
    font-family: var(--serif); font-size: 22px; color: var(--ink-35);
  }
</style>
@endsection

@section('content')

@if($featured)
<section class="home-hero">
  <div class="home-hero-inner">
    <a class="hero-main-link" href="{{ route('articles.show', $featured->slug) }}">
      @if($featured->imageObject('hero'))
        <img class="home-hero-img" src="{{ $featured->image('hero', 'default') }}" alt="{{ $featured->title }}" />
      @elseif($featured->hero_image_url)
        <img class="home-hero-img" src="{{ $featured->hero_image_url }}" alt="{{ $featured->title }}" />
      @else
        <div class="home-hero-img" style="background:var(--ink-20)"></div>
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
