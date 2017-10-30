<?php

return [
    'twitter' => [
        'key' => env('TWITTER_CONSUMER_KEY', ''),
        'secret' => env('TWITTER_CONSUMER_SECRET', ''),
        'token' => env('TWITTER_ACCESS_TOKEN', ''),
        'token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET', ''),
    ],

    'facebook' => [
        'app_id' => env('FACEBOOK_APP_ID', ''),
        'app_secret' => env('FACEBOOK_APP_SECRET', ''),
        'page_id' => env('FACEBOOK_PAGE_ID', ''),
        'page_access_token' => env('FACEBOOK_PAGE_ACCESS_TOKEN', ''),
        'user_access_token' => env('FACEBOOK_USER_ACCESS_TOKEN', ''),
    ],
];
