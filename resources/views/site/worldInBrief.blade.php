@extends('layouts.app')

@section('title', 'Western Kentucky in Brief | The Paducah Herald')
@section('description', 'Catch up quickly on the global stories that matter')

@section('styles')
<style>
  .wib-header { padding: 40px 0 0; border-bottom: 1px solid var(--ink-85); }
  .wib-header-inner { max-width: 780px; margin: 0 auto; padding: 0 var(--gutter) 36px; }
  .wib-title {
    font-family: var(--serif); font-size: 52px; font-weight: 500;
    line-height: 1.08; color: var(--ink-5); margin-bottom: 8px; text-wrap: balance;
  }
  .wib-subtitle { font-family: var(--sans); font-size: 16px; color: var(--ink-35); line-height: 1.5; margin-bottom: 20px; }
  .wib-updated { font-size: 12px; font-family: var(--sans); color: var(--ink-70); }
  .wib-hero-img { width: 100%; max-width: 780px; display: block; margin: 0 auto; aspect-ratio: 16/8; object-fit: cover; }
  .wib-body { max-width: 780px; margin: 0 auto; padding: 0 var(--gutter); }
  .brief-item { padding: 28px 0; border-bottom: 1px solid var(--ink-85); }
  .brief-item:last-child { border-bottom: none; }
  .brief-region {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--red); margin-bottom: 8px;
  }
  .brief-headline {
    font-family: var(--serif); font-size: 22px; font-weight: 500;
    line-height: 1.25; color: var(--ink-5); margin-bottom: 10px; text-wrap: balance;
  }
  .brief-text {
    font-family: var(--serif); font-size: 16px; color: var(--ink-20); line-height: 1.6; text-wrap: pretty;
  }
  .wib-footer-spacer { height: 60px; }
</style>
@endsection

@section('content')

<header class="wib-header">
  <div class="wib-header-inner">
    <h1 class="wib-title">Western Kentucky in Brief</h1>
    <p class="wib-subtitle">Catch up quickly on the stories shaping Paducah and the region</p>
    @if($latestBrief)
      <p class="wib-updated">
        Updated {{ \Carbon\Carbon::parse($latestBrief->publish_start_date ?? $latestBrief->updated_at)->diffForHumans() }}
      </p>
    @endif
  </div>
  @if($latestBrief && $latestBrief->imageObject('hero'))
    <img class="wib-hero-img" src="{{ $latestBrief->image('hero', 'default') }}" alt="World in brief" />
  @endif
</header>

<div class="wib-body">
  @forelse($briefs as $brief)
    <div class="brief-item">
      @if($brief->region)
        <p class="brief-region">{{ $brief->region }}</p>
      @endif
      <h2 class="brief-headline">{{ $brief->title }}</h2>
      @if($brief->body)
        <div class="brief-text">{!! $brief->body !!}</div>
      @endif
    </div>
  @empty
    <div class="brief-item">
      <p class="brief-text" style="color:var(--ink-35)">No briefs published yet.</p>
    </div>
  @endforelse
</div>

<div class="wib-footer-spacer"></div>

@endsection
