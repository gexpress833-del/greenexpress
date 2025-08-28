<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Reports Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for reporting features
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Report Types
    |--------------------------------------------------------------------------
    |
    | Available report types
    |
    */

    'types' => [
        'sales_report' => [
            'name' => 'Rapport de Ventes',
            'description' => 'Rapport détaillé des ventes et revenus',
            'available_periods' => ['daily', 'weekly', 'monthly', 'yearly'],
            'include_charts' => true,
            'export_formats' => ['pdf', 'xlsx', 'csv'],
        ],
        
        'order_report' => [
            'name' => 'Rapport des Commandes',
            'description' => 'Analyse des commandes et leur statut',
            'available_periods' => ['daily', 'weekly', 'monthly', 'yearly'],
            'include_charts' => true,
            'export_formats' => ['pdf', 'xlsx', 'csv'],
        ],
        
        'delivery_report' => [
            'name' => 'Rapport de Livraison',
            'description' => 'Performance des livraisons et livreurs',
            'available_periods' => ['daily', 'weekly', 'monthly', 'yearly'],
            'include_charts' => true,
            'export_formats' => ['pdf', 'xlsx', 'csv'],
        ],
        
        'customer_report' => [
            'name' => 'Rapport Clients',
            'description' => 'Analyse du comportement des clients',
            'available_periods' => ['monthly', 'yearly'],
            'include_charts' => true,
            'export_formats' => ['pdf', 'xlsx', 'csv'],
        ],
        
        'subscription_report' => [
            'name' => 'Rapport Abonnements',
            'description' => 'Analyse des abonnements et leur performance',
            'available_periods' => ['monthly', 'yearly'],
            'include_charts' => true,
            'export_formats' => ['pdf', 'xlsx', 'csv'],
        ],
        
        'inventory_report' => [
            'name' => 'Rapport Inventaire',
            'description' => 'État des stocks et popularité des plats',
            'available_periods' => ['daily', 'weekly', 'monthly'],
            'include_charts' => true,
            'export_formats' => ['pdf', 'xlsx', 'csv'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Report Settings
    |--------------------------------------------------------------------------
    |
    | General report settings
    |
    */

    'settings' => [
        'max_records_per_report' => 10000,
        'auto_generate_reports' => false,
        'schedule_reports' => false,
        'email_reports' => false,
        'store_reports' => true,
        'report_retention_days' => 365,
    ],

    /*
    |--------------------------------------------------------------------------
    | Export Settings
    |--------------------------------------------------------------------------
    |
    | Export configuration
    |
    */

    'export' => [
        'pdf' => [
            'enabled' => true,
            'orientation' => 'portrait',
            'paper_size' => 'A4',
            'include_header' => true,
            'include_footer' => true,
        ],
        
        'xlsx' => [
            'enabled' => true,
            'include_charts' => true,
            'auto_filter' => true,
            'freeze_panes' => true,
        ],
        
        'csv' => [
            'enabled' => true,
            'delimiter' => ',',
            'encoding' => 'UTF-8',
            'include_headers' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Chart Settings
    |--------------------------------------------------------------------------
    |
    | Chart configuration for reports
    |
    */

    'charts' => [
        'colors' => [
            '#4CAF50', // Green
            '#2196F3', // Blue
            '#FF9800', // Orange
            '#F44336', // Red
            '#9C27B0', // Purple
            '#00BCD4', // Cyan
            '#FFEB3B', // Yellow
            '#795548', // Brown
        ],
        
        'default_chart_type' => 'line',
        'chart_height' => 400,
        'responsive' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Scheduled Reports
    |--------------------------------------------------------------------------
    |
    | Configuration for scheduled reports
    |
    */

    'scheduled_reports' => [
        'daily_sales' => [
            'enabled' => false,
            'schedule' => '0 8 * * *', // Daily at 8 AM
            'recipients' => ['admin@greenexpress.fr'],
            'report_type' => 'sales_report',
            'period' => 'daily',
        ],
        
        'weekly_summary' => [
            'enabled' => false,
            'schedule' => '0 9 * * 1', // Every Monday at 9 AM
            'recipients' => ['admin@greenexpress.fr'],
            'report_type' => 'order_report',
            'period' => 'weekly',
        ],
        
        'monthly_analysis' => [
            'enabled' => false,
            'schedule' => '0 10 1 * *', // First day of month at 10 AM
            'recipients' => ['admin@greenexpress.fr'],
            'report_type' => 'customer_report',
            'period' => 'monthly',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Report Templates
    |--------------------------------------------------------------------------
    |
    | Report template configurations
    |
    */

    'templates' => [
        'company_header' => [
            'logo' => true,
            'company_name' => 'Green Express',
            'address' => '123 Rue de la Paix, 75001 Paris',
            'phone' => '+33 1 23 45 67 89',
            'email' => 'contact@greenexpress.fr',
        ],
        
        'footer' => [
            'include_page_numbers' => true,
            'include_generation_date' => true,
            'include_filters' => true,
        ],
    ],

];
