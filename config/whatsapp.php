<?php

return [
    'provider' => env('WHATSAPP_PROVIDER', 'twilio'),
    'token' => env('WHATSAPP_TOKEN', ''),
    'phone_id' => env('WHATSAPP_PHONE_ID', ''),
    'to' => env('WHATSAPP_TO', ''),
    'twilio_sid' => env('TWILIO_SID', ''),
    'twilio_from' => env('TWILIO_FROM', ''),
];
