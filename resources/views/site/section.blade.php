@extends('layouts.app')

@section('title', $section->title . ' | The Paducah Herald')
@section('description', $section->description)

@section('styles')
<style>
  .section-page-header { padding: 36px 0 0; }
  .section-page-header-inner { max-width: var(--max-w); margin: 0 auto; padding: 0 var(--gutter); }
  .section-page-title {
    font-family: var(--serif); font-size: 52px; font-weight: 500;
    line-height: 1.08; color: var(--ink-5); margin-bottom: 10px; text-wrap: balance;
  }
  .section-page-desc {
    font-family: var(--sans); font-size: 15px; color: var(--ink-35);
    line-height: 1.5; max-width: 640px; margin-bottom: 28px;
  }
  .section-page-hero-img {
    width: 100%; aspect-ratio: 21/8; object-fit: cover; object-position: center 30%; display: block;
  }
  .topic-body {
    max-width: var(--max-w); margin: 0 auto;
    padding: 32px var(--gutter) 0;
    display: grid; grid-template-columns: 1fr 280px; gap: 0;
  }
  .topic-main { padding-right: 40px; border-right: 1px solid var(--paris-85); }
  .topic-sidebar { padding-left: 32px; }
  .art-grid-2 {
    display: grid; grid-template-columns: 1fr 1fr; column-gap: 44px;
    padding: 28px 0; border-top: 1px solid var(--ink-85);
  }
  .art-grid-2:first-child { border-top: none; padding-top: 0; }
  .art-grid-2 > .teaser { position: relative; }
  .art-grid-2 > .teaser:last-child::before {
    content: ''; position: absolute; left: -22px; top: 0; bottom: 0;
    width: 1px; background: var(--paris-85);
  }
  .section-empty {
    padding: 40px 0; font-family: var(--serif); font-size: 18px; color: var(--ink-35);
  }
  .pagination-row {
    max-width: var(--max-w); margin: 0 auto;
    padding: 40px var(--gutter); display: flex; justify-content: center; gap: 24px;
  }
  .pagination-next {
    display: inline-flex; align-items: center; gap: 8px;
    font-family: var(--sans); font-size: 16px; font-weight: 600;
    color: var(--ink-5); border-bottom: 2px solid var(--ink-5); padding-bottom: 2px;
  }
  .pagination-next:hover { color: var(--navy-30); border-bottom-color: var(--navy-30); }

  @media (max-width: 900px) {
    .section-page-title { font-size: 36px; }
    .topic-body { grid-template-columns: 1fr; }
    .topic-main { padding-right: 0; border-right: none; }
    .topic-sidebar { display: none; }
  }
  @media (max-width: 540px) {
    .section-page-title { font-size: 28px; }
    .section-page-header { padding-top: 20px; }
    .art-grid-2 { grid-template-columns: 1fr; column-gap: 0; }
    .art-grid-2 > .teaser:last-child::before { display: none; }
    .art-grid-2 > .teaser:last-child { padding-top: 20px; border-top: 1px solid var(--paris-85); }
  }
</style>
@endsection

@section('content')

<header class="section-page-header">
  <div class="section-page-header-inner">
    <h1 class="section-page-title">{{ $section->title }}</h1>
    @if($section->description)
      <p class="section-page-desc">{{ $section->description }}</p>
    @endif
  </div>
  @if($section->imageObject('hero'))
    <img class="section-page-hero-img" src="{{ $section->image('hero', 'default') }}" alt="{{ $section->title }}" />
  @endif
</header>

<div class="topic-body">
  <main class="topic-main">
    @forelse($articles->chunk(2) as $pair)
      <div class="art-grid-2">
        @foreach($pair as $article)
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
            <p class="t-flytitle">{{ $article->fly_title ?: $section->title }}</p>
            <h2 class="t-headline">{{ $article->title }}</h2>
            @if($article->read_time)
              <p class="t-meta">{{ $article->read_time }} min read</p>
            @endif
          </a>
        @endforeach
      </div>
    @empty
      <p class="section-empty">No articles in this section yet.</p>
    @endforelse
  </main>

  <aside class="topic-sidebar">
    <div style="height:90px;background:var(--la-95);display:flex;align-items:center;justify-content:center;font-size:10px;font-family:var(--sans);color:var(--ink-70);letter-spacing:0.08em;text-transform:uppercase;margin-bottom:24px;">Advertisement</div>
  </aside>
</div>

@if($articles->hasPages())
  <div class="pagination-row">
    @if($articles->previousPageUrl())
      <a class="pagination-next" href="{{ $articles->previousPageUrl() }}">← Previous</a>
    @endif
    @if($articles->nextPageUrl())
      <a class="pagination-next" href="{{ $articles->nextPageUrl() }}">Next →</a>
    @endif
  </div>
@endif

@endsection
