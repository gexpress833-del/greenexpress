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

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Cloud API
    |--------------------------------------------------------------------------
    |
    | Configuration for Meta WhatsApp Cloud API
    |
    */

    'whatsapp' => [
        'token' => env('WHATSAPP_TOKEN'),
        'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
        'business_account_id' => env('WHATSAPP_BUSINESS_ACCOUNT_ID'),
        'webhook_verify_token' => env('WHATSAPP_WEBHOOK_VERIFY_TOKEN'),
        'base_url' => 'https://graph.facebook.com/v18.0',
        'timeout' => 30,
        'retry_attempts' => 3,
        'retry_delay' => 5,
        'templates' => [
            'order_confirmation' => env('WHATSAPP_TEMPLATE_ORDER_CONFIRMATION'),
            'invoice_sent' => env('WHATSAPP_TEMPLATE_INVOICE_SENT'),
            'delivery_update' => env('WHATSAPP_TEMPLATE_DELIVERY_UPDATE'),
            'subscription_reminder' => env('WHATSAPP_TEMPLATE_SUBSCRIPTION_REMINDER'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Gateway
    |--------------------------------------------------------------------------
    |
    | Configuration for payment processing
    |
    */

    'stripe' => [
        'secret' => env('STRIPE_SECRET'),
        'key' => env('STRIPE_KEY'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'currency' => 'eur',
        'timeout' => 30,
        'retry_attempts' => 3,
    ],

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET'),
        'mode' => env('PAYPAL_MODE', 'sandbox'), // sandbox or live
        'webhook_id' => env('PAYPAL_WEBHOOK_ID'),
        'currency' => 'EUR',
        'timeout' => 30,
        'retry_attempts' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Maps and Geocoding
    |--------------------------------------------------------------------------
    |
    | Configuration for mapping services
    |
    */

    'google_maps' => [
        'api_key' => env('GOOGLE_MAPS_API_KEY'),
        'base_url' => 'https://maps.googleapis.com/maps/api',
        'timeout' => 30,
        'retry_attempts' => 3,
        'services' => [
            'geocoding' => true,
            'directions' => true,
            'distance_matrix' => true,
            'places' => true,
        ],
    ],

    'mapbox' => [
        'access_token' => env('MAPBOX_ACCESS_TOKEN'),
        'base_url' => 'https://api.mapbox.com',
        'timeout' => 30,
        'retry_attempts' => 3,
        'services' => [
            'geocoding' => true,
            'directions' => true,
            'distance_matrix' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | SMS Services
    |--------------------------------------------------------------------------
    |
    | Configuration for SMS services
    |
    */

    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'from_number' => env('TWILIO_FROM_NUMBER'),
        'timeout' => 30,
        'retry_attempts' => 3,
    ],

    'nexmo' => [
        'key' => env('NEXMO_KEY'),
        'secret' => env('NEXMO_SECRET'),
        'from' => env('NEXMO_FROM'),
        'timeout' => 30,
        'retry_attempts' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | File Storage
    |--------------------------------------------------------------------------
    |
    | Configuration for file storage services
    |
    */

    'aws' => [
        'access_key_id' => env('AWS_ACCESS_KEY_ID'),
        'secret_access_key' => env('AWS_SECRET_ACCESS_KEY'),
        'default_region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'bucket' => env('AWS_BUCKET'),
        'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        'endpoint' => env('AWS_ENDPOINT'),
        'timeout' => 60,
        'retry_attempts' => 3,
    ],

    'cloudinary' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'api_key' => env('CLOUDINARY_API_KEY'),
        'api_secret' => env('CLOUDINARY_API_SECRET'),
        'timeout' => 60,
        'retry_attempts' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Analytics and Monitoring
    |--------------------------------------------------------------------------
    |
    | Configuration for analytics and monitoring services
    |
    */

    'google_analytics' => [
        'tracking_id' => env('GOOGLE_ANALYTICS_TRACKING_ID'),
        'enabled' => env('GOOGLE_ANALYTICS_ENABLED', false),
    ],

    'sentry' => [
        'dsn' => env('SENTRY_LARAVEL_DSN'),
        'environment' => env('SENTRY_ENVIRONMENT', 'production'),
        'traces_sample_rate' => env('SENTRY_TRACES_SAMPLE_RATE', 0.1),
        'enabled' => env('SENTRY_ENABLED', false),
    ],

    'new_relic' => [
        'license_key' => env('NEW_RELIC_LICENSE_KEY'),
        'app_name' => env('NEW_RELIC_APP_NAME', 'Green Express'),
        'enabled' => env('NEW_RELIC_ENABLED', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Media
    |--------------------------------------------------------------------------
    |
    | Configuration for social media integrations
    |
    */

    'facebook' => [
        'app_id' => env('FACEBOOK_APP_ID'),
        'app_secret' => env('FACEBOOK_APP_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
        'timeout' => 30,
        'retry_attempts' => 3,
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
        'timeout' => 30,
        'retry_attempts' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Services
    |--------------------------------------------------------------------------
    |
    | Configuration for email services
    |
    */

    'sendgrid' => [
        'api_key' => env('SENDGRID_API_KEY'),
        'from_email' => env('SENDGRID_FROM_EMAIL'),
        'from_name' => env('SENDGRID_FROM_NAME'),
        'timeout' => 30,
        'retry_attempts' => 3,
    ],

    'mailchimp' => [
        'api_key' => env('MAILCHIMP_API_KEY'),
        'server_prefix' => env('MAILCHIMP_SERVER_PREFIX'),
        'list_id' => env('MAILCHIMP_LIST_ID'),
        'timeout' => 30,
        'retry_attempts' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Services
    |--------------------------------------------------------------------------
    |
    | Configuration for external database services
    |
    */

    'redis' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD', null),
        'port' => env('REDIS_PORT', 6379),
        'database' => env('REDIS_DB', 0),
        'timeout' => 5,
        'retry_attempts' => 3,
    ],

    'elasticsearch' => [
        'hosts' => [
            env('ELASTICSEARCH_HOST', 'localhost:9200'),
        ],
        'username' => env('ELASTICSEARCH_USERNAME'),
        'password' => env('ELASTICSEARCH_PASSWORD'),
        'timeout' => 30,
        'retry_attempts' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Services
    |--------------------------------------------------------------------------
    |
    | Configuration for queue services
    |
    */

    'beanstalkd' => [
        'host' => env('BEANSTALKD_HOST', '127.0.0.1'),
        'port' => env('BEANSTALKD_PORT', 11300),
        'timeout' => 60,
        'retry_attempts' => 3,
    ],

    'sqs' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
        'queue' => env('SQS_QUEUE', 'default'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'timeout' => 60,
        'retry_attempts' => 3,
    ],

];
