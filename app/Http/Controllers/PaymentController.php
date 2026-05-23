<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ArticlePaywall;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PaymentController extends Controller
{
    /**
     * Create a Stripe Checkout session and redirect the visitor there.
     */
    public function checkout(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        Stripe::setApiVersion('2024-06-20');

        $intended = session('paywall_intended', route('home'));
        $successUrl = route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}&intended=' . urlencode($intended);
        $cancelUrl  = $intended;

        $session = StripeSession::create([
            'mode'                => 'subscription',
            'line_items'          => [[
                'price'    => config('services.stripe.price'),
                'quantity' => 1,
            ]],
            'success_url'         => $successUrl,
            'cancel_url'          => $cancelUrl,
            'subscription_data'   => [
                'description' => 'The Paducah Herald – full access',
                'metadata'    => ['product' => 'herald_subscription'],
            ],
        ]);

        return redirect($session->url, 303);
    }

    /**
     * Stripe redirects here after a successful payment.
     * Verify the session server-side, then grant access via a 30-day cookie.
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $intended  = $request->query('intended', route('home'));

        if (! $sessionId) {
            return redirect(route('home'));
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        Stripe::setApiVersion('2024-06-20');

        try {
            $session = StripeSession::retrieve($sessionId);
        } catch (\Exception $e) {
            return redirect(route('home'))->with('error', 'We could not verify your payment. Please contact us.');
        }

        if ($session->payment_status !== 'paid') {
            return redirect(route('home'))->with('error', 'Payment was not completed.');
        }

        // Grant access for 30 days.
        $paidUntil = time() + (60 * 60 * 24 * 30);

        $response = redirect($intended ?: route('home'));
        $response->withCookie(
            cookie(ArticlePaywall::ACCESS_COOKIE, $paidUntil, 60 * 24 * 30)
        );
        // Reset the read counter so the experience is clean.
        $response->withCookie(
            cookie(ArticlePaywall::READS_COOKIE, 0, 60 * 24 * 30)
        );

        return $response;
    }

    /**
     * Visitor cancelled at Stripe — redirect them back.
     */
    public function cancel(Request $request)
    {
        $intended = session('paywall_intended', route('home'));
        return redirect($intended);
    }
}
