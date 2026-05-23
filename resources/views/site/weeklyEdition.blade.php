@extends('layouts.app')

@section('title', ($edition->title ?? 'E-Edition') . ' | The Paducah Herald')

@section('styles')
<style>
  .edition-header { padding: 36px 0 0; border-bottom: 1px solid var(--ink-85); }
  .edition-header-inner {
    max-width: var(--max-w); margin: 0 auto; padding: 0 var(--gutter);
    display: grid; grid-template-columns: 1fr 480px; gap: 48px; align-items: end;
  }
  .edition-date {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--ink-35); margin-bottom: 14px;
  }
  .edition-title {
    font-family: var(--serif); font-size: 52px; font-weight: 500;
    line-height: 1.08; color: var(--ink-5); margin-bottom: 24px; text-wrap: balance;
  }
  .edition-controls { display: flex; gap: 12px; align-items: center; padding-bottom: 28px; }
  .edition-btn {
    padding: 8px 18px; border-radius: 100px; font-size: 14px;
    font-family: var(--sans); font-weight: 600; white-space: nowrap;
  }
  .edition-btn-primary { background: var(--navy-20); color: #fff; }
  .edition-btn-primary:hover { background: var(--navy-30); }
  .edition-btn-outline { background: transparent; color: var(--ink-20); border: 1.5px solid var(--ink-85); }
  .edition-btn-outline:hover { border-color: var(--ink-35); }
  .edition-cover-img { width: 100%; aspect-ratio: 3/4; object-fit: cover; object-position: center top; display: block; }
  .edition-cover-placeholder {
    width: 100%; aspect-ratio: 3/4; background: var(--ink-85);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-family: var(--sans); color: var(--ink-70);
  }
  .edition-body { max-width: var(--max-w); margin: 40px auto; padding: 0 var(--gutter); }
  .edition-meta { font-family: var(--sans); font-size: 15px; color: var(--ink-35); line-height: 1.6; max-width: 640px; }
  .edition-list-header { max-width: var(--max-w); margin: 0 auto; padding: 40px var(--gutter) 28px; }
  .edition-list-title {
    font-family: var(--serif); font-size: 52px; font-weight: 500;
    color: var(--ink-5); margin-bottom: 8px; text-wrap: balance;
  }
  .edition-list-desc { font-family: var(--sans); font-size: 15px; color: var(--ink-35); }
  .edition-grid {
    max-width: var(--max-w); margin: 0 auto; padding: 0 var(--gutter) 60px;
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px;
  }
  .edition-card { display: block; }
  .edition-card-img { width: 100%; aspect-ratio: 3/4; object-fit: cover; display: block; margin-bottom: 14px; }
  .edition-card-placeholder { width: 100%; aspect-ratio: 3/4; background: var(--ink-90); margin-bottom: 14px; }
  .edition-card-date {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.08em; text-transform: uppercase; color: var(--ink-35); margin-bottom: 6px;
  }
  .edition-card-title { font-family: var(--serif); font-size: 18px; font-weight: 500; color: var(--ink-5); line-height: 1.3; }
  .edition-card:hover .edition-card-title { color: var(--navy-30); text-decoration: underline; }
</style>
@endsection

@section('content')

@if(isset($edition))
  <header class="edition-header">
    <div class="edition-header-inner">
      <div>
        @if($edition->edition_date)
          <p class="edition-date">{{ \Carbon\Carbon::parse($edition->edition_date)->format('F jS Y') }}</p>
        @endif
        <h1 class="edition-title">{{ $edition->title }}</h1>
        <div class="edition-controls">
          <a class="edition-btn edition-btn-primary" href="#">Read this edition</a>
          <a class="edition-btn edition-btn-outline" href="#">Download PDF</a>
        </div>
      </div>
      <div>
        @if($edition->imageObject('cover'))
          <img class="edition-cover-img" src="{{ $edition->image('cover', 'default') }}" alt="{{ $edition->title }}" />
        @else
          <div class="edition-cover-placeholder">No cover image</div>
        @endif
      </div>
    </div>
  </header>
  <div class="edition-body">
    <p class="edition-meta">Browse this edition of <em>The Paducah Herald</em>.</p>
  </div>

@else
  <div class="edition-list-header">
    <h1 class="edition-list-title">Weekly editions</h1>
    <p class="edition-list-desc">Browse past and current issues of <em>The Paducah Herald</em>.</p>
  </div>
  <div class="edition-grid">
    @forelse($editions as $ed)
      <a class="edition-card" href="{{ route('weekly-edition.show', $ed->slug) }}">
        @if($ed->imageObject('cover'))
          <img class="edition-card-img" src="{{ $ed->image('cover', 'default') }}" alt="{{ $ed->title }}" />
        @else
          <div class="edition-card-placeholder"></div>
        @endif
        @if($ed->edition_date)
          <p class="edition-card-date">{{ \Carbon\Carbon::parse($ed->edition_date)->format('M j, Y') }}</p>
        @endif
        <p class="edition-card-title">{{ $ed->title }}</p>
      </a>
    @empty
      <p style="font-family:var(--serif);font-size:18px;color:var(--ink-35);grid-column:1/-1">No editions published yet.</p>
    @endforelse
  </div>
@endif

@endsection
