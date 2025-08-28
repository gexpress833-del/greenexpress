<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Invoice Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for invoice generation and management
    | in the Green Express application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Invoice Number Format
    |--------------------------------------------------------------------------
    |
    | Format for generating invoice numbers
    | Available placeholders:
    | {YEAR} - Current year (4 digits)
    | {MONTH} - Current month (2 digits)
    | {DAY} - Current day (2 digits)
    | {SEQUENCE} - Sequential number
    |
    */

    'number_format' => 'INV-{YEAR}-{SEQUENCE}',

    /*
    |--------------------------------------------------------------------------
    | Secure Code Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for generating secure delivery codes
    |
    */

    'secure_code' => [
        'length' => 12, // Total length of the code
        'format' => 'XXXX-XXXX-XXXX', // Format with X as placeholders
        'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', // Characters to use
    ],

    /*
    |--------------------------------------------------------------------------
    | PDF Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for PDF generation
    |
    */

    'pdf' => [
        'paper_size' => 'A4',
        'orientation' => 'portrait',
        'margin' => 20, // mm
        'storage_path' => 'invoices',
    ],

    /*
    |--------------------------------------------------------------------------
    | Company Information
    |--------------------------------------------------------------------------
    |
    | Company details for invoice generation
    |
    */

    'company' => [
        'name' => 'Green Express',
        'address' => '123 Rue de la Paix',
        'city' => '75001 Paris',
        'country' => 'France',
        'phone' => '+33 1 23 45 67 89',
        'email' => 'contact@greenexpress.fr',
        'website' => 'www.greenexpress.fr',
        'siret' => '123 456 789 00012',
        'vat_number' => 'FR12345678901',
    ],

    /*
    |--------------------------------------------------------------------------
    | Invoice Settings
    |--------------------------------------------------------------------------
    |
    | General invoice settings
    |
    */

    'settings' => [
        'currency' => 'EUR',
        'currency_symbol' => '€',
        'tax_rate' => 0, // 0% for food delivery
        'payment_terms' => 'Paiement à la livraison',
        'notes' => 'Merci de votre confiance !',
    ],

];
