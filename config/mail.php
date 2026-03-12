<?php

return [
    'host' => env('SMTP_HOST', 'localhost'),
    'port' => env('SMTP_PORT', 25),
    'username' => env('SMTP_USER', ''),
    'password' => env('SMTP_PASS', ''),
    'from_address' => env('SMTP_FROM', 'noreply@example.com'),
    'from_name' => env('SMTP_FROM_NAME', 'Expedientes App'),
];
