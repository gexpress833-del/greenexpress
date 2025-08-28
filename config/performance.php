<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Performance Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for performance optimization
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Cache configuration for performance
    |
    */

    'cache' => [
        'enabled' => true,
        'driver' => env('CACHE_DRIVER', 'file'),
        'ttl' => [
            'default' => 3600, // 1 hour
            'statistics' => 1800, // 30 minutes
            'menu' => 7200, // 2 hours
            'user_data' => 1800, // 30 minutes
            'orders' => 300, // 5 minutes
        ],
        'prefix' => 'greenexpress_',
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Optimization
    |--------------------------------------------------------------------------
    |
    | Database performance settings
    |
    */

    'database' => [
        'query_cache' => true,
        'connection_pooling' => false,
        'slow_query_log' => true,
        'slow_query_threshold' => 1000, // milliseconds
        'optimize_tables' => true,
        'index_optimization' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Asset Optimization
    |--------------------------------------------------------------------------
    |
    | Asset optimization settings
    |
    */

    'assets' => [
        'minify_css' => true,
        'minify_js' => true,
        'combine_files' => true,
        'version_assets' => true,
        'cdn_enabled' => false,
        'cdn_url' => '',
        'image_optimization' => true,
        'lazy_loading' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Performance
    |--------------------------------------------------------------------------
    |
    | API performance settings
    |
    */

    'api' => [
        'rate_limiting' => [
            'enabled' => true,
            'requests_per_minute' => 60,
            'requests_per_hour' => 1000,
        ],
        'response_caching' => true,
        'compression' => true,
        'pagination' => [
            'default_per_page' => 15,
            'max_per_page' => 100,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Performance
    |--------------------------------------------------------------------------
    |
    | Queue performance settings
    |
    */

    'queue' => [
        'driver' => env('QUEUE_CONNECTION', 'sync'),
        'workers' => [
            'default' => 2,
            'notifications' => 1,
            'reports' => 1,
        ],
        'timeout' => 60, // seconds
        'retry_after' => 90, // seconds
        'max_attempts' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Performance
    |--------------------------------------------------------------------------
    |
    | Session performance settings
    |
    */

    'session' => [
        'driver' => env('SESSION_DRIVER', 'file'),
        'lifetime' => 120, // minutes
        'expire_on_close' => false,
        'encrypt' => false,
        'secure' => false,
        'http_only' => true,
        'same_site' => 'lax',
    ],

    /*
    |--------------------------------------------------------------------------
    | Monitoring
    |--------------------------------------------------------------------------
    |
    | Performance monitoring settings
    |
    */

    'monitoring' => [
        'enabled' => true,
        'slow_request_threshold' => 2000, // milliseconds
        'memory_limit_threshold' => 80, // percentage
        'cpu_usage_threshold' => 80, // percentage
        'log_performance_metrics' => true,
        'alert_on_threshold_exceeded' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Optimization Settings
    |--------------------------------------------------------------------------
    |
    | General optimization settings
    |
    */

    'optimization' => [
        'eager_loading' => true,
        'lazy_loading' => true,
        'query_optimization' => true,
        'index_optimization' => true,
        'file_compression' => true,
        'image_compression' => true,
    ],

];
