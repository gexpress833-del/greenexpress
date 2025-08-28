<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Meals Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for meal management
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Meal Categories
    |--------------------------------------------------------------------------
    |
    | Available meal categories
    |
    */

    'categories' => [
        'entrée' => [
            'name' => 'Entrées',
            'description' => 'Plats d\'entrée et apéritifs',
            'display_order' => 1,
        ],
        
        'plat' => [
            'name' => 'Plats Principaux',
            'description' => 'Plats principaux et repas complets',
            'display_order' => 2,
        ],
        
        'dessert' => [
            'name' => 'Desserts',
            'description' => 'Desserts et pâtisseries',
            'display_order' => 3,
        ],
        
        'boisson' => [
            'name' => 'Boissons',
            'description' => 'Boissons et rafraîchissements',
            'display_order' => 4,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Meal Settings
    |--------------------------------------------------------------------------
    |
    | General meal settings
    |
    */

    'settings' => [
        'max_price' => 50.00,
        'min_price' => 1.00,
        'max_description_length' => 500,
        'allow_customization' => true,
        'require_image' => false,
        'auto_availability' => true, // Auto-disable when out of stock
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Settings
    |--------------------------------------------------------------------------
    |
    | Settings for meal images
    |
    */

    'images' => [
        'storage_path' => 'meals',
        'max_size' => 2048, // KB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'webp'],
        'thumbnails' => [
            'small' => [150, 150],
            'medium' => [300, 300],
            'large' => [600, 600],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Nutritional Information
    |--------------------------------------------------------------------------
    |
    | Settings for nutritional information display
    |
    */

    'nutrition' => [
        'show_calories' => true,
        'show_allergens' => true,
        'show_ingredients' => true,
        'allergens' => [
            'gluten' => 'Contient du gluten',
            'lactose' => 'Contient du lactose',
            'nuts' => 'Contient des fruits à coque',
            'eggs' => 'Contient des œufs',
            'fish' => 'Contient du poisson',
            'shellfish' => 'Contient des crustacés',
            'soy' => 'Contient du soja',
            'peanuts' => 'Contient des arachides',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dietary Preferences
    |--------------------------------------------------------------------------
    |
    | Available dietary preferences and restrictions
    |
    */

    'dietary_preferences' => [
        'vegetarian' => 'Végétarien',
        'vegan' => 'Végétalien',
        'halal' => 'Halal',
        'kosher' => 'Casher',
        'gluten_free' => 'Sans gluten',
        'lactose_free' => 'Sans lactose',
        'low_carb' => 'Faible en glucides',
        'low_fat' => 'Faible en matières grasses',
        'high_protein' => 'Riche en protéines',
    ],

];
