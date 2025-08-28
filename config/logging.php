<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;

return [

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for logging
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
            'replace_placeholders' => true,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
            'replace_placeholders' => true,
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => env('LOG_PAPERTRAIL_HANDLER', SyslogUdpHandler::class),
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
                'connectionString' => 'tls://'.env('PAPERTRAIL_URL').':'.env('PAPERTRAIL_PORT'),
            ],
            'processors' => [PsrLogMessageProcessor::class],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
            'processors' => [PsrLogMessageProcessor::class],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
            'facility' => LOG_USER,
            'replace_placeholders' => true,
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        /*
        |--------------------------------------------------------------------------
        | Application-Specific Log Channels
        |--------------------------------------------------------------------------
        |
        | Custom log channels for different application components
        |
        */

        'orders' => [
            'driver' => 'daily',
            'path' => storage_path('logs/orders.log'),
            'level' => 'info',
            'days' => 30,
            'replace_placeholders' => true,
        ],

        'deliveries' => [
            'driver' => 'daily',
            'path' => storage_path('logs/deliveries.log'),
            'level' => 'info',
            'days' => 30,
            'replace_placeholders' => true,
        ],

        'payments' => [
            'driver' => 'daily',
            'path' => storage_path('logs/payments.log'),
            'level' => 'info',
            'days' => 90,
            'replace_placeholders' => true,
        ],

        'notifications' => [
            'driver' => 'daily',
            'path' => storage_path('logs/notifications.log'),
            'level' => 'info',
            'days' => 30,
            'replace_placeholders' => true,
        ],

        'whatsapp' => [
            'driver' => 'daily',
            'path' => storage_path('logs/whatsapp.log'),
            'level' => 'info',
            'days' => 30,
            'replace_placeholders' => true,
        ],

        'security' => [
            'driver' => 'daily',
            'path' => storage_path('logs/security.log'),
            'level' => 'warning',
            'days' => 90,
            'replace_placeholders' => true,
        ],

        'audit' => [
            'driver' => 'daily',
            'path' => storage_path('logs/audit.log'),
            'level' => 'info',
            'days' => 365,
            'replace_placeholders' => true,
        ],

        'api' => [
            'driver' => 'daily',
            'path' => storage_path('logs/api.log'),
            'level' => 'info',
            'days' => 30,
            'replace_placeholders' => true,
        ],

        'performance' => [
            'driver' => 'daily',
            'path' => storage_path('logs/performance.log'),
            'level' => 'info',
            'days' => 30,
            'replace_placeholders' => true,
        ],

        'errors' => [
            'driver' => 'daily',
            'path' => storage_path('logs/errors.log'),
            'level' => 'error',
            'days' => 90,
            'replace_placeholders' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Log Settings
    |--------------------------------------------------------------------------
    |
    | General log settings
    |
    */

    'settings' => [
        'enable_logging' => true,
        'log_level' => env('LOG_LEVEL', 'debug'),
        'log_requests' => true,
        'log_responses' => false,
        'log_user_activity' => true,
        'log_database_queries' => env('DB_QUERY_LOGGING', false),
        'log_slow_queries' => true,
        'slow_query_threshold' => 1000, // milliseconds
        'log_file_permissions' => 0644,
        'log_directory_permissions' => 0755,
        'max_log_file_size' => '10MB',
        'compress_old_logs' => true,
        'delete_old_logs' => true,
        'log_retention_days' => 90,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Formatting
    |--------------------------------------------------------------------------
    |
    | Log formatting settings
    |
    */

    'formatting' => [
        'include_timestamp' => true,
        'include_user_id' => true,
        'include_ip_address' => true,
        'include_user_agent' => false,
        'include_request_id' => true,
        'include_session_id' => false,
        'include_memory_usage' => false,
        'include_execution_time' => false,
        'mask_sensitive_data' => true,
        'sensitive_fields' => [
            'password',
            'password_confirmation',
            'token',
            'api_key',
            'secret',
            'credit_card',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Monitoring
    |--------------------------------------------------------------------------
    |
    | Log monitoring settings
    |
    */

    'monitoring' => [
        'enabled' => true,
        'monitor_error_rate' => true,
        'error_rate_threshold' => 0.1, // 10%
        'monitor_log_size' => true,
        'max_log_size' => '1GB',
        'alert_on_high_error_rate' => true,
        'alert_on_large_log_files' => true,
        'log_monitoring_events' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Cleanup
    |--------------------------------------------------------------------------
    |
    | Log cleanup settings
    |
    */

    'cleanup' => [
        'enabled' => true,
        'cleanup_frequency' => 'daily',
        'cleanup_time' => '03:00',
        'delete_old_logs' => true,
        'compress_old_logs' => true,
        'archive_old_logs' => false,
        'archive_location' => storage_path('logs/archive'),
        'retention_policy' => [
            'laravel' => 30, // days
            'orders' => 90,
            'deliveries' => 90,
            'payments' => 365,
            'notifications' => 30,
            'whatsapp' => 30,
            'security' => 365,
            'audit' => 365,
            'api' => 30,
            'performance' => 30,
            'errors' => 90,
        ],
    ],

];
