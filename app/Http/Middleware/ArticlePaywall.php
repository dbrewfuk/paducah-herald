<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticlePaywall
{
    /**
     * How many articles a visitor can read for free before hitting the paywall.
     */
    const FREE_ARTICLES = 2;

    /**
     * Cookie names.
     */
    const READS_COOKIE  = 'ph_reads';   // plain integer counter (not sensitive)
    const ACCESS_COOKIE = 'ph_access';  // encrypted, stores paid-until timestamp

    public function handle(Request $request, Closure $next): Response
    {
        // 1. Paid users pass straight through.
        if ($this->hasPaidAccess($request)) {
            return $next($request);
        }

        // 2. Count how many articles this visitor has already read.
        $reads = (int) $request->cookie(self::READS_COOKIE, 0);

        // 3. First FREE_ARTICLES articles are free; record the read.
        if ($reads < self::FREE_ARTICLES) {
            $response = $next($request);
            $response->withCookie(
                cookie(self::READS_COOKIE, $reads + 1, 60 * 24 * 30) // 30-day counter
            );
            return $response;
        }

        // 4. Paywall — store the intended destination so we can redirect back after payment.
        session(['paywall_intended' => $request->fullUrl()]);

        return response()->view('paywall', [
            'article_url' => $request->fullUrl(),
        ], 402);
    }

    /**
     * Return true if the visitor has a valid paid-access cookie.
     */
    public static function hasPaidAccess(Request $request): bool
    {
        $raw = $request->cookie(self::ACCESS_COOKIE);
        if (! $raw) {
            return false;
        }

        // The cookie value is the Unix timestamp until which access is valid.
        return (int) $raw > time();
    }
}
