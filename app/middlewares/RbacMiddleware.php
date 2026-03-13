<?php

declare(strict_types=1);

namespace App\Middlewares;

class RbacMiddleware
{
    private const ROLE_MAP = [
        'ADMINISTRADOR' => 1,
        'CAPTURISTA' => 2,
        'CONSULTOR' => 3,
    ];

    public static function require(array $roles): void
    {
        $allowed = array_map(static fn($role) => self::ROLE_MAP[$role] ?? 0, $roles);
        $rolId = (int)($_SESSION['user']['rol_id'] ?? 0);
        if (!in_array($rolId, $allowed, true)) {
            http_response_code(403);
            exit('Acceso denegado');
        }
    }
}
