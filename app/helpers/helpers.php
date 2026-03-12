<?php

declare(strict_types=1);

if (!function_exists('config')) {
    function config(string $key, mixed $default = null): mixed
    {
        static $config = null;

        if ($config === null) {
            $config = [
                'app' => require __DIR__ . '/../../config/app.php',
                'database' => require __DIR__ . '/../../config/database.php',
                'mail' => require __DIR__ . '/../../config/mail.php',
                'whatsapp' => require __DIR__ . '/../../config/whatsapp.php',
            ];
        }

        $segments = explode('.', $key);
        $value = $config;

        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }
}

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        return $value === false || $value === null ? $default : $value;
    }
}

if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        $base = dirname(__DIR__, 2);
        return $path === '' ? $base : $base . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
    }
}

if (!function_exists('view')) {
    function view(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewPath = base_path('resources/views/' . str_replace('.', '/', $view) . '.php');
        if (!file_exists($viewPath)) {
            throw new RuntimeException("Vista {$view} no encontrada");
        }
        require base_path('resources/views/layouts/app.php');
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): never
    {
        header('Location: ' . $path);
        exit;
    }
}

if (!function_exists('e')) {
    function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
