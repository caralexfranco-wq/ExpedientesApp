<?php

return [
    'name' => env('APP_NAME', 'ExpedientesApp'),
    'env' => env('APP_ENV', 'local'),
    'debug' => filter_var(env('APP_DEBUG', true), FILTER_VALIDATE_BOOL),
    'url' => env('APP_URL', 'http://localhost:8080'),
    'timezone' => env('APP_TIMEZONE', 'America/Mexico_City'),
    'key' => env('APP_KEY', 'change_me'),
];
