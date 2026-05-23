<?php $__env->startSection('title', ($episode->title ?? 'Herald Insider') . ' | The Paducah Herald'); ?>
<?php $__env->startSection('body-class', 'insider-page'); ?>

<?php $__env->startSection('no-adstrip', true); ?>

<?php $__env->startSection('masthead'); ?>
<nav class="masthead-dark" aria-label="Main navigation">
  <div class="masthead-dark-inner">
    <a href="<?php echo e(route('home')); ?>" style="text-decoration:none">
      <div class="herald-wordmark" style="color:rgba(255,255,255,0.9)">
        The Paducah Herald
        <span style="color:rgba(255,255,255,0.45)">Paducah, Kentucky</span>
      </div>
    </a>
    <div class="masthead-actions">
      <a class="btn-subscribe" href="#">Subscribe</a>
      <a class="masthead-link" href="#" style="color:rgba(255,255,255,0.7)">E-Edition</a>
      <a class="masthead-link" href="#" style="color:rgba(255,255,255,0.7)">Log in</a>
    </div>
  </div>
</nav>
<nav class="topnav topnav-dark" aria-label="Section navigation">
  <div class="topnav-inner">
    <a class="topnav-link" href="<?php echo e(route('weekly-edition.index')); ?>">E-Edition</a>
    <a class="topnav-link" href="<?php echo e(route('world-in-brief')); ?>">In Brief</a>
    <?php $navSections = \App\Models\Section::orderBy('position')->get(); ?>
    <?php $__currentLoopData = $navSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a class="topnav-link" href="<?php echo e(route('sections.show', $section->slug)); ?>"><?php echo e($section->title); ?></a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <a class="topnav-link is-active" href="<?php echo e(route('insider.index')); ?>">Insider</a>
  </div>
</nav>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
  body.insider-page { background: var(--ink-10); color: #fff; }
  body.insider-page .footer { background: #000; }
  body.insider-page .footer .footer-copyright,
  body.insider-page .footer .footer-col a,
  body.insider-page .footer .footer-legal a,
  body.insider-page .footer .footer-col-head,
  body.insider-page .footer .footer-app-link { color: rgba(255,255,255,0.55); }
  body.insider-page .footer .footer-bottom { border-top-color: rgba(255,255,255,0.08); }

  .masthead-dark {
    position: sticky; top: 0; z-index: 200;
    background: var(--ink-10); border-bottom: 1px solid rgba(255,255,255,0.1);
  }
  .masthead-dark-inner {
    display: flex; align-items: center; justify-content: space-between;
    height: 52px; max-width: var(--max-w); margin: 0 auto; padding: 0 var(--gutter);
  }
  .topnav-dark { background: var(--ink-10); border-bottom: 1px solid rgba(255,255,255,0.1); }
  .topnav-dark .topnav-link { color: rgba(255,255,255,0.55); }
  .topnav-dark .topnav-link:hover { color: rgba(255,255,255,0.9); }
  .topnav-dark .topnav-link.is-active { color: #fff; }

  /* Episode hero */
  .episode-hero {
    max-width: var(--max-w); margin: 0 auto; padding: 36px var(--gutter) 0;
    display: grid; grid-template-columns: 1fr 360px; gap: 60px; align-items: start;
  }
  .episode-tag {
    font-size: 10px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.12em; text-transform: uppercase; color: rgba(255,255,255,0.45); margin-bottom: 18px;
  }
  .episode-title {
    font-family: var(--serif); font-size: 48px; font-weight: 500;
    line-height: 1.1; color: #fff; margin-bottom: 24px; text-wrap: balance;
  }
  .episode-share {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 14px; font-family: var(--sans); font-weight: 600;
    color: rgba(255,255,255,0.7); border: 1.5px solid rgba(255,255,255,0.25);
    border-radius: 100px; padding: 8px 20px;
  }
  .episode-sponsor { display: flex; align-items: center; gap: 12px; margin-top: 24px; }
  .episode-sponsor-label {
    font-size: 11px; font-family: var(--sans); color: rgba(255,255,255,0.4);
    letter-spacing: 0.06em; text-transform: uppercase; white-space: nowrap;
  }
  .episode-video-wrap {
    position: relative; aspect-ratio: 16/9; overflow: hidden;
    background: var(--ink-5); border-radius: 2px;
  }
  .episode-video-thumb { width: 100%; height: 100%; object-fit: cover; }
  .episode-play-overlay {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    background: rgba(0,0,0,0.35);
  }
  .episode-play-btn {
    width: 64px; height: 64px; border-radius: 50%;
    background: rgba(255,255,255,0.15); border: 2px solid rgba(255,255,255,0.6);
    display: flex; align-items: center; justify-content: center;
  }
  .episode-play-btn svg { width: 22px; height: 22px; fill: #fff; margin-left: 4px; }
  .dark-divider { max-width: var(--max-w); margin: 48px auto 0; border: none; border-top: 1px solid rgba(255,255,255,0.1); }
  .episode-body {
    max-width: var(--max-w); margin: 0 auto; padding: 0 var(--gutter);
    display: grid; grid-template-columns: 1fr 360px; gap: 60px; align-items: start;
  }
  .ep-summary-label {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.4); margin: 40px 0 16px;
  }
  .ep-summary-text {
    font-family: var(--serif); font-size: 17px; color: rgba(255,255,255,0.8); line-height: 1.65;
  }
  .ep-sidebar { padding-top: 40px; }
  .ep-nav-label {
    font-size: 11px; font-family: var(--sans); font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.4); margin-bottom: 16px;
  }
  .ep-nav-item { padding: 14px 0; border-top: 1px solid rgba(255,255,255,0.1); display: block; }
  .ep-nav-item:first-of-type { border-top: none; padding-top: 0; }
  .ep-nav-tag { font-size: 11px; font-family: var(--sans); color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 5px; }
  .ep-nav-title { font-family: var(--serif); font-size: 16px; font-weight: 500; color: rgba(255,255,255,0.75); line-height: 1.3; }
  .ep-nav-item:hover .ep-nav-title { color: #fff; text-decoration: underline; }

  /* Index */
  .insider-list-header { max-width: var(--max-w); margin: 0 auto; padding: 40px var(--gutter) 28px; }
  .insider-list-title { font-family: var(--serif); font-size: 52px; font-weight: 500; color: #fff; margin-bottom: 8px; }
  .insider-list-desc { font-family: var(--sans); font-size: 15px; color: rgba(255,255,255,0.55); }
  .insider-grid { max-width: var(--max-w); margin: 0 auto; padding: 0 var(--gutter) 60px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
  .insider-card { display: block; }
  .insider-card-img { width: 100%; aspect-ratio: 16/9; object-fit: cover; display: block; margin-bottom: 16px; }
  .insider-card-placeholder { width: 100%; aspect-ratio: 16/9; background: var(--ink-5); margin-bottom: 16px; }
  .insider-card-date { font-size: 11px; font-family: var(--sans); color: rgba(255,255,255,0.4); margin-bottom: 8px; }
  .insider-card-title { font-family: var(--serif); font-size: 20px; font-weight: 500; color: rgba(255,255,255,0.9); line-height: 1.3; }
  .insider-card:hover .insider-card-title { color: #fff; text-decoration: underline; }
  .insider-card-sponsor { font-size: 12px; font-family: var(--sans); color: rgba(255,255,255,0.35); margin-top: 8px; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(isset($episode)): ?>
  <div class="episode-hero">
    <div>
      <p class="episode-tag">Herald Insider</p>
      <h1 class="episode-title"><?php echo e($episode->title); ?></h1>
      <a class="episode-share" href="#">Share</a>
      <?php if($episode->sponsor_name): ?>
        <div class="episode-sponsor">
          <span class="episode-sponsor-label">Sponsored by</span>
          <?php if($episode->imageObject('sponsor_logo')): ?>
            <img src="<?php echo e($episode->image('sponsor_logo', 'default')); ?>" alt="<?php echo e($episode->sponsor_name); ?>" class="episode-sponsor-img" style="height:32px;opacity:0.75" />
          <?php else: ?>
            <span style="font-family:var(--sans);font-size:14px;color:rgba(255,255,255,0.6)"><?php echo e($episode->sponsor_name); ?></span>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
    <div>
      <div class="episode-video-wrap">
        <?php if($episode->imageObject('thumbnail')): ?>
          <img class="episode-video-thumb" src="<?php echo e($episode->image('thumbnail', 'default')); ?>" alt="<?php echo e($episode->title); ?>" />
        <?php endif; ?>
        <?php if($episode->video_url): ?>
          <a href="<?php echo e($episode->video_url); ?>" class="episode-play-overlay" target="_blank" rel="noopener">
        <?php else: ?>
          <div class="episode-play-overlay">
        <?php endif; ?>
          <div class="episode-play-btn">
            <svg viewBox="0 0 16 16"><polygon points="4,2 14,8 4,14"/></svg>
          </div>
        <?php if($episode->video_url): ?> </a> <?php else: ?> </div> <?php endif; ?>
      </div>
      <?php if($episode->publish_start_date): ?>
        <p style="font-size:12px;font-family:var(--sans);color:rgba(255,255,255,0.4);margin-top:10px">
          Recorded <?php echo e(\Carbon\Carbon::parse($episode->publish_start_date)->format('F j Y')); ?>

        </p>
      <?php endif; ?>
    </div>
  </div>

  <hr class="dark-divider">

  <div class="episode-body">
    <main>
      <?php if($episode->episode_summary): ?>
        <p class="ep-summary-label">About this episode</p>
        <div class="ep-summary-text"><?php echo e($episode->episode_summary); ?></div>
      <?php endif; ?>
    </main>
    <aside class="ep-sidebar">
      <p class="ep-nav-label">More episodes</p>
      <?php $__currentLoopData = $otherEpisodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="ep-nav-item" href="<?php echo e(route('insider.show', $ep->slug)); ?>">
          <p class="ep-nav-tag">
            <?php echo e($ep->publish_start_date ? \Carbon\Carbon::parse($ep->publish_start_date)->format('M j, Y') : 'Insider'); ?>

          </p>
          <p class="ep-nav-title"><?php echo e($ep->title); ?></p>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </aside>
  </div>

<?php else: ?>
  <div class="insider-list-header">
    <h1 class="insider-list-title">Herald Insider</h1>
    <p class="insider-list-desc">In-depth video and audio reporting on the stories shaping Paducah and Western Kentucky.</p>
  </div>
  <div class="insider-grid">
    <?php $__empty_1 = true; $__currentLoopData = $episodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <a class="insider-card" href="<?php echo e(route('insider.show', $ep->slug)); ?>">
        <?php if($ep->imageObject('thumbnail')): ?>
          <img class="insider-card-img" src="<?php echo e($ep->image('thumbnail', 'default')); ?>" alt="<?php echo e($ep->title); ?>" />
        <?php else: ?>
          <div class="insider-card-placeholder"></div>
        <?php endif; ?>
        <?php if($ep->publish_start_date): ?>
          <p class="insider-card-date"><?php echo e(\Carbon\Carbon::parse($ep->publish_start_date)->format('F j, Y')); ?></p>
        <?php endif; ?>
        <p class="insider-card-title"><?php echo e($ep->title); ?></p>
        <?php if($ep->sponsor_name): ?>
          <p class="insider-card-sponsor">Sponsored by <?php echo e($ep->sponsor_name); ?></p>
        <?php endif; ?>
      </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <p style="font-family:var(--serif);font-size:18px;color:rgba(255,255,255,0.4);grid-column:1/-1">No episodes published yet.</p>
    <?php endif; ?>
  </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/new/Desktop/paducah-herald/resources/views/site/insiderEpisode.blade.php ENDPATH**/ ?>