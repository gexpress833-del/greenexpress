<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mail Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for mail handling
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers to be used while
    | sending an e-mail. You will specify which one you are using for your
    | mailers below. You are free to add additional mailers as required.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "log", "array", "failover", "roundrobin"
    |
    */

    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'url' => env('MAIL_URL'),
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN'),
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'mailgun' => [
            'transport' => 'mailgun',
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'postmark' => [
            'transport' => 'postmark',
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
        ],

        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers' => [
                'ses',
                'postmark',
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'noreply@greenexpress.fr'),
        'name' => env('MAIL_FROM_NAME', 'Green Express'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure the
    | theme and component paths here, allowing you to customize the design
    | of the emails. Or, you may simply stick with the Laravel defaults!
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Templates
    |--------------------------------------------------------------------------
    |
    | Email template configurations
    |
    */

    'templates' => [
        'order_confirmation' => [
            'subject' => 'Confirmation de commande - Green Express',
            'template' => 'emails.orders.confirmation',
            'variables' => [
                'customer_name',
                'order_number',
                'order_date',
                'total_amount',
                'delivery_address',
            ],
        ],
        
        'order_validated' => [
            'subject' => 'Commande validée - Green Express',
            'template' => 'emails.orders.validated',
            'variables' => [
                'customer_name',
                'order_number',
                'secure_code',
                'estimated_delivery_time',
            ],
        ],
        
        'invoice_sent' => [
            'subject' => 'Facture envoyée - Green Express',
            'template' => 'emails.invoices.sent',
            'variables' => [
                'customer_name',
                'invoice_number',
                'amount',
                'secure_code',
                'payment_due_date',
            ],
        ],
        
        'delivery_update' => [
            'subject' => 'Mise à jour de livraison - Green Express',
            'template' => 'emails.deliveries.update',
            'variables' => [
                'customer_name',
                'order_number',
                'status',
                'estimated_time',
                'driver_name',
            ],
        ],
        
        'subscription_reminder' => [
            'subject' => 'Rappel d\'abonnement - Green Express',
            'template' => 'emails.subscriptions.reminder',
            'variables' => [
                'customer_name',
                'subscription_type',
                'expiry_date',
                'renewal_amount',
            ],
        ],
        
        'welcome' => [
            'subject' => 'Bienvenue chez Green Express',
            'template' => 'emails.welcome',
            'variables' => [
                'customer_name',
                'account_type',
            ],
        ],
        
        'password_reset' => [
            'subject' => 'Réinitialisation de mot de passe - Green Express',
            'template' => 'emails.auth.password_reset',
            'variables' => [
                'customer_name',
                'reset_url',
                'expiry_time',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Settings
    |--------------------------------------------------------------------------
    |
    | General email settings
    |
    */

    'settings' => [
        'enable_email_notifications' => true,
        'default_language' => 'fr',
        'fallback_language' => 'en',
        'batch_processing' => true,
        'queue_emails' => true,
        'queue_name' => 'emails',
        'max_attempts' => 3,
        'retry_delay' => 300, // 5 minutes
        'timeout' => 30, // seconds
        'rate_limiting' => [
            'enabled' => true,
            'emails_per_minute' => 100,
            'emails_per_hour' => 1000,
        ],
        'tracking' => [
            'enabled' => true,
            'track_opens' => true,
            'track_clicks' => true,
            'track_bounces' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Preferences
    |--------------------------------------------------------------------------
    |
    | User email preferences
    |
    */

    'preferences' => [
        'default_frequency' => 'immediate',
        'available_frequencies' => [
            'immediate' => 'Immédiat',
            'daily_digest' => 'Résumé quotidien',
            'weekly_digest' => 'Résumé hebdomadaire',
        ],
        'quiet_hours' => [
            'enabled' => false,
            'start' => '22:00',
            'end' => '08:00',
            'timezone' => 'Europe/Paris',
        ],
        'unsubscribe_enabled' => true,
        'unsubscribe_url' => '/unsubscribe',
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Monitoring
    |--------------------------------------------------------------------------
    |
    | Email monitoring settings
    |
    */

    'monitoring' => [
        'enabled' => true,
        'track_delivery_status' => true,
        'track_bounce_rate' => true,
        'track_spam_complaints' => true,
        'alert_on_high_bounce_rate' => true,
        'high_bounce_rate_threshold' => 0.05, // 5%
        'log_email_events' => true,
        'metrics_retention_days' => 90,
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Cleanup
    |--------------------------------------------------------------------------
    |
    | Email cleanup settings
    |
    */

    'cleanup' => [
        'enabled' => true,
        'cleanup_failed_emails' => true,
        'cleanup_old_logs' => true,
        'cleanup_frequency' => 'daily',
        'cleanup_time' => '04:00',
        'retention_days' => 30,
    ],

];
