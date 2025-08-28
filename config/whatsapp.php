<?php

return [

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for WhatsApp Cloud API integration
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | WhatsApp Cloud API settings
    |
    */

    'api' => [
        'base_url' => 'https://graph.facebook.com/v18.0',
        'timeout' => 30, // seconds
        'retry_attempts' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Message Templates
    |--------------------------------------------------------------------------
    |
    | Predefined message templates for different scenarios
    |
    */

    'templates' => [
        'order_confirmation' => [
            'title' => 'Commande Confirmée',
            'body' => "Votre commande #{order_id} a été confirmée !\n\nMontant: {amount} €\nAdresse: {address}\n\nVotre facture et code de livraison vous seront envoyés prochainement.",
        ],
        
        'invoice_sent' => [
            'title' => 'Facture et Code de Livraison',
            'body' => "Votre commande #{order_id} est prête !\n\nCode sécurisé: {secure_code}\nMontant: {amount} €\n\nPrésentez ce code au livreur pour valider votre livraison.",
        ],
        
        'delivery_started' => [
            'title' => 'Livraison en Cours',
            'body' => "Votre commande #{order_id} est en cours de livraison !\n\nPréparez votre code sécurisé: {secure_code}\n\nLe livreur arrivera bientôt.",
        ],
        
        'delivery_completed' => [
            'title' => 'Livraison Terminée',
            'body' => "Votre commande #{order_id} a été livrée avec succès !\n\nMerci de votre confiance et bon appétit ! 🍽️",
        ],
        
        'delivery_failed' => [
            'title' => 'Problème de Livraison',
            'body' => "Nous n'avons pas pu livrer votre commande #{order_id}.\n\nRaison: {reason}\n\nNous vous recontacterons pour reprogrammer la livraison.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Settings for WhatsApp notifications
    |
    */

    'notifications' => [
        'enabled' => env('WHATSAPP_NOTIFICATIONS_ENABLED', true),
        'send_order_confirmation' => true,
        'send_invoice' => true,
        'send_delivery_updates' => true,
        'send_completion_notification' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Handling
    |--------------------------------------------------------------------------
    |
    | Error handling configuration
    |
    */

    'error_handling' => [
        'log_failures' => true,
        'retry_on_failure' => true,
        'max_retries' => 3,
        'retry_delay' => 60, // seconds
    ],

];
