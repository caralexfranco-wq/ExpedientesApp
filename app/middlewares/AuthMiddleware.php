<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Services\AuthService;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!AuthService::check()) {
            redirect('/login');
        }
    }
}
