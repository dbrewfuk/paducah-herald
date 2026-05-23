<?php

/*
 * Site identity. All values are overridable via .env so the same codebase
 * can ship multiple magazines by swapping environment variables.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Name + tagline
    |--------------------------------------------------------------------------
    | Used in <title>, meta description fallback, and footer copyright.
    */

    'name'    => env('SITE_NAME', 'Magazine'),
    'tagline' => env('SITE_TAGLINE', 'A new publication.'),

    /*
    |--------------------------------------------------------------------------
    | Wordmark
    |--------------------------------------------------------------------------
    | The two-line header wordmark. Designed as a primary + italic sublabel.
    | Example: "Il Giornale" / "del Golf"
    */

    'wordmark_main' => env('SITE_WORDMARK_MAIN', 'Magazine'),
    'wordmark_sub'  => env('SITE_WORDMARK_SUB', ''),

    /*
    |--------------------------------------------------------------------------
    | Asset cache busting
    |--------------------------------------------------------------------------
    | Bump this (or set SITE_ASSET_VERSION in .env) after editing site.css.
    */

    'asset_version' => env('SITE_ASSET_VERSION', 1),

];
