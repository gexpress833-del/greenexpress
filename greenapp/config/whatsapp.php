<?php

return [
    'whatsapp_api_url' => env('WHATSAPP_API_URL', 'https://graph.facebook.com/v13.0/'),
    'whatsapp_token' => env('WHATSAPP_TOKEN', 'your_whatsapp_token_here'),
    'whatsapp_phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID', 'your_phone_number_id_here'),
    'default_message' => 'Thank you for your order! Your invoice and secure code will be sent shortly.',
];