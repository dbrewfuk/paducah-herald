<?php $__env->startSection('title', 'The Paducah Herald | Local News for Western Kentucky'); ?>

<?php $__env->startSection('styles'); ?>
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
  .hero-main-link { display: block; position: relative; }
  .hero-bg {
    width: 100%; aspect-ratio: 16/9; object-fit: cover; display: block;
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if($featured): ?>
<section class="home-hero">
  <div class="home-hero-inner">
    <a class="hero-main-link" href="<?php echo e(route('articles.show', $featured->slug)); ?>">
      <?php if($featured->imageObject('hero')): ?>
        <img class="hero-bg" src="<?php echo e($featured->image('hero', 'default')); ?>" alt="<?php echo e($featured->title); ?>" />
      <?php elseif($featured->hero_image_url): ?>
        <img class="hero-bg" src="<?php echo e($featured->hero_image_url); ?>" alt="<?php echo e($featured->title); ?>" />
      <?php else: ?>
        <div class="hero-bg" style="background:var(--ink-20)"></div>
      <?php endif; ?>
      <div class="hero-gradient"></div>
      <div class="hero-content">
        <?php if($featured->fly_title): ?>
          <div class="hero-flytitle"><?php echo e($featured->fly_title); ?></div>
        <?php elseif($featured->section): ?>
          <div class="hero-flytitle"><?php echo e($featured->section->title); ?></div>
        <?php endif; ?>
        <h1 class="hero-headline"><?php echo e($featured->title); ?></h1>
        <?php if($featured->standfirst): ?>
          <p class="hero-desc"><?php echo e($featured->standfirst); ?></p>
        <?php endif; ?>
      </div>
    </a>

    <aside class="hero-sidebar">
      <?php $__currentLoopData = $rest->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="hero-sidebar-item" href="<?php echo e(route('articles.show', $article->slug)); ?>">
          <div class="hero-sidebar-label">
            <?php echo e($article->fly_title ?: ($article->section ? $article->section->title : 'Article')); ?>

          </div>
          <?php if($article->imageObject('hero')): ?>
            <img class="hero-sidebar-img" src="<?php echo e($article->image('hero', 'default')); ?>" alt="<?php echo e($article->title); ?>" />
          <?php elseif($article->hero_image_url): ?>
            <img class="hero-sidebar-img" src="<?php echo e($article->hero_image_url); ?>" alt="<?php echo e($article->title); ?>" />
          <?php endif; ?>
          <div class="hero-sidebar-headline"><?php echo e($article->title); ?></div>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </aside>
  </div>
</section>

<?php if($rest->count() > 3): ?>
<section class="home-section">
  <div class="home-section-inner">
    <div class="sec-head" style="border-top-color:var(--paris-85)">
      <span class="sec-head-title" style="font-size:14px;font-weight:400;color:var(--ink-35)">More articles</span>
    </div>
    <div class="grid-3">
      <?php $__currentLoopData = $rest->skip(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="teaser" href="<?php echo e(route('articles.show', $article->slug)); ?>">
          <?php if($article->imageObject('hero')): ?>
            <div class="t-img-wrap">
              <img class="t-img" src="<?php echo e($article->image('hero', 'default')); ?>" alt="<?php echo e($article->title); ?>" />
            </div>
          <?php elseif($article->hero_image_url): ?>
            <div class="t-img-wrap">
              <img class="t-img" src="<?php echo e($article->hero_image_url); ?>" alt="<?php echo e($article->title); ?>" />
            </div>
          <?php endif; ?>
          <p class="t-flytitle"><?php echo e($article->fly_title ?: ($article->section ? $article->section->title : '')); ?></p>
          <h3 class="t-headline"><?php echo e($article->title); ?></h3>
          <?php if($article->standfirst): ?>
            <p class="t-desc"><?php echo e(Str::limit($article->standfirst, 100)); ?></p>
          <?php endif; ?>
          <?php if($article->read_time): ?>
            <div class="t-meta"><?php echo e($article->read_time); ?> min read</div>
          <?php endif; ?>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php else: ?>
<div class="home-empty">
  <p>No articles published yet.</p>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/new/Desktop/paducah-herald/resources/views/home.blade.php ENDPATH**/ ?>