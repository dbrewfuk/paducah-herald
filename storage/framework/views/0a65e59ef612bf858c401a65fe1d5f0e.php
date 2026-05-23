<?php $__env->startSection('title', $section->title . ' | The Paducah Herald'); ?>
<?php $__env->startSection('description', $section->description); ?>

<?php $__env->startSection('styles'); ?>
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
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<header class="section-page-header">
  <div class="section-page-header-inner">
    <h1 class="section-page-title"><?php echo e($section->title); ?></h1>
    <?php if($section->description): ?>
      <p class="section-page-desc"><?php echo e($section->description); ?></p>
    <?php endif; ?>
  </div>
  <?php if($section->imageObject('hero')): ?>
    <img class="section-page-hero-img" src="<?php echo e($section->image('hero', 'default')); ?>" alt="<?php echo e($section->title); ?>" />
  <?php endif; ?>
</header>

<div class="topic-body">
  <main class="topic-main">
    <?php $__empty_1 = true; $__currentLoopData = $articles->chunk(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="art-grid-2">
        <?php $__currentLoopData = $pair; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a class="teaser" href="<?php echo e(route('articles.show', $article->slug)); ?>">
            <?php if($article->imageObject('hero')): ?>
              <div class="t-img-wrap">
                <img class="t-img" src="<?php echo e($article->image('hero', 'default')); ?>" alt="<?php echo e($article->title); ?>" />
              </div>
            <?php endif; ?>
            <p class="t-flytitle"><?php echo e($article->fly_title ?: $section->title); ?></p>
            <h2 class="t-headline"><?php echo e($article->title); ?></h2>
            <?php if($article->read_time): ?>
              <p class="t-meta"><?php echo e($article->read_time); ?> min read</p>
            <?php endif; ?>
          </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <p class="section-empty">No articles in this section yet.</p>
    <?php endif; ?>
  </main>

  <aside class="topic-sidebar">
    <div style="height:90px;background:var(--la-95);display:flex;align-items:center;justify-content:center;font-size:10px;font-family:var(--sans);color:var(--ink-70);letter-spacing:0.08em;text-transform:uppercase;margin-bottom:24px;">Advertisement</div>
  </aside>
</div>

<?php if($articles->hasPages()): ?>
  <div class="pagination-row">
    <?php if($articles->previousPageUrl()): ?>
      <a class="pagination-next" href="<?php echo e($articles->previousPageUrl()); ?>">← Previous</a>
    <?php endif; ?>
    <?php if($articles->nextPageUrl()): ?>
      <a class="pagination-next" href="<?php echo e($articles->nextPageUrl()); ?>">Next →</a>
    <?php endif; ?>
  </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/new/Desktop/paducah-herald/resources/views/site/section.blade.php ENDPATH**/ ?>