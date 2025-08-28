<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Scheduler Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for scheduled tasks
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Order Management Tasks
    |--------------------------------------------------------------------------
    |
    | Tasks related to order management
    |
    */

    'orders' => [
        'auto_cancel_pending' => [
            'enabled' => true,
            'schedule' => '*/30 * * * *', // Every 30 minutes
            'description' => 'Annuler automatiquement les commandes en attente depuis plus de 24h',
            'timeout_hours' => 24,
        ],
        
        'cleanup_old_orders' => [
            'enabled' => true,
            'schedule' => '0 2 * * 0', // Every Sunday at 2 AM
            'description' => 'Nettoyer les anciennes commandes',
            'retention_days' => 2555, // 7 years
        ],
        
        'generate_daily_stats' => [
            'enabled' => true,
            'schedule' => '0 1 * * *', // Daily at 1 AM
            'description' => 'Générer les statistiques quotidiennes',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription Management Tasks
    |--------------------------------------------------------------------------
    |
    | Tasks related to subscription management
    |
    */

    'subscriptions' => [
        'check_expiring' => [
            'enabled' => true,
            'schedule' => '0 9 * * *', // Daily at 9 AM
            'description' => 'Vérifier les abonnements expirant bientôt',
            'reminder_days' => [7, 3, 1], // Send reminders 7, 3, and 1 day before
        ],
        
        'expire_subscriptions' => [
            'enabled' => true,
            'schedule' => '0 0 * * *', // Daily at midnight
            'description' => 'Marquer les abonnements expirés',
        ],
        
        'cleanup_expired' => [
            'enabled' => true,
            'schedule' => '0 3 * * 0', // Every Sunday at 3 AM
            'description' => 'Nettoyer les abonnements expirés',
            'retention_days' => 365, // 1 year
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Delivery Management Tasks
    |--------------------------------------------------------------------------
    |
    | Tasks related to delivery management
    |
    */

    'deliveries' => [
        'check_delayed_deliveries' => [
            'enabled' => true,
            'schedule' => '*/15 * * * *', // Every 15 minutes
            'description' => 'Vérifier les livraisons en retard',
            'max_delivery_time_minutes' => 60,
        ],
        
        'cleanup_delivery_logs' => [
            'enabled' => true,
            'schedule' => '0 4 * * 0', // Every Sunday at 4 AM
            'description' => 'Nettoyer les logs de livraison',
            'retention_days' => 1095, // 3 years
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Tasks
    |--------------------------------------------------------------------------
    |
    | Tasks related to notifications
    |
    */

    'notifications' => [
        'send_delivery_reminders' => [
            'enabled' => true,
            'schedule' => '*/10 * * * *', // Every 10 minutes
            'description' => 'Envoyer les rappels de livraison',
        ],
        
        'retry_failed_notifications' => [
            'enabled' => true,
            'schedule' => '*/5 * * * *', // Every 5 minutes
            'description' => 'Réessayer les notifications échouées',
            'max_retries' => 3,
        ],
        
        'cleanup_notification_logs' => [
            'enabled' => true,
            'schedule' => '0 5 * * 0', // Every Sunday at 5 AM
            'description' => 'Nettoyer les logs de notifications',
            'retention_days' => 30,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | System Maintenance Tasks
    |--------------------------------------------------------------------------
    |
    | System maintenance tasks
    |
    */

    'maintenance' => [
        'backup_database' => [
            'enabled' => true,
            'schedule' => '0 2 * * *', // Daily at 2 AM
            'description' => 'Sauvegarder la base de données',
            'retention_days' => 30,
        ],
        
        'cleanup_temp_files' => [
            'enabled' => true,
            'schedule' => '0 6 * * *', // Daily at 6 AM
            'description' => 'Nettoyer les fichiers temporaires',
            'retention_days' => 7,
        ],
        
        'optimize_database' => [
            'enabled' => true,
            'schedule' => '0 3 * * 0', // Every Sunday at 3 AM
            'description' => 'Optimiser la base de données',
        ],
        
        'clear_cache' => [
            'enabled' => true,
            'schedule' => '0 4 * * *', // Daily at 4 AM
            'description' => 'Vider le cache',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Report Generation Tasks
    |--------------------------------------------------------------------------
    |
    | Tasks for generating reports
    |
    */

    'reports' => [
        'generate_daily_sales_report' => [
            'enabled' => false,
            'schedule' => '0 8 * * *', // Daily at 8 AM
            'description' => 'Générer le rapport de ventes quotidien',
            'email_recipients' => ['admin@greenexpress.fr'],
        ],
        
        'generate_weekly_summary' => [
            'enabled' => false,
            'schedule' => '0 9 * * 1', // Every Monday at 9 AM
            'description' => 'Générer le résumé hebdomadaire',
            'email_recipients' => ['admin@greenexpress.fr'],
        ],
        
        'generate_monthly_analysis' => [
            'enabled' => false,
            'schedule' => '0 10 1 * *', // First day of month at 10 AM
            'description' => 'Générer l\'analyse mensuelle',
            'email_recipients' => ['admin@greenexpress.fr'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Task Settings
    |--------------------------------------------------------------------------
    |
    | General task settings
    |
    */

    'settings' => [
        'max_execution_time' => 300, // seconds
        'memory_limit' => '512M',
        'log_all_tasks' => true,
        'notify_on_failure' => true,
        'failure_notification_email' => 'admin@greenexpress.fr',
        'retry_failed_tasks' => true,
        'max_retry_attempts' => 3,
        'retry_delay_minutes' => 5,
    ],

];
