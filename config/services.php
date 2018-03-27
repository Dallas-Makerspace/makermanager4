<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'doorcontrol' => [
        'url' => env('DOORCONTROL_URL'),
        'key' => env('DOORCONTROL_KEY'),
        'scrape_url' => env('DOORCONTROL_SCRAPE_URL'),
        'scrape_username' => env('DOORCONTROL_SCRAPE_USERNAME'),
        'scrape_password' => env('DOORCONTROL_SCRAPE_PASSWORD'),
    ],

    'smartwaiver' => [
        'key' => env('SMARTWAIVER_KEY')
    ],

    'lob' => [
        'key' => env('LOB_KEY')
    ],

    'whmcs' => [
        'username' => env('WHMCS_USERNAME'),
        'password' => env('WHMCS_PASSWORD')
    ]

];
