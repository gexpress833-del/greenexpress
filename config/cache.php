<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for cache handling
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    |
    | Supported: "apc", "array", "database", "file",
    |            "memcached", "redis", "dynamodb", "octane", "null"
    |
    */

    'default' => env('CACHE_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    | Supported drivers: "apc", "array", "database", "file",
    |                    "memcached", "redis", "dynamodb", "octane", "null"
    |
    */

    'stores' => [

        'apc' => [
            'driver' => 'apc',
        ],

        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => null,
            'lock_connection' => null,
        ],

        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
            'lock_path' => storage_path('framework/cache/data'),
        ],

        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            'sasl' => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT => 2000,
            ],
            'servers' => [
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                    'port' => env('MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'lock_connection' => 'default',
        ],

        'dynamodb' => [
            'driver' => 'dynamodb',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'table' => env('DYNAMODB_CACHE_TABLE', 'cache'),
            'endpoint' => env('DYNAMODB_ENDPOINT'),
        ],

        'octane' => [
            'driver' => 'octane',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing the APC, database, memcached, Redis, or DynamoDB cache
    | stores there might be other applications using the same cache. For
    | that reason, you may prefix every cache key to avoid collisions.
    |
    */

    'prefix' => env(
        'CACHE_PREFIX',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_cache_'
    ),

    /*
    |--------------------------------------------------------------------------
    | Cache TTL Settings
    |--------------------------------------------------------------------------
    |
    | Time-to-live settings for different cache types
    |
    */

    'ttl' => [
        'default' => 3600, // 1 hour
        'short' => 300, // 5 minutes
        'medium' => 1800, // 30 minutes
        'long' => 7200, // 2 hours
        'very_long' => 86400, // 24 hours
        
        // Application-specific TTLs
        'meals' => 7200, // 2 hours
        'orders' => 300, // 5 minutes
        'subscriptions' => 1800, // 30 minutes
        'deliveries' => 300, // 5 minutes
        'invoices' => 3600, // 1 hour
        'statistics' => 1800, // 30 minutes
        'user_data' => 1800, // 30 minutes
        'notifications' => 600, // 10 minutes
        'reports' => 3600, // 1 hour
        'api_responses' => 300, // 5 minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Tags
    |--------------------------------------------------------------------------
    |
    | Cache tags for organizing cached data
    |
    */

    'tags' => [
        'meals' => [
            'menu',
            'categories',
            'prices',
            'availability',
        ],
        'orders' => [
            'pending',
            'validated',
            'in_delivery',
            'delivered',
            'cancelled',
        ],
        'subscriptions' => [
            'active',
            'expired',
            'cancelled',
            'renewals',
        ],
        'deliveries' => [
            'assigned',
            'in_progress',
            'completed',
            'failed',
        ],
        'invoices' => [
            'generated',
            'sent',
            'paid',
            'overdue',
        ],
        'statistics' => [
            'daily',
            'weekly',
            'monthly',
            'revenue',
            'orders',
            'deliveries',
        ],
        'users' => [
            'profiles',
            'preferences',
            'activity',
            'sessions',
        ],
        'system' => [
            'settings',
            'configurations',
            'logs',
            'maintenance',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Warming
    |--------------------------------------------------------------------------
    |
    | Settings for warming up cache
    |
    */

    'warming' => [
        'enabled' => true,
        'warm_on_startup' => true,
        'warm_on_schedule' => true,
        'warm_meals' => true,
        'warm_statistics' => true,
        'warm_user_data' => false,
        'warm_reports' => false,
        'parallel_warming' => true,
        'max_parallel_jobs' => 5,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Invalidation
    |--------------------------------------------------------------------------
    |
    | Settings for cache invalidation
    |
    */

    'invalidation' => [
        'enabled' => true,
        'invalidate_on_update' => true,
        'invalidate_on_delete' => true,
        'invalidate_related' => true,
        'batch_invalidation' => true,
        'max_batch_size' => 100,
        'invalidation_delay' => 0, // seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Monitoring
    |--------------------------------------------------------------------------
    |
    | Settings for monitoring cache performance
    |
    */

    'monitoring' => [
        'enabled' => true,
        'track_hit_rate' => true,
        'track_miss_rate' => true,
        'track_size' => true,
        'track_evictions' => true,
        'alert_on_low_hit_rate' => true,
        'low_hit_rate_threshold' => 0.8, // 80%
        'log_cache_operations' => false,
        'metrics_retention_days' => 30,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Cleanup
    |--------------------------------------------------------------------------
    |
    | Settings for cleaning up cache
    |
    */

    'cleanup' => [
        'enabled' => true,
        'cleanup_expired' => true,
        'cleanup_old_tags' => true,
        'cleanup_frequency' => 'daily',
        'cleanup_time' => '03:00',
        'max_cache_size' => '1GB',
        'cleanup_strategy' => 'lru', // lru, fifo, random
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Security
    |--------------------------------------------------------------------------
    |
    | Security settings for cache
    |
    */

    'security' => [
        'encrypt_sensitive_data' => true,
        'hash_cache_keys' => false,
        'prevent_cache_poisoning' => true,
        'validate_cache_data' => true,
        'sanitize_cache_keys' => true,
    ],

];
