
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
            'mx'
        ],
        'en' => [
            'english',
            'us'
        ],
    ],
    'images' => [
        'sizes' => [
            [
                'name' => 'thumbnail',
                'height' => '100',
                'width' => '100',
                'quality' => 90,
                'aspect' => 'crop',
                'fill' => false
            ],
            [
                'name' => 'small',
                'height' => '200',
                'width' => '200',
                'quality' => 90,
                'aspect' => 'crop',
                'fill' => false
            ],
            [
                'name' => 'medium',
                'height' => '400',
                'width' => '400',
                'quality' => 90,
                'aspect' => 'crop',
                'fill' => false
            ],
            [
                'name' => 'large',
                'height' => '1200',
                'width' => '1200',
                'quality' => 90,
                'aspect' => 'upsize',
                'fill' => false
            ],
        ],
    ],
    'pagination' => [10, 20, 30, 40, 80, 100],
    'search' => [
        'default' => false
    ],
    'hybridauth' => [
        'facebook' => [
            'callback' => env('APP_URL').'/admin/social-auth/facebook',
            'keys' => [ 'key' => env('FACEBOOK_KEY'), 'secret' => env('FACEBOOK_SECRET') ]
        ],
        'twitter' => [
            'callback' => env('APP_URL').'/admin/social-auth/twitter',
            'keys' => [ 'key' => env('TWITTER_KEY'), 'secret' => env('TWITTER_SECRET') ]
        ],
        'google' => [
            'callback' => env('APP_URL').'/admin/social-auth/google',
            'keys' => [ 'key' => env('GOOGLE_KEY'), 'secret' => env('GOOGLE_SECRET') ]
        ]
    ],
];
