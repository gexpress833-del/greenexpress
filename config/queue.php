<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Queue Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for queue processing
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    |
    | Laravel's queue API supports an assortment of back-ends via a single
    | API, giving you convenient access to each back-end using the same
    | syntax for every one. Here you may define a default connection.
    |
    */

    'default' => env('QUEUE_CONNECTION', 'sync'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection information for each server that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with Laravel. You are free to add more.
    |
    | Drivers: "sync", "database", "beanstalkd", "sqs", "redis", "null"
    |
    */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
            'after_commit' => false,
        ],

        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => 'localhost',
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => null,
            'after_commit' => false,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'default'),
            'suffix' => env('SQS_SUFFIX'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'after_commit' => false,
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
            'after_commit' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Workers
    |--------------------------------------------------------------------------
    |
    | Queue worker configuration for different job types
    |
    */

    'workers' => [
        'default' => [
            'connection' => 'database',
            'queue' => 'default',
            'sleep' => 3,
            'max_tries' => 3,
            'timeout' => 60,
            'memory' => 512,
            'max_jobs' => 1000,
            'rest' => 0,
        ],
        
        'orders' => [
            'connection' => 'database',
            'queue' => 'orders',
            'sleep' => 3,
            'max_tries' => 3,
            'timeout' => 120,
            'memory' => 512,
            'max_jobs' => 500,
            'rest' => 0,
        ],
        
        'deliveries' => [
            'connection' => 'database',
            'queue' => 'deliveries',
            'sleep' => 3,
            'max_tries' => 3,
            'timeout' => 120,
            'memory' => 512,
            'max_jobs' => 500,
            'rest' => 0,
        ],
        
        'notifications' => [
            'connection' => 'database',
            'queue' => 'notifications',
            'sleep' => 3,
            'max_tries' => 5,
            'timeout' => 60,
            'memory' => 256,
            'max_jobs' => 1000,
            'rest' => 0,
        ],
        
        'invoices' => [
            'connection' => 'database',
            'queue' => 'invoices',
            'sleep' => 3,
            'max_tries' => 3,
            'timeout' => 180,
            'memory' => 1024,
            'max_jobs' => 200,
            'rest' => 0,
        ],
        
        'subscriptions' => [
            'connection' => 'database',
            'queue' => 'subscriptions',
            'sleep' => 3,
            'max_tries' => 3,
            'timeout' => 120,
            'memory' => 512,
            'max_jobs' => 300,
            'rest' => 0,
        ],
        
        'reports' => [
            'connection' => 'database',
            'queue' => 'reports',
            'sleep' => 3,
            'max_tries' => 2,
            'timeout' => 300,
            'memory' => 1024,
            'max_jobs' => 100,
            'rest' => 0,
        ],
        
        'system' => [
            'connection' => 'database',
            'queue' => 'system',
            'sleep' => 3,
            'max_tries' => 3,
            'timeout' => 60,
            'memory' => 256,
            'max_jobs' => 500,
            'rest' => 0,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of failed queue job logging so you
    | can control which database and table are used to store the jobs that
    | have failed. You may change them to any database / table you wish.
    |
    */

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Settings
    |--------------------------------------------------------------------------
    |
    | General queue settings
    |
    */

    'settings' => [
        'enable_queue_monitoring' => true,
        'monitor_queue_sizes' => true,
        'alert_on_queue_size' => 1000,
        'cleanup_failed_jobs' => true,
        'cleanup_days' => 30,
        'retry_failed_jobs' => true,
        'max_retry_attempts' => 3,
        'retry_delay' => 300, // 5 minutes
        'log_job_execution' => true,
        'log_job_failures' => true,
        'job_timeout' => 300, // 5 minutes
        'memory_limit' => '512M',
        'max_jobs_per_worker' => 1000,
        'worker_rest_time' => 0, // seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Priorities
    |--------------------------------------------------------------------------
    |
    | Priority levels for different job types
    |
    */

    'priorities' => [
        'high' => [
            'notifications',
            'deliveries',
            'orders',
        ],
        'medium' => [
            'invoices',
            'subscriptions',
            'reports',
        ],
        'low' => [
            'system',
            'cleanup',
            'analytics',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Monitoring
    |--------------------------------------------------------------------------
    |
    | Queue monitoring configuration
    |
    */

    'monitoring' => [
        'enabled' => true,
        'check_interval' => 60, // seconds
        'alert_thresholds' => [
            'queue_size' => 1000,
            'failed_jobs' => 100,
            'processing_time' => 300, // seconds
        ],
        'notifications' => [
            'email' => true,
            'slack' => false,
            'webhook' => false,
        ],
        'metrics' => [
            'queue_size' => true,
            'processing_time' => true,
            'failure_rate' => true,
            'throughput' => true,
        ],
    ],

];
