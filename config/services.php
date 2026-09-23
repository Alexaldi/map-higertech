<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'gowa' => [
        'url' => env('GOWA_URL', env('GOWA_API_URL', 'http://127.0.0.1:3000')),
        'device_id' => env('GOWA_DEVICE_ID'),
        'admin_number' => env('WHATSAPP_ADMIN_NUMBER'),
        'username' => env('GOWA_BASIC_AUTH_USERNAME'),
        'password' => env('GOWA_BASIC_AUTH_PASSWORD'),
    ],

    'pos_monitoring' => [
        'base_url' => env('POS_MONITORING_BASE_URL', 'http://103.183.75.71:5000'),
        'username' => env('POS_MONITORING_USERNAME', 'm0n1tor_st4tion'),
        'password' => env('POS_MONITORING_PASSWORD', 'H1gertech.1dua3'),
        'timeout' => (int) env('POS_MONITORING_TIMEOUT', 30),
    ],

];
