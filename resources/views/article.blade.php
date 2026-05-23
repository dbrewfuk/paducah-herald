@extends('layouts.app')

@section('title', $article->title . ' | The Paducah Herald')
@section('description', $article->standfirst)

@section('styles')
<style>
  .art-header { max-width: 740px; margin: 0 auto; padding: 36px var(--gutter) 0; }
  .art-flytitle {
    font-size: 13px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.08em; text-transform: uppercase; color: var(--red);
    margin-bottom: 14px; display: block;
  }
  .art-title {
    font-family: var(--serif); font-size: 40px; font-weight: 500;
    line-height: 1.12; color: var(--ink-5); margin-bottom: 16px; text-wrap: balance;
  }
  .art-standfirst {
    font-family: var(--serif); font-size: 20px; color: var(--ink-35);
    line-height: 1.45; margin-bottom: 20px; text-wrap: pretty;
  }
  .art-byline {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 0; border-top: 1px solid var(--ink-85); border-bottom: 1px solid var(--ink-85);
    margin-bottom: 28px;
  }
  .art-byline-text { flex: 1; }
  .art-byline-date { font-size: 13px; font-family: var(--sans); color: var(--ink-35); }
  .art-byline-meta { font-size: 12px; font-family: var(--sans); color: var(--ink-70); margin-top: 3px; }
  .art-share-btn {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 13px; font-family: var(--sans); color: var(--ink-35);
    border: 1.5px solid var(--ink-85); border-radius: 100px; padding: 7px 16px;
    transition: border-color var(--transition), color var(--transition);
  }
  .art-share-btn:hover { border-color: var(--ink-35); color: var(--ink-5); }
  .art-hero { max-width: 740px; margin: 0 auto; padding: 0 var(--gutter) 28px; }
  .art-hero-img { width: 100%; aspect-ratio: 16/9; object-fit: cover; display: block; }
  .art-hero-caption { font-size: 12px; font-family: var(--sans); color: var(--ink-70); margin-top: 8px; line-height: 1.4; }
  .art-body-wrap {
    max-width: var(--max-w); margin: 0 auto; padding: 0 var(--gutter);
    display: grid; grid-template-columns: 1fr 280px; gap: 0;
  }
  .art-body-main { padding-right: 40px; border-right: 1px solid var(--paris-85); }
  .art-sidebar { padding-left: 32px; }
  .art-text { max-width: 680px; }
  .art-text p {
    font-family: var(--serif); font-size: 18px; color: var(--ink-10);
    line-height: 1.7; margin-bottom: 22px; text-wrap: pretty;
  }
  .art-text p:first-child::first-letter {
    font-family: var(--serif); font-size: 64px; font-weight: 700;
    float: left; line-height: 0.85; margin: 6px 8px 0 0; color: var(--ink-5);
  }
  .art-text a { color: var(--navy-45); text-decoration: underline; }
  .art-sidebar-head {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--ink-35);
    margin-bottom: 16px; padding-top: 4px; border-top: 3px solid var(--ink-5);
  }
  .art-sidebar-item {
    padding: 14px 0; border-top: 1px solid var(--paris-85); display: block;
  }
  .art-sidebar-item:first-of-type { border-top: none; padding-top: 0; }
  .art-sidebar-tag { font-size: 11px; font-family: var(--sans); color: var(--red); margin-bottom: 4px; }
  .art-sidebar-title {
    font-family: var(--serif); font-size: 16px; font-weight: 500;
    color: var(--ink-5); line-height: 1.3; text-wrap: balance;
  }
  .art-sidebar-item:hover .art-sidebar-title { color: var(--navy-30); text-decoration: underline; }
  .art-sidebar-meta { font-size: 12px; font-family: var(--sans); color: var(--ink-70); margin-top: 3px; }
  .art-footer-spacer { height: 40px; }
</style>
@endsection

@section('content')

<header class="art-header">
  @if($article->fly_title)
    <a class="art-flytitle" href="{{ $article->section ? route('sections.show', $article->section->slug) : route('home') }}">{{ $article->fly_title }}</a>
  @elseif($article->section)
    <a class="art-flytitle" href="{{ route('sections.show', $article->section->slug) }}">{{ $article->section->title }}</a>
  @endif

  <h1 class="art-title">{{ $article->title }}</h1>

  @if($article->standfirst)
    <p class="art-standfirst">{{ $article->standfirst }}</p>
  @endif

  <div class="art-byline">
    <div class="art-byline-text">
      <p class="art-byline-date">
        {{ \Carbon\Carbon::parse($article->publish_start_date ?? $article->created_at)->format('F jS Y') }}
      </p>
      @if($article->read_time)
        <p class="art-byline-meta">{{ $article->read_time }} min read</p>
      @endif
    </div>
    <a class="art-share-btn" href="#">Share</a>
    <a class="art-share-btn" href="#">Save</a>
  </div>
</header>

@if($article->imageObject('hero'))
  <div class="art-hero">
    <img class="art-hero-img" src="{{ $article->image('hero', 'default') }}" alt="{{ $article->title }}" />
  </div>
@elseif($article->hero_image_url)
  <div class="art-hero">
    <img class="art-hero-img" src="{{ $article->hero_image_url }}" alt="{{ $article->title }}" />
  </div>
@endif

<div class="art-body-wrap">
  <main class="art-body-main">
    <div class="art-text">
      {!! $article->body !!}
    </div>
  </main>

  <aside class="art-sidebar">
    @if($article->section)
      <p class="art-sidebar-head">Also in {{ $article->section->title }}</p>
      @foreach($relatedArticles as $related)
        <a class="art-sidebar-item" href="{{ route('articles.show', $related->slug) }}">
          <p class="art-sidebar-tag">{{ $related->fly_title ?: $article->section->title }}</p>
          <p class="art-sidebar-title">{{ $related->title }}</p>
          @if($related->read_time)
            <p class="art-sidebar-meta">{{ $related->read_time }} min read</p>
          @endif
        </a>
      @endforeach
    @endif
  </aside>
</div>

<div class="art-footer-spacer"></div>

@endsection
