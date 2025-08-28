<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Subscription Types Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for different subscription types
    | available in the Green Express application.
    |
    */

    'types' => [
        'basic' => [
            'name' => 'Basic',
            'description' => 'Abonnement de base - 1 repas par jour',
            'price' => 15.00,
            'duration_days' => 30,
            'meals_per_day' => 1,
            'features' => [
                '1 repas par jour',
                'Livraison incluse',
                'Menu varié',
                'Support client'
            ]
        ],
        
        'professionnel' => [
            'name' => 'Professionnel',
            'description' => 'Abonnement professionnel - 2 repas par jour',
            'price' => 25.00,
            'duration_days' => 30,
            'meals_per_day' => 2,
            'features' => [
                '2 repas par jour',
                'Livraison incluse',
                'Menu premium',
                'Support prioritaire',
                'Personnalisation des repas'
            ]
        ],
        
        'premium' => [
            'name' => 'Premium',
            'description' => 'Abonnement premium - 3 repas par jour',
            'price' => 35.00,
            'duration_days' => 30,
            'meals_per_day' => 3,
            'features' => [
                '3 repas par jour',
                'Livraison express',
                'Menu exclusif',
                'Support VIP',
                'Personnalisation complète',
                'Consultation nutritionnelle'
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription Status
    |--------------------------------------------------------------------------
    |
    | Available subscription statuses
    |
    */

    'statuses' => [
        'active' => 'Actif',
        'expired' => 'Expiré',
        'cancelled' => 'Annulé'
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-renewal Settings
    |--------------------------------------------------------------------------
    |
    | Settings for automatic subscription renewal
    |
    */

    'auto_renewal' => [
        'enabled' => true,
        'reminder_days' => 7, // Days before expiration to send reminder
        'grace_period_days' => 3 // Days after expiration before deactivation
    ]

];
