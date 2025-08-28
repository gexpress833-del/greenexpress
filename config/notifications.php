<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Notification Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for notifications
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    |
    | Available notification channels
    |
    */

    'channels' => [
        'whatsapp' => [
            'enabled' => true,
            'driver' => 'whatsapp',
            'timeout' => 30,
            'retry_attempts' => 3,
            'retry_delay' => 5,
            'batch_size' => 10,
            'rate_limit' => [
                'enabled' => true,
                'messages_per_minute' => 60,
                'messages_per_hour' => 1000,
            ],
        ],
        
        'email' => [
            'enabled' => true,
            'driver' => 'smtp',
            'timeout' => 30,
            'retry_attempts' => 3,
            'retry_delay' => 5,
            'batch_size' => 50,
            'rate_limit' => [
                'enabled' => true,
                'emails_per_minute' => 100,
                'emails_per_hour' => 1000,
            ],
        ],
        
        'sms' => [
            'enabled' => false,
            'driver' => 'twilio',
            'timeout' => 30,
            'retry_attempts' => 3,
            'retry_delay' => 5,
            'batch_size' => 10,
            'rate_limit' => [
                'enabled' => true,
                'sms_per_minute' => 30,
                'sms_per_hour' => 500,
            ],
        ],
        
        'push' => [
            'enabled' => false,
            'driver' => 'firebase',
            'timeout' => 30,
            'retry_attempts' => 3,
            'retry_delay' => 5,
            'batch_size' => 100,
            'rate_limit' => [
                'enabled' => true,
                'notifications_per_minute' => 200,
                'notifications_per_hour' => 5000,
            ],
        ],
        
        'database' => [
            'enabled' => true,
            'driver' => 'database',
            'table' => 'notifications',
            'batch_size' => 100,
        ],
        
        'broadcast' => [
            'enabled' => false,
            'driver' => 'pusher',
            'timeout' => 30,
            'retry_attempts' => 3,
            'retry_delay' => 5,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Types
    |--------------------------------------------------------------------------
    |
    | Available notification types and their configurations
    |
    */

    'types' => [
        'order_confirmation' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'email'],
            'template' => 'notifications.order_confirmation',
            'subject' => 'Confirmation de commande - Green Express',
            'whatsapp_template' => 'order_confirmation',
            'delay' => 0,
            'retry' => true,
            'max_retries' => 3,
        ],
        
        'order_validated' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'email'],
            'template' => 'notifications.order_validated',
            'subject' => 'Commande validée - Green Express',
            'whatsapp_template' => 'order_validated',
            'delay' => 0,
            'retry' => true,
            'max_retries' => 3,
        ],
        
        'invoice_sent' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'email'],
            'template' => 'notifications.invoice_sent',
            'subject' => 'Facture envoyée - Green Express',
            'whatsapp_template' => 'invoice_sent',
            'delay' => 0,
            'retry' => true,
            'max_retries' => 3,
            'attachments' => ['pdf'],
        ],
        
        'delivery_assigned' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'email', 'push'],
            'template' => 'notifications.delivery_assigned',
            'subject' => 'Livraison assignée - Green Express',
            'whatsapp_template' => 'delivery_assigned',
            'delay' => 0,
            'retry' => true,
            'max_retries' => 3,
        ],
        
        'delivery_started' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'email', 'push'],
            'template' => 'notifications.delivery_started',
            'subject' => 'Livraison en cours - Green Express',
            'whatsapp_template' => 'delivery_started',
            'delay' => 0,
            'retry' => true,
            'max_retries' => 3,
        ],
        
        'delivery_completed' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'email', 'push'],
            'template' => 'notifications.delivery_completed',
            'subject' => 'Livraison terminée - Green Express',
            'whatsapp_template' => 'delivery_completed',
            'delay' => 0,
            'retry' => true,
            'max_retries' => 3,
        ],
        
        'subscription_created' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'email'],
            'template' => 'notifications.subscription_created',
            'subject' => 'Abonnement créé - Green Express',
            'whatsapp_template' => 'subscription_created',
            'delay' => 0,
            'retry' => true,
            'max_retries' => 3,
        ],
        
        'subscription_expiring' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'email'],
            'template' => 'notifications.subscription_expiring',
            'subject' => 'Abonnement expirant - Green Express',
            'whatsapp_template' => 'subscription_expiring',
            'delay' => 0,
            'retry' => true,
            'max_retries' => 3,
        ],
        
        'subscription_expired' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'email'],
            'template' => 'notifications.subscription_expired',
            'subject' => 'Abonnement expiré - Green Express',
            'whatsapp_template' => 'subscription_expired',
            'delay' => 0,
            'retry' => true,
            'max_retries' => 3,
        ],
        
        'payment_reminder' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'email'],
            'template' => 'notifications.payment_reminder',
            'subject' => 'Rappel de paiement - Green Express',
            'whatsapp_template' => 'payment_reminder',
            'delay' => 0,
            'retry' => true,
            'max_retries' => 3,
        ],
        
        'order_cancelled' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'email'],
            'template' => 'notifications.order_cancelled',
            'subject' => 'Commande annulée - Green Express',
            'whatsapp_template' => 'order_cancelled',
            'delay' => 0,
            'retry' => true,
            'max_retries' => 3,
        ],
        
        'system_alert' => [
            'enabled' => true,
            'channels' => ['email', 'database'],
            'template' => 'notifications.system_alert',
            'subject' => 'Alerte système - Green Express',
            'delay' => 0,
            'retry' => true,
            'max_retries' => 3,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Templates
    |--------------------------------------------------------------------------
    |
    | Template configurations for different notification types
    |
    */

    'templates' => [
        'whatsapp' => [
            'order_confirmation' => [
                'name' => 'order_confirmation',
                'language' => 'fr',
                'variables' => [
                    'customer_name',
                    'order_number',
                    'order_date',
                    'total_amount',
                    'delivery_address',
                ],
            ],
            
            'invoice_sent' => [
                'name' => 'invoice_sent',
                'language' => 'fr',
                'variables' => [
                    'customer_name',
                    'invoice_number',
                    'amount',
                    'secure_code',
                    'delivery_time',
                ],
            ],
            
            'delivery_update' => [
                'name' => 'delivery_update',
                'language' => 'fr',
                'variables' => [
                    'customer_name',
                    'order_number',
                    'status',
                    'estimated_time',
                    'driver_name',
                ],
            ],
            
            'subscription_reminder' => [
                'name' => 'subscription_reminder',
                'language' => 'fr',
                'variables' => [
                    'customer_name',
                    'subscription_type',
                    'expiry_date',
                    'renewal_amount',
                ],
            ],
        ],
        
        'email' => [
            'default_layout' => 'emails.layouts.default',
            'default_styles' => 'emails.styles.default',
            'logo_url' => env('APP_URL') . '/images/logo.png',
            'company_name' => 'Green Express',
            'company_address' => '123 Rue de la Santé, 75001 Paris',
            'company_phone' => '+33 1 23 45 67 89',
            'company_email' => 'contact@greenexpress.fr',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | General notification settings
    |
    */

    'settings' => [
        'default_timezone' => 'Europe/Paris',
        'default_language' => 'fr',
        'fallback_language' => 'en',
        'batch_processing' => true,
        'queue_notifications' => true,
        'queue_name' => 'notifications',
        'max_attempts' => 3,
        'retry_delay' => 300, // 5 minutes
        'cleanup_old_notifications' => true,
        'cleanup_days' => 90,
        'log_notifications' => true,
        'track_delivery_status' => true,
        'respect_user_preferences' => true,
        'send_during_business_hours' => false,
        'business_hours' => [
            'start' => '08:00',
            'end' => '20:00',
            'timezone' => 'Europe/Paris',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Preferences
    |--------------------------------------------------------------------------
    |
    | User notification preferences
    |
    */

    'preferences' => [
        'channels' => [
            'whatsapp' => true,
            'email' => true,
            'sms' => false,
            'push' => false,
        ],
        
        'types' => [
            'order_updates' => true,
            'delivery_updates' => true,
            'subscription_updates' => true,
            'payment_reminders' => true,
            'promotional' => false,
            'system_alerts' => false,
        ],
        
        'frequency' => [
            'immediate' => true,
            'daily_digest' => false,
            'weekly_digest' => false,
        ],
        
        'quiet_hours' => [
            'enabled' => false,
            'start' => '22:00',
            'end' => '08:00',
            'timezone' => 'Europe/Paris',
        ],
    ],

];
