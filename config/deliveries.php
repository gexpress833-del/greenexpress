<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Deliveries Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for delivery management
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Delivery Statuses
    |--------------------------------------------------------------------------
    |
    | Available delivery statuses
    |
    */

    'statuses' => [
        'assigned' => [
            'name' => 'Assignée',
            'description' => 'Livraison assignée à un livreur',
            'color' => 'blue',
        ],
        
        'in_progress' => [
            'name' => 'En Cours',
            'description' => 'Livraison en cours',
            'color' => 'orange',
        ],
        
        'completed' => [
            'name' => 'Terminée',
            'description' => 'Livraison terminée avec succès',
            'color' => 'green',
        ],
        
        'failed' => [
            'name' => 'Échouée',
            'description' => 'Livraison échouée',
            'color' => 'red',
        ],
        
        'cancelled' => [
            'name' => 'Annulée',
            'description' => 'Livraison annulée',
            'color' => 'gray',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Delivery Settings
    |--------------------------------------------------------------------------
    |
    | General delivery settings
    |
    */

    'settings' => [
        'max_delivery_time_minutes' => 60,
        'auto_assign_drivers' => true,
        'require_code_validation' => true,
        'allow_partial_delivery' => false,
        'retry_failed_deliveries' => true,
        'max_retry_attempts' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Secure Code Settings
    |--------------------------------------------------------------------------
    |
    | Settings for secure delivery codes
    |
    */

    'secure_code' => [
        'length' => 8,
        'format' => 'XXXX-XXXX',
        'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',
        'expires_after_hours' => 24,
        'case_sensitive' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Driver Assignment
    |--------------------------------------------------------------------------
    |
    | Settings for driver assignment
    |
    */

    'driver_assignment' => [
        'auto_assign' => true,
        'consider_location' => true,
        'consider_availability' => true,
        'consider_workload' => true,
        'max_deliveries_per_driver' => 5,
        'assignment_timeout_minutes' => 30,
    ],

    /*
    |--------------------------------------------------------------------------
    | Delivery Zones
    |--------------------------------------------------------------------------
    |
    | Delivery zone settings
    |
    */

    'zones' => [
        'max_distance_km' => 20,
        'delivery_fee_by_zone' => [
            'zone_1' => 0.00, // 0-5 km
            'zone_2' => 2.00, // 5-10 km
            'zone_3' => 5.00, // 10-15 km
            'zone_4' => 8.00, // 15-20 km
        ],
        'estimated_time_by_zone' => [
            'zone_1' => 30, // minutes
            'zone_2' => 45,
            'zone_3' => 60,
            'zone_4' => 75,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Settings for delivery notifications
    |
    */

    'notifications' => [
        'notify_customer_on_assignment' => true,
        'notify_customer_on_start' => true,
        'notify_customer_on_completion' => true,
        'notify_admin_on_failure' => true,
        'send_delivery_reminders' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Proof of Delivery
    |--------------------------------------------------------------------------
    |
    | Settings for proof of delivery
    |
    */

    'proof_of_delivery' => [
        'require_signature' => false,
        'require_photo' => false,
        'require_code_validation' => true,
        'store_delivery_notes' => true,
    ],

];
