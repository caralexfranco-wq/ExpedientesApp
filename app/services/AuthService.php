<?php

declare(strict_types=1);

namespace App\Services;

class AuthService
{
    public static function attempt(string $email, string $password): bool
    {
        $db = Database::connection();
        $stmt = $db->prepare('SELECT * FROM usuarios WHERE email = :email AND activo = 1 LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int)$user['id'],
            'empresa_id' => (int)$user['empresa_id'],
            'nombre' => $user['nombre'],
            'email' => $user['email'],
            'rol_id' => (int)$user['rol_id'],
        ];
        return true;
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
