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

  /* ── Scores board ─────────────────────────────── */
  .scores-board { margin-bottom: 32px; }
  .scores-board-head {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--ink-35);
    padding-bottom: 10px; border-bottom: 3px solid var(--ink-5);
    margin-bottom: 0;
  }
  .scores-sport-label {
    font-size: 10px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--red);
    padding: 14px 0 6px;
  }
  .scores-row {
    padding: 10px 0;
    border-bottom: 1px solid var(--paris-85);
  }
  .scores-row:last-of-type { border-bottom: none; }
  .scores-teams { margin-bottom: 4px; }
  .scores-team {
    display: flex; justify-content: space-between; align-items: baseline;
    padding: 1px 0;
  }
  .scores-team-name {
    font-family: var(--sans); font-size: 13px; color: var(--ink-20);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1;
  }
  .scores-team--winner .scores-team-name { font-weight: 700; color: var(--ink-5); }
  .scores-score {
    font-family: var(--sans); font-size: 13px; font-weight: 700;
    color: var(--ink-5); margin-left: 8px; flex-shrink: 0;
  }
  .scores-meta { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
  .scores-status {
    font-size: 11px; font-family: var(--sans); color: var(--ink-35);
  }
  .scores-status--final { color: var(--ink-35); }
  .scores-status--ppd { color: #c44; }
  .scores-venue {
    font-size: 11px; font-family: var(--sans); color: var(--ink-70);
  }
  .scores-empty {
    font-size: 13px; font-family: var(--sans); color: var(--ink-70);
    padding: 16px 0;
  }

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
    {{-- Scores board on Sports section --}}
    @if($scores !== null)
      <div class="scores-board">
        <div class="scores-board-head">First Region Scores</div>

        @php
          $bySport = $scores->groupBy('sport');
        @endphp

        @forelse($bySport as $sport => $games)
          <div class="scores-sport-label">{{ $sport }}</div>
          @foreach($games as $game)
            <div class="scores-row {{ $game->status === 'upcoming' ? 'scores-row--upcoming' : '' }}">
              <div class="scores-teams">
                <div class="scores-team {{ $game->is_final && $game->home_score > $game->away_score ? 'scores-team--winner' : '' }}">
                  <span class="scores-team-name">{{ $game->home_team }}</span>
                  @if($game->is_final)<span class="scores-score">{{ $game->home_score }}</span>@endif
                </div>
                <div class="scores-team {{ $game->is_final && $game->away_score > $game->home_score ? 'scores-team--winner' : '' }}">
                  <span class="scores-team-name">{{ $game->away_team }}</span>
                  @if($game->is_final)<span class="scores-score">{{ $game->away_score }}</span>@endif
                </div>
              </div>
              <div class="scores-meta">
                @if($game->status === 'final')
                  <span class="scores-status scores-status--final">Final{{ $game->notes ? ' · ' . $game->notes : '' }}</span>
                @elseif($game->status === 'postponed')
                  <span class="scores-status scores-status--ppd">Postponed</span>
                @else
                  <span class="scores-status">
                    {{ $game->game_date ? $game->game_date->format('M j') : 'TBD' }}
                    {{ $game->game_date ? ' · ' . $game->game_date->format('g:i a') : '' }}
                  </span>
                  @if($game->venue)<span class="scores-venue">{{ $game->venue }}</span>@endif
                @endif
              </div>
            </div>
          @endforeach
        @empty
          <p class="scores-empty">No scores yet.</p>
        @endforelse
      </div>
    @else
      <div style="height:90px;background:var(--la-95);display:flex;align-items:center;justify-content:center;font-size:10px;font-family:var(--sans);color:var(--ink-70);letter-spacing:0.08em;text-transform:uppercase;margin-bottom:24px;">Advertisement</div>
    @endif
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
