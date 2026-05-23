<?php $__env->startSection('title', $article->title . ' | The Paducah Herald'); ?>
<?php $__env->startSection('description', $article->standfirst); ?>

<?php $__env->startSection('styles'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<header class="art-header">
  <?php if($article->fly_title): ?>
    <a class="art-flytitle" href="<?php echo e($article->section ? route('sections.show', $article->section->slug) : route('home')); ?>"><?php echo e($article->fly_title); ?></a>
  <?php elseif($article->section): ?>
    <a class="art-flytitle" href="<?php echo e(route('sections.show', $article->section->slug)); ?>"><?php echo e($article->section->title); ?></a>
  <?php endif; ?>

  <h1 class="art-title"><?php echo e($article->title); ?></h1>

  <?php if($article->standfirst): ?>
    <p class="art-standfirst"><?php echo e($article->standfirst); ?></p>
  <?php endif; ?>

  <div class="art-byline">
    <div class="art-byline-text">
      <p class="art-byline-date">
        <?php echo e(\Carbon\Carbon::parse($article->publish_start_date ?? $article->created_at)->format('F jS Y')); ?>

      </p>
      <?php if($article->read_time): ?>
        <p class="art-byline-meta"><?php echo e($article->read_time); ?> min read</p>
      <?php endif; ?>
    </div>
    <a class="art-share-btn" href="#">Share</a>
    <a class="art-share-btn" href="#">Save</a>
  </div>
</header>

<?php if($article->imageObject('hero')): ?>
  <div class="art-hero">
    <img class="art-hero-img" src="<?php echo e($article->image('hero', 'default')); ?>" alt="<?php echo e($article->title); ?>" />
  </div>
<?php elseif($article->hero_image_url): ?>
  <div class="art-hero">
    <img class="art-hero-img" src="<?php echo e($article->hero_image_url); ?>" alt="<?php echo e($article->title); ?>" />
  </div>
<?php endif; ?>

<div class="art-body-wrap">
  <main class="art-body-main">
    <div class="art-text">
      <?php echo $article->body; ?>

    </div>
  </main>

  <aside class="art-sidebar">
    <?php if($article->section): ?>
      <p class="art-sidebar-head">Also in <?php echo e($article->section->title); ?></p>
      <?php $__currentLoopData = $relatedArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="art-sidebar-item" href="<?php echo e(route('articles.show', $related->slug)); ?>">
          <p class="art-sidebar-tag"><?php echo e($related->fly_title ?: $article->section->title); ?></p>
          <p class="art-sidebar-title"><?php echo e($related->title); ?></p>
          <?php if($related->read_time): ?>
            <p class="art-sidebar-meta"><?php echo e($related->read_time); ?> min read</p>
          <?php endif; ?>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
  </aside>
</div>

<div class="art-footer-spacer"></div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/new/Desktop/paducah-herald/resources/views/article.blade.php ENDPATH**/ ?>