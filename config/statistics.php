<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Statistics Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for statistics and reporting
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Dashboard Statistics
    |--------------------------------------------------------------------------
    |
    | Statistics to display on dashboards
    |
    */

    'dashboard' => [
        'admin' => [
            'total_orders' => true,
            'pending_orders' => true,
            'total_revenue' => true,
            'active_subscriptions' => true,
            'total_drivers' => true,
            'total_clients' => true,
            'orders_by_status' => true,
            'revenue_by_month' => true,
            'top_meals' => true,
            'driver_performance' => true,
        ],
        
        'client' => [
            'total_orders' => true,
            'pending_orders' => true,
            'delivered_orders' => true,
            'active_subscriptions' => true,
            'total_spent' => true,
            'favorite_meals' => true,
        ],
        
        'driver' => [
            'assigned_orders' => true,
            'completed_deliveries' => true,
            'pending_deliveries' => true,
            'delivery_success_rate' => true,
            'average_delivery_time' => true,
            'earnings' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Report Settings
    |--------------------------------------------------------------------------
    |
    | Settings for generating reports
    |
    */

    'reports' => [
        'order_reports' => [
            'daily' => true,
            'weekly' => true,
            'monthly' => true,
            'yearly' => true,
            'custom_range' => true,
        ],
        
        'revenue_reports' => [
            'daily' => true,
            'weekly' => true,
            'monthly' => true,
            'yearly' => true,
            'by_subscription_type' => true,
        ],
        
        'delivery_reports' => [
            'driver_performance' => true,
            'delivery_times' => true,
            'success_rates' => true,
            'zone_analysis' => true,
        ],
        
        'customer_reports' => [
            'customer_activity' => true,
            'subscription_analytics' => true,
            'customer_satisfaction' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Data Retention
    |--------------------------------------------------------------------------
    |
    | How long to keep statistics data
    |
    */

    'data_retention' => [
        'daily_stats' => 365, // days
        'hourly_stats' => 30, // days
        'order_details' => 2555, // days (7 years)
        'delivery_logs' => 1095, // days (3 years)
        'customer_activity' => 1825, // days (5 years)
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Cache settings for statistics
    |
    */

    'cache' => [
        'enabled' => true,
        'duration' => 3600, // seconds (1 hour)
        'prefix' => 'stats_',
    ],

    /*
    |--------------------------------------------------------------------------
    | Export Settings
    |--------------------------------------------------------------------------
    |
    | Settings for exporting statistics
    |
    */

    'export' => [
        'formats' => ['csv', 'xlsx', 'pdf'],
        'max_records' => 10000,
        'include_charts' => true,
        'auto_export' => false,
    ],

];
