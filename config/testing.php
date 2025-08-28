<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Testing Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for testing features
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Test Database
    |--------------------------------------------------------------------------
    |
    | Database configuration for testing
    |
    */

    'database' => [
        'connection' => 'sqlite',
        'database' => ':memory:',
        'migrate' => true,
        'seed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Test Data
    |--------------------------------------------------------------------------
    |
    | Test data configuration
    |
    */

    'test_data' => [
        'users' => [
            'admin' => [
                'name' => 'Test Admin',
                'email' => 'admin@test.com',
                'password' => 'password',
                'role' => 'admin',
            ],
            'client' => [
                'name' => 'Test Client',
                'email' => 'client@test.com',
                'password' => 'password',
                'role' => 'client',
            ],
            'driver' => [
                'name' => 'Test Driver',
                'email' => 'driver@test.com',
                'password' => 'password',
                'role' => 'driver',
            ],
        ],
        
        'meals' => [
            'count' => 10,
            'categories' => ['entrée', 'plat', 'dessert', 'boisson'],
        ],
        
        'orders' => [
            'count' => 20,
            'statuses' => ['pending', 'validated', 'in_delivery', 'delivered'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Mock Services
    |--------------------------------------------------------------------------
    |
    | Mock service configurations for testing
    |
    */

    'mocks' => [
        'whatsapp' => [
            'enabled' => true,
            'mock_responses' => [
                'success' => ['success' => true, 'message_id' => 'test_message_id'],
                'failure' => ['success' => false, 'error' => 'Test error'],
            ],
        ],
        
        'payment' => [
            'enabled' => true,
            'mock_responses' => [
                'success' => ['success' => true, 'transaction_id' => 'test_transaction_id'],
                'failure' => ['success' => false, 'error' => 'Payment failed'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Test Settings
    |--------------------------------------------------------------------------
    |
    | General test settings
    |
    */

    'settings' => [
        'parallel' => false,
        'timeout' => 60, // seconds
        'memory_limit' => '512M',
        'coverage' => [
            'enabled' => false,
            'threshold' => 80, // percentage
            'exclude' => [
                'app/Console/*',
                'app/Exceptions/*',
                'database/*',
                'tests/*',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Test Environment
    |--------------------------------------------------------------------------
    |
    | Test environment settings
    |
    */

    'environment' => [
        'cache_driver' => 'array',
        'session_driver' => 'array',
        'queue_driver' => 'sync',
        'mail_driver' => 'array',
        'log_driver' => 'array',
    ],

    /*
    |--------------------------------------------------------------------------
    | Test Utilities
    |--------------------------------------------------------------------------
    |
    | Test utility configurations
    |
    */

    'utilities' => [
        'faker_locale' => 'fr_FR',
        'factory_count' => 10,
        'seed_random' => true,
        'cleanup_after_tests' => true,
    ],

];
