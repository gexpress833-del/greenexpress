<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Payments Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for payment processing
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Payment Methods
    |--------------------------------------------------------------------------
    |
    | Available payment methods
    |
    */

    'methods' => [
        'cash_on_delivery' => [
            'name' => 'Paiement à la Livraison',
            'description' => 'Paiement en espèces à la livraison',
            'enabled' => true,
            'fee' => 0.00,
            'requires_online_payment' => false,
        ],
        
        'card_on_delivery' => [
            'name' => 'Carte à la Livraison',
            'description' => 'Paiement par carte à la livraison',
            'enabled' => true,
            'fee' => 0.00,
            'requires_online_payment' => false,
        ],
        
        'online_payment' => [
            'name' => 'Paiement en Ligne',
            'description' => 'Paiement sécurisé en ligne',
            'enabled' => false, // Disabled for now
            'fee' => 0.50,
            'requires_online_payment' => true,
        ],
        
        'subscription_credit' => [
            'name' => 'Crédit Abonnement',
            'description' => 'Paiement via crédit d\'abonnement',
            'enabled' => true,
            'fee' => 0.00,
            'requires_online_payment' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    |
    | General payment settings
    |
    */

    'settings' => [
        'currency' => 'EUR',
        'currency_symbol' => '€',
        'tax_rate' => 0.00, // 0% for food delivery
        'minimum_order_amount' => 5.00,
        'maximum_order_amount' => 500.00,
        'auto_capture' => true,
        'require_confirmation' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Processors
    |--------------------------------------------------------------------------
    |
    | Payment processor configurations
    |
    */

    'processors' => [
        'stripe' => [
            'enabled' => env('STRIPE_ENABLED', false),
            'public_key' => env('STRIPE_PUBLIC_KEY'),
            'secret_key' => env('STRIPE_SECRET_KEY'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        ],
        
        'paypal' => [
            'enabled' => env('PAYPAL_ENABLED', false),
            'client_id' => env('PAYPAL_CLIENT_ID'),
            'client_secret' => env('PAYPAL_CLIENT_SECRET'),
            'mode' => env('PAYPAL_MODE', 'sandbox'), // sandbox or live
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Invoice Settings
    |--------------------------------------------------------------------------
    |
    | Invoice generation settings
    |
    */

    'invoice' => [
        'auto_generate' => true,
        'include_tax_breakdown' => false,
        'include_payment_terms' => true,
        'payment_terms' => 'Paiement à la livraison',
        'due_date_days' => 0, // Due immediately
    ],

    /*
    |--------------------------------------------------------------------------
    | Refund Settings
    |--------------------------------------------------------------------------
    |
    | Refund processing settings
    |
    */

    'refunds' => [
        'allow_refunds' => true,
        'auto_refund_cancelled' => true,
        'refund_fee' => 0.00,
        'refund_methods' => [
            'original_payment_method' => true,
            'store_credit' => true,
            'bank_transfer' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription Billing
    |--------------------------------------------------------------------------
    |
    | Subscription billing settings
    |
    */

    'subscription_billing' => [
        'auto_billing' => false, // Manual billing for now
        'billing_cycle' => 'monthly',
        'grace_period_days' => 3,
        'retry_attempts' => 3,
        'retry_interval_days' => 7,
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    |
    | Payment security settings
    |
    */

    'security' => [
        'encrypt_payment_data' => true,
        'mask_card_numbers' => true,
        'log_payment_attempts' => true,
        'fraud_detection' => false, // Basic fraud detection
        'require_cvv' => true,
        'require_3d_secure' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Payment notification settings
    |
    */

    'notifications' => [
        'payment_success' => true,
        'payment_failed' => true,
        'refund_processed' => true,
        'subscription_renewal' => true,
        'payment_reminder' => true,
    ],

];
