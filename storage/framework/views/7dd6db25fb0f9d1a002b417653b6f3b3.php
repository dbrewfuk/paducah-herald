<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $__env->yieldContent('title', 'The Paducah Herald'); ?></title>
  <meta name="description" content="<?php echo $__env->yieldContent('description', 'Local news from Paducah, Kentucky and the surrounding region.'); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/economist-1e1bb3.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('css/economist-1e4acd.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('css/economist-25a99e.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('css/economist-bed931.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('css/economist-cfb5b9.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('css/economist-da5457.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('economist.css')); ?>" />
  <style>
    :root {
      --red: #1a4a7a;        /* Navy blue instead of Economist red */
      --navy-20: #1a4a7a;
      --navy-30: #2a5a8a;
      --navy-45: #3a6a9a;
    }
    .masthead { border-bottom: 3px solid #1a4a7a; }
    .btn-subscribe { background: #1a4a7a; }
    .btn-subscribe:hover { background: #2a5a8a; }
    .herald-wordmark {
      font-family: var(--serif);
      font-size: 28px;
      font-weight: 700;
      color: #1a4a7a;
      letter-spacing: -0.02em;
      line-height: 1;
    }
    .herald-wordmark span {
      display: block;
      font-size: 10px;
      font-family: var(--sans);
      font-weight: 600;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--ink-35);
      margin-top: 2px;
    }
  </style>
  <?php echo $__env->yieldContent('styles'); ?>
</head>
<body class="<?php echo $__env->yieldContent('body-class'); ?>">

<?php $navSections = \App\Models\Section::orderBy('position')->get(); ?>

<?php if (! (View::hasSection('no-adstrip'))): ?>
<div class="ad-strip">
  <div class="ad-label">Advertisement</div>
  <div style="height:90px;background:var(--ink-95);max-width:728px;margin:0 auto;display:flex;align-items:center;justify-content:center;font-size:11px;color:var(--ink-70);font-family:var(--sans);">728×90</div>
</div>
<?php endif; ?>

<?php if (! empty(trim($__env->yieldContent('masthead')))): ?>
  <?php echo $__env->yieldContent('masthead'); ?>
<?php else: ?>
  <?php echo $__env->make('partials.masthead', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<nav class="topnav" aria-label="Section navigation">
  <div class="topnav-inner">
    <a class="topnav-link <?php if(request()->routeIs('weekly-edition*')): ?> is-active <?php endif; ?>"
       href="<?php echo e(route('weekly-edition.index')); ?>">E-Edition</a>
    <a class="topnav-link <?php if(request()->routeIs('world-in-brief')): ?> is-active <?php endif; ?>"
       href="<?php echo e(route('world-in-brief')); ?>">In Brief</a>
    <?php $__currentLoopData = $navSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a class="topnav-link <?php if(request()->routeIs('sections.show') && request()->route('slug') === $section->slug): ?> is-active <?php endif; ?>"
         href="<?php echo e(route('sections.show', $section->slug)); ?>"><?php echo e($section->title); ?></a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <a class="topnav-link <?php if(request()->routeIs('insider*')): ?> is-active <?php endif; ?>"
       href="<?php echo e(route('insider.index')); ?>">Insider</a>
  </div>
</nav>

<?php echo $__env->yieldContent('content'); ?>

<footer class="footer">
  <div class="footer-inner">
    <div class="footer-top">
      <div class="herald-wordmark" style="color:rgba(255,255,255,0.85)">
        The Paducah Herald
        <span style="color:rgba(255,255,255,0.45)">Paducah, Kentucky</span>
      </div>
      <div class="footer-social">
        <span class="footer-social-btn">fb</span>
        <span class="footer-social-btn">X</span>
        <span class="footer-social-btn">ig</span>
        <span class="footer-social-btn">yt</span>
      </div>
    </div>
    <p class="footer-app-link" style="margin-bottom:32px">
      Serving Paducah and Western Kentucky since 2026
    </p>
    <div class="footer-cols">
      <div class="footer-col">
        <h4 class="footer-col-head">The Herald</h4>
        <a href="#">About us</a>
        <a href="#">Contact the newsroom</a>
        <a href="#">Subscribe</a>
        <a href="<?php echo e(route('weekly-edition.index')); ?>">E-Edition</a>
      </div>
      <div class="footer-col">
        <h4 class="footer-col-head">Sections</h4>
        <?php $__currentLoopData = $navSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="<?php echo e(route('sections.show', $section->slug)); ?>"><?php echo e($section->title); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <div class="footer-col">
        <h4 class="footer-col-head">Contact</h4>
        <a href="#">Tips & story ideas</a>
        <a href="#">Advertise</a>
        <a href="#">Letters to the editor</a>
        <a href="#">Obituaries</a>
      </div>
      <div class="footer-col">
        <h4 class="footer-col-head">More</h4>
        <a href="<?php echo e(route('world-in-brief')); ?>">In Brief</a>
        <a href="<?php echo e(route('insider.index')); ?>">Insider</a>
        <a href="#">Weather</a>
        <a href="#">Classifieds</a>
        <a href="#">Privacy policy</a>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="footer-legal">
        <a href="#">Terms of use</a>
        <a href="#">Privacy</a>
        <a href="#">Accessibility</a>
        <a href="#">Sitemap</a>
      </div>
      <p class="footer-copyright">© The Paducah Herald <?php echo e(date('Y')); ?></p>
    </div>
  </div>
</footer>

</body>
</html>
<?php /**PATH /Users/new/Desktop/paducah-herald/resources/views/layouts/app.blade.php ENDPATH**/ ?>