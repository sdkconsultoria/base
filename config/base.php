
<?php
return [
    /*
     |--------------------------------------------------------------------------
     | Configuraciones basicas
     |--------------------------------------------------------------------------
     |
     |
     */
    'languages' => [
        'es' => [
            'spanish',
            'mx',
        ],
        'en' => [
            'english',
            'us',
        ],
    ],
    'pagination' => [10, 20, 30, 40, 80, 100],
    'search' => [
        'default' => false,
    ],
    'hybridauth' => [
        'facebook' => [
            'callback' => env('APP_URL') . '/admin/social-auth/facebook',
            'keys' => ['key' => env('FACEBOOK_KEY'), 'secret' => env('FACEBOOK_SECRET')],
        ],
        'twitter' => [
            'callback' => env('APP_URL') . '/admin/social-auth/twitter',
            'keys' => ['key' => env('TWITTER_KEY'), 'secret' => env('TWITTER_SECRET')],
        ],
        'google' => [
            'callback' => env('APP_URL') . '/admin/social-auth/google',
            'keys' => ['key' => env('GOOGLE_KEY'), 'secret' => env('GOOGLE_SECRET')],
        ],
    ],
];
