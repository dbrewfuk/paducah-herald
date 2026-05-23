<?php

return [

    'stripe' => [
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'price'  => env('STRIPE_PRICE'),
    ],

];
