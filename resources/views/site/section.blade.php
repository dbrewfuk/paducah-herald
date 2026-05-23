@extends('layouts.app')

@section('title', $section->title . ' | The Paducah Herald')
@section('description', $section->description)

@section('styles')
<style>
  /* ── Section header ─────────────────────────────────────────────── */
  .section-page-header { padding: 36px 0 0; }
  .section-page-header-inner {
    max-width: var(--max-w); margin: 0 auto; padding: 0 var(--gutter);
  }
  .section-page-title {
    font-family: var(--serif); font-size: 52px; font-weight: 500;
    line-height: 1.08; color: var(--ink-5); margin-bottom: 10px; text-wrap: balance;
  }
  .section-page-desc {
    font-family: var(--sans); font-size: 15px; color: var(--ink-35);
    line-height: 1.5; max-width: 640px; margin-bottom: 20px;
  }
  .section-page-hero-img {
    width: 100%; aspect-ratio: 21/8; object-fit: cover; object-position: center 30%; display: block;
  }

  /* Follow button */
  .follow-btn {
    display: inline-flex; align-items: center; gap: 7px;
    font-family: var(--sans); font-size: 14px; font-weight: 600;
    color: var(--ink-5); border: 1.5px solid var(--ink-5);
    border-radius: 999px; padding: 8px 18px;
    background: transparent; cursor: pointer;
    transition: background 0.15s, color 0.15s;
    margin-bottom: 28px;
  }
  .follow-btn:hover { background: var(--ink-5); color: #fff; }
  .follow-btn.is-following {
    background: var(--ink-5); color: #fff; border-color: var(--ink-5);
  }
  .follow-btn-icon {
    display: inline-flex; align-items: center; justify-content: center;
    width: 18px; height: 18px; border: 1.5px solid currentColor;
    border-radius: 50%; font-size: 14px; line-height: 1; flex-shrink: 0;
    transition: transform 0.2s;
  }
  .follow-btn.is-following .follow-btn-icon { transform: rotate(45deg); }

  /* ── Body layout ────────────────────────────────────────────────── */
  .topic-body {
    max-width: var(--max-w); margin: 0 auto;
    padding: 32px var(--gutter) 0;
    display: grid; grid-template-columns: 1fr 280px; gap: 0;
  }
  .topic-main { padding-right: 40px; border-right: 1px solid var(--paris-85); }
  .topic-sidebar { padding-left: 32px; }

  /* ── Desktop article grid ───────────────────────────────────────── */
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
  .t-text { display: contents; } /* transparent on desktop */

  .section-empty {
    padding: 40px 0; font-family: var(--serif); font-size: 18px; color: var(--ink-35);
  }

  /* ── Pagination ─────────────────────────────────────────────────── */
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

  /* ── Scores board ───────────────────────────────────────────────── */
  .scores-board { margin-bottom: 32px; }
  .scores-board-head {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--ink-35);
    padding-bottom: 10px; border-bottom: 3px solid var(--ink-5); margin-bottom: 0;
  }
  .scores-sport-label {
    font-size: 10px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--red); padding: 14px 0 6px;
  }
  .scores-row { padding: 10px 0; border-bottom: 1px solid var(--paris-85); }
  .scores-row:last-of-type { border-bottom: none; }
  .scores-teams { margin-bottom: 4px; }
  .scores-team {
    display: flex; justify-content: space-between; align-items: baseline; padding: 1px 0;
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
  .scores-status { font-size: 11px; font-family: var(--sans); color: var(--ink-35); }
  .scores-status--final { color: var(--ink-35); }
  .scores-status--ppd { color: #c44; }
  .scores-venue { font-size: 11px; font-family: var(--sans); color: var(--ink-70); }
  .scores-empty { font-size: 13px; font-family: var(--sans); color: var(--ink-70); padding: 16px 0; }

  /* ── Tablet ─────────────────────────────────────────────────────── */
  @media (max-width: 900px) {
    .section-page-title { font-size: 36px; }
    .topic-body { grid-template-columns: 1fr; }
    .topic-main { padding-right: 0; border-right: none; }
    .topic-sidebar { display: none; }
  }

  /* ── Mobile: Economist list layout ─────────────────────────────── */
  @media (max-width: 540px) {
    /* Header: centred */
    .section-page-header { padding-top: 28px; text-align: center; }
    .section-page-title {
      font-size: 32px; text-align: center; margin-bottom: 12px;
    }
    .section-page-desc {
      font-style: italic; font-family: var(--serif);
      font-size: 15px; text-align: center;
      max-width: none; margin-bottom: 20px;
    }
    .follow-btn { margin-bottom: 24px; }

    .topic-body { padding: 0; }
    .topic-main { padding-right: 0; border-right: none; }

    /* Undo 2-col grid — each pair becomes a vertical stack */
    .art-grid-2 {
      display: block !important;
      padding: 0; border-top: none;
    }

    /* Each article becomes a compact horizontal row */
    .art-grid-2 > .teaser {
      display: flex !important;
      flex-direction: row;
      align-items: flex-start;
      gap: 14px;
      padding: 16px var(--gutter);
      border-top: 1px solid var(--paris-85);
      position: static;
    }
    .art-grid-2 > .teaser:last-child::before { display: none; }

    /* Text group on the left */
    .t-text {
      display: block !important;
      flex: 1 1 0;
      min-width: 0;
    }
    .t-flytitle {
      font-family: var(--sans); font-size: 11px; font-weight: 700;
      letter-spacing: 0.08em; text-transform: uppercase;
      color: var(--red); margin-bottom: 5px;
    }
    .t-headline {
      font-family: var(--serif); font-size: 17px; font-weight: 600;
      color: var(--ink-5); line-height: 1.25; margin-bottom: 6px;
    }
    .t-desc {
      font-family: var(--serif); font-size: 13px; color: var(--ink-35);
      line-height: 1.45; margin-bottom: 5px;
      display: -webkit-box; -webkit-line-clamp: 2;
      -webkit-box-orient: vertical; overflow: hidden;
    }
    .t-meta {
      font-family: var(--sans); font-size: 11px; color: var(--ink-35);
    }

    /* Thumbnail on the right */
    .t-img-wrap {
      order: 2;
      flex: 0 0 96px;
      width: 96px;
      height: 72px;
      overflow: hidden;
    }
    .t-img {
      width: 96px; height: 72px;
      object-fit: cover;
      display: block;
    }
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
    <button
      class="follow-btn"
      data-section="{{ $section->slug }}"
      aria-label="Follow {{ $section->title }}"
    >
      <span class="follow-btn-icon">+</span>
      <span class="follow-btn-label">Follow topic</span>
    </button>
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
            <div class="t-text">
              <p class="t-flytitle">{{ $article->fly_title ?: $section->title }}</p>
              <h2 class="t-headline">{{ $article->title }}</h2>
              @if($article->standfirst)
                <p class="t-desc">{{ Str::limit($article->standfirst, 90) }}</p>
              @endif
              @if($article->read_time)
                <p class="t-meta">{{ $article->read_time }} min read</p>
              @endif
            </div>
          </a>
        @endforeach
      </div>
    @empty
      <p class="section-empty">No articles in this section yet.</p>
    @endforelse
  </main>

  <aside class="topic-sidebar">
    @if($scores !== null)
      <div class="scores-board">
        <div class="scores-board-head">First Region Scores</div>
        @php $bySport = $scores->groupBy('sport'); @endphp
        @forelse($bySport as $sport => $games)
          <div class="scores-sport-label">{{ $sport }}</div>
          @foreach($games as $game)
            <div class="scores-row">
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
                    {{ $game->game_date ? $game->game_date->format('M j') : 'TBD' }}{{ $game->game_date ? ' · ' . $game->game_date->format('g:i a') : '' }}
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

<script>
(function () {
  var btn = document.querySelector('.follow-btn');
  if (!btn) return;
  var slug = btn.dataset.section;
  var key  = 'herald_followed_sections';

  function getFollowed() {
    try { return JSON.parse(localStorage.getItem(key) || '[]'); } catch(e) { return []; }
  }
  function setFollowing(on) {
    var list = getFollowed();
    if (on) { if (!list.includes(slug)) list.push(slug); }
    else     { list = list.filter(function(s){ return s !== slug; }); }
    localStorage.setItem(key, JSON.stringify(list));
    render(on);
  }
  function render(following) {
    btn.classList.toggle('is-following', following);
    btn.querySelector('.follow-btn-label').textContent = following ? 'Following' : 'Follow topic';
  }

  // Init
  render(getFollowed().includes(slug));

  btn.addEventListener('click', function () {
    setFollowing(!getFollowed().includes(slug));
  });
})();
</script>

@endsection
