<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filesystem Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for filesystem handling
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        /*
        |--------------------------------------------------------------------------
        | Application-Specific Disks
        |--------------------------------------------------------------------------
        |
        | Custom disks for different file types
        |
        */

        'meals' => [
            'driver' => 'local',
            'root' => storage_path('app/public/meals'),
            'url' => env('APP_URL').'/storage/meals',
            'visibility' => 'public',
            'throw' => false,
        ],

        'invoices' => [
            'driver' => 'local',
            'root' => storage_path('app/invoices'),
            'url' => env('APP_URL').'/storage/invoices',
            'visibility' => 'private',
            'throw' => false,
        ],

        'reports' => [
            'driver' => 'local',
            'root' => storage_path('app/reports'),
            'url' => env('APP_URL').'/storage/reports',
            'visibility' => 'private',
            'throw' => false,
        ],

        'backups' => [
            'driver' => 'local',
            'root' => storage_path('app/backups'),
            'visibility' => 'private',
            'throw' => false,
        ],

        'logs' => [
            'driver' => 'local',
            'root' => storage_path('logs'),
            'visibility' => 'private',
            'throw' => false,
        ],

        'temp' => [
            'driver' => 'local',
            'root' => storage_path('app/temp'),
            'visibility' => 'private',
            'throw' => false,
        ],

        'uploads' => [
            'driver' => 'local',
            'root' => storage_path('app/public/uploads'),
            'url' => env('APP_URL').'/storage/uploads',
            'visibility' => 'public',
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('meals') => storage_path('app/public/meals'),
        public_path('uploads') => storage_path('app/public/uploads'),
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Settings
    |--------------------------------------------------------------------------
    |
    | Settings for file uploads
    |
    */

    'uploads' => [
        'max_file_size' => 10240, // 10MB
        'allowed_extensions' => [
            'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
            'archives' => ['zip', 'rar', '7z'],
        ],
        'image_processing' => [
            'enabled' => true,
            'resize_large_images' => true,
            'max_width' => 1920,
            'max_height' => 1080,
            'quality' => 85,
            'create_thumbnails' => true,
            'thumbnail_size' => [300, 300],
        ],
        'virus_scanning' => [
            'enabled' => false,
            'scan_on_upload' => true,
            'quarantine_infected' => true,
        ],
        'watermarking' => [
            'enabled' => false,
            'watermark_image' => 'watermark.png',
            'position' => 'bottom-right',
            'opacity' => 0.5,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | File Organization
    |--------------------------------------------------------------------------
    |
    | Settings for file organization
    |
    */

    'organization' => [
        'use_date_folders' => true,
        'date_format' => 'Y/m/d',
        'use_hash_folders' => true,
        'hash_length' => 2,
        'max_files_per_folder' => 1000,
        'auto_cleanup' => true,
        'cleanup_empty_folders' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | File Security
    |--------------------------------------------------------------------------
    |
    | Security settings for files
    |
    */

    'security' => [
        'scan_uploads' => true,
        'validate_file_types' => true,
        'check_file_signatures' => true,
        'prevent_execution' => true,
        'encrypt_sensitive_files' => false,
        'access_control' => [
            'invoices' => ['admin', 'client'],
            'reports' => ['admin'],
            'backups' => ['admin'],
            'logs' => ['admin'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | File Backup
    |--------------------------------------------------------------------------
    |
    | Backup settings for files
    |
    */

    'backup' => [
        'enabled' => true,
        'backup_uploads' => true,
        'backup_invoices' => true,
        'backup_reports' => true,
        'backup_frequency' => 'daily',
        'retention_days' => 30,
        'compress_backups' => true,
        'encrypt_backups' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | File Monitoring
    |--------------------------------------------------------------------------
    |
    | Monitoring settings for files
    |
    */

    'monitoring' => [
        'enabled' => true,
        'track_disk_usage' => true,
        'alert_on_high_usage' => true,
        'high_usage_threshold' => 80, // percentage
        'track_file_operations' => true,
        'log_file_access' => false,
        'monitor_upload_activity' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | File Cleanup
    |--------------------------------------------------------------------------
    |
    | Cleanup settings for files
    |
    */

    'cleanup' => [
        'enabled' => true,
        'cleanup_temp_files' => true,
        'temp_file_retention_hours' => 24,
        'cleanup_old_logs' => true,
        'log_retention_days' => 90,
        'cleanup_old_backups' => true,
        'backup_retention_days' => 30,
        'cleanup_frequency' => 'daily',
        'cleanup_time' => '04:00',
    ],

];
