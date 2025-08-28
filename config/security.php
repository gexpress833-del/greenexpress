<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for security features
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Authentication Settings
    |--------------------------------------------------------------------------
    |
    | Authentication and session settings
    |
    */

    'authentication' => [
        'session_lifetime' => 120, // minutes
        'remember_me_lifetime' => 43200, // minutes (30 days)
        'max_login_attempts' => 5,
        'lockout_duration' => 15, // minutes
        'password_min_length' => 8,
        'password_require_special_chars' => true,
        'password_require_numbers' => true,
        'password_require_uppercase' => true,
        'password_expiry_days' => 90,
    ],

    /*
    |--------------------------------------------------------------------------
    | Secure Code Settings
    |--------------------------------------------------------------------------
    |
    | Settings for secure delivery codes
    |
    */

    'secure_codes' => [
        'length' => 12,
        'format' => 'XXXX-XXXX-XXXX',
        'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',
        'expires_after_hours' => 24,
        'case_sensitive' => false,
        'max_attempts' => 3,
        'lockout_duration' => 30, // minutes
        'regenerate_on_failure' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Security
    |--------------------------------------------------------------------------
    |
    | API security settings
    |
    */

    'api' => [
        'rate_limiting' => [
            'enabled' => true,
            'max_requests_per_minute' => 60,
            'max_requests_per_hour' => 1000,
        ],
        
        'cors' => [
            'allowed_origins' => ['*'],
            'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            'allowed_headers' => ['*'],
            'exposed_headers' => [],
            'max_age' => 86400,
            'supports_credentials' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Data Protection
    |--------------------------------------------------------------------------
    |
    | Data protection and privacy settings
    |
    */

    'data_protection' => [
        'encrypt_sensitive_data' => true,
        'mask_phone_numbers' => true,
        'mask_credit_cards' => true,
        'log_data_access' => true,
        'data_retention_policy' => [
            'orders' => 2555, // days (7 years)
            'user_data' => 1825, // days (5 years)
            'logs' => 365, // days (1 year)
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Security
    |--------------------------------------------------------------------------
    |
    | File upload security settings
    |
    */

    'file_uploads' => [
        'max_file_size' => 2048, // KB
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp', 'pdf'],
        'scan_for_viruses' => true,
        'store_outside_webroot' => true,
        'generate_unique_names' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | CSRF Protection
    |--------------------------------------------------------------------------
    |
    | CSRF protection settings
    |
    */

    'csrf' => [
        'enabled' => true,
        'token_lifetime' => 60, // minutes
        'regenerate_on_login' => true,
        'exclude_paths' => [
            '/api/*',
            '/webhook/*',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | XSS Protection
    |--------------------------------------------------------------------------
    |
    | XSS protection settings
    |
    */

    'xss' => [
        'enabled' => true,
        'strip_tags' => true,
        'escape_output' => true,
        'content_security_policy' => [
            'default-src' => ["'self'"],
            'script-src' => ["'self'", "'unsafe-inline'", 'cdn.tailwindcss.com', 'cdnjs.cloudflare.com'],
            'style-src' => ["'self'", "'unsafe-inline'", 'cdn.tailwindcss.com', 'cdnjs.cloudflare.com'],
            'img-src' => ["'self'", 'data:', 'https:'],
            'font-src' => ["'self'", 'cdnjs.cloudflare.com'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Logging
    |--------------------------------------------------------------------------
    |
    | Audit logging settings
    |
    */

    'audit_logging' => [
        'enabled' => true,
        'log_level' => 'info',
        'events' => [
            'user_login',
            'user_logout',
            'order_creation',
            'order_modification',
            'order_deletion',
            'payment_processing',
            'admin_actions',
            'data_access',
        ],
        'retention_days' => 365,
    ],

];
