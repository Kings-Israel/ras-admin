<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'maps' => [
        'key' => env('GOOGLE_MAPS_KEY'),
        'partial_key' => env('MAPS_KEY')
    ],
    'jambopay' => [
        // SMS
        'sms_client_id' => env('JAMBOPAY_SMS_CLIENT_ID'),
        'sms_client_secret' => env('JAMBOPAY_SMS_CLIENT_SECRET'),
        // CHECKOUT
        'url' => env('JAMBOPAY_ENV') === 'LIVE' ? env('JAMBOPAY_LIVE_URL') : env('JAMBOPAY_TEST_URL'),
        'client_key' => env('JAMBOPAY_CLIENT_KEY'),
        'username' => env('JAMBOPAY_ENV') === 'LIVE' ? env('JAMBOPAY_USERNAME') :  env('JAMBOPAY_TEST_USERNAME'),
        'password' => env('JAMBOPAY_ENV') === 'LIVE' ? env('JAMBOPAY_PASSWORD') : env('JAMBOPAY_TEST_PASSWORD'),
        'checksum' => env('JAMBOPAY_CHECKSUM'),
        // WALLET
        'wallet_auth_url' => env('JAMBOPAY_WALLET_AUTH_URL'),
        'wallet_url' => env('JAMBOPAY_ENV') === 'LIVE' ? env('JAMBOPAY_WALLET_LIVE_URL') : env('JAMBOPAY_WALLET_SANDBOX_URL'),
        'wallet_client_id' => env('JAMBOPAY_ENV') === 'LIVE' ? env('JAMBOPAY_WALLET_LIVE_CLIENT_ID') : env('JAMBOPAY_WALLET_SANDBOX_CLIENT_ID'),
        'wallet_client_secret' => env('JAMBOPAY_ENV') === 'LIVE' ? env('JAMBOPAY_WALLET_LIVE_CLIENT_SECRET') : env('JAMBOPAY_WALLET_SANDBOX_CLIENT_SECRET'),
        'wallet_float_account_number' => env('JAMBOPAY_ENV') === 'LIVE' ? env('JAMBOPAY_WALLET_LIVE_FLOAT_ACCOUNT_NUMBER') : env('JAMBOPAY_WALLET_SANDBOX_FLOAT_ACCOUNT_NUMBER'),
        'wallet_commission_account_number' => env('JAMBOPAY_ENV') === 'LIVE' ? env('JAMBOPAY_WALLET_LIVE_COMMISSION_ACCOUNT_NUMBER') : env('JAMBOPAY_WALLET_SANDBOX_COMMISSION_ACCOUNT_NUMBER'),
        'wallet_account_number' => env('JAMBOPAY_ENV') === 'LIVE' ? env('JAMBOPAY_WALLET_LIVE_ACCOUNT_NUMBER') : env('JAMBOPAY_WALLET_SANDBOX_ACCOUNT_NUMBER'),
    ],
];
