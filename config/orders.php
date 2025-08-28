<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Orders Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for order management
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Order Types
    |--------------------------------------------------------------------------
    |
    | Available order types
    |
    */

    'types' => [
        'single' => [
            'name' => 'Plat Unique',
            'description' => 'Commande de plats individuels',
            'requires_subscription' => false,
        ],
        
        'subscription' => [
            'name' => 'Abonnement',
            'description' => 'Commande basée sur un abonnement actif',
            'requires_subscription' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Order Statuses
    |--------------------------------------------------------------------------
    |
    | Available order statuses and their flow
    |
    */

    'statuses' => [
        'pending' => [
            'name' => 'En Attente',
            'description' => 'Commande en cours de validation par l\'administrateur',
            'color' => 'yellow',
            'can_transition_to' => ['validated', 'cancelled'],
        ],
        
        'validated' => [
            'name' => 'Validée',
            'description' => 'Commande confirmée et prête pour la livraison',
            'color' => 'blue',
            'can_transition_to' => ['in_delivery', 'cancelled'],
        ],
        
        'in_delivery' => [
            'name' => 'En Livraison',
            'description' => 'Commande en cours de livraison',
            'color' => 'orange',
            'can_transition_to' => ['delivered', 'cancelled'],
        ],
        
        'delivered' => [
            'name' => 'Livrée',
            'description' => 'Commande livrée avec succès',
            'color' => 'green',
            'can_transition_to' => [],
        ],
        
        'cancelled' => [
            'name' => 'Annulée',
            'description' => 'Commande annulée',
            'color' => 'red',
            'can_transition_to' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Order Settings
    |--------------------------------------------------------------------------
    |
    | General order settings
    |
    */

    'settings' => [
        'max_items_per_order' => 10,
        'min_order_amount' => 5.00,
        'max_order_amount' => 500.00,
        'auto_cancel_after_hours' => 24, // Cancel pending orders after 24 hours
        'delivery_time_slot' => 30, // minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Delivery Settings
    |--------------------------------------------------------------------------
    |
    | Delivery-related settings
    |
    */

    'delivery' => [
        'max_distance_km' => 20,
        'delivery_fee' => 0.00, // Free delivery
        'estimated_time_minutes' => 45,
        'require_signature' => false,
        'require_photo_proof' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Settings for order notifications
    |
    */

    'notifications' => [
        'send_order_confirmation' => true,
        'send_status_updates' => true,
        'send_delivery_notifications' => true,
        'send_completion_notification' => true,
    ],

];
