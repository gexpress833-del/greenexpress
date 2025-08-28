<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Roles Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for user roles and permissions
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Available Roles
    |--------------------------------------------------------------------------
    |
    | Define all available user roles
    |
    */

    'roles' => [
        'admin' => [
            'name' => 'Administrateur',
            'description' => 'Accès complet à toutes les fonctionnalités',
            'permissions' => [
                'manage_users',
                'manage_meals',
                'manage_subscriptions',
                'manage_orders',
                'view_statistics',
                'generate_reports',
                'manage_system',
            ],
        ],
        
        'client' => [
            'name' => 'Client',
            'description' => 'Utilisateur final - peut passer des commandes',
            'permissions' => [
                'view_own_profile',
                'place_orders',
                'view_own_orders',
                'manage_subscriptions',
                'view_menu',
            ],
        ],
        
        'driver' => [
            'name' => 'Livreur',
            'description' => 'Livreur - gère les livraisons',
            'permissions' => [
                'view_assigned_orders',
                'update_delivery_status',
                'validate_delivery',
                'view_delivery_history',
                'view_own_profile',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Role Hierarchy
    |--------------------------------------------------------------------------
    |
    | Define role hierarchy and inheritance
    |
    */

    'hierarchy' => [
        'admin' => ['client', 'driver'],
        'client' => [],
        'driver' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Role
    |--------------------------------------------------------------------------
    |
    | Default role for new users
    |
    */

    'default_role' => 'client',

    /*
    |--------------------------------------------------------------------------
    | Role Display Settings
    |--------------------------------------------------------------------------
    |
    | Settings for displaying roles in the interface
    |
    */

    'display' => [
        'show_badges' => true,
        'badge_colors' => [
            'admin' => 'bg-red-100 text-red-800',
            'client' => 'bg-blue-100 text-blue-800',
            'driver' => 'bg-green-100 text-green-800',
        ],
    ],

];
