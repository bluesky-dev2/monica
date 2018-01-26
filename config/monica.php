<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Locales supported by the application
    |--------------------------------------------------------------------------
    |
    | This is the list of locales that we will use to localize the application.
    | Each locale is defined in `resources/lang/` in their respective folder.
    |
    */
    'langs' => [
        'en',
        'fr',
        'pt-br',
        'ru',
        'cz',
        'it',
        'de',
    ],

   /*
    |--------------------------------------------------------------------------
    | Disable User registration
    |--------------------------------------------------------------------------
    |
    | Disables registration of new users
    |
    */
    'disable_signup' => env('APP_DISABLE_SIGNUP', false),

    /*
    |--------------------------------------------------------------------------
    | New User Email Notification
    |--------------------------------------------------------------------------
    |
    | Email to notify when new user registers.
    |
    */
    'email_new_user_notification' => env('APP_EMAIL_NEW_USERS_NOTIFICATION'),

    /*
    |--------------------------------------------------------------------------
    | User and error tracking
    |--------------------------------------------------------------------------
    |
    | We provide placeholders for Google Analytics, Intercom and Sentry.
    |
    */
    'google_analytics_app_id' => env('GOOGLE_ANALYTICS_APP_ID'),
    'intercom_app_id' => env('INTERCOM_APP_ID'),
    'sentry_support' => env('SENTRY_SUPPORT', false),

    /*
    |--------------------------------------------------------------------------
    | Access to paid features
    |--------------------------------------------------------------------------
    |
    | This value determines if the instance can access the paid features that
    | are available on https://monicahq.com, for free.
    | If set to false, the instance won't have access to the paid features.
    |
    | Available Settings: true, false
    |
    */
    'requires_subscription' => env('REQUIRES_SUBSCRIPTION', false),

    /*
    |--------------------------------------------------------------------------
    | Paid plan settings
    |--------------------------------------------------------------------------
    |
    | This value determines the name and the cost of the paid plan offered
    | on https://monicahq.com. These settings make sense only if you do activate
    | the `unlock_paid_features` above.
    |
    |
    */
   'paid_plan_friendly_name' => env('PAID_PLAN_FRIENDLY_NAME', null),
   'paid_plan_id' => env('PAID_PLAN_ID', null),
   'paid_plan_price' => env('PAID_PLAN_PRICE', null),

    /*
    |--------------------------------------------------------------------------
    | Ping that checks if a new version is available
    |--------------------------------------------------------------------------
    |
    | This is used to indicate if you allow the ping to be sent to
    | version.monicahq.com to check if a new version is available.
    |
    */
    'check_version' => env('CHECK_VERSION', true),

    /*
    |--------------------------------------------------------------------------
    | URL of the server for the version check
    |--------------------------------------------------------------------------
    |
    | This is the server that is used to ping if a new version is avaialble.
    | Do not change this manually.
    |
    */
    'weekly_ping_server_url' => 'https://version.monicahq.com/ping',

    /*
    |--------------------------------------------------------------------------
    | Version of the application that you run
    |--------------------------------------------------------------------------
    |
    | This is used to indicate which version of Monica you are running. You
    | should not change this setting yourself. DO NOT CHANGE IT YOURSELF. Or
    | bad things will happen.
    |
    */
    'app_version' => '1.6.2',
];
