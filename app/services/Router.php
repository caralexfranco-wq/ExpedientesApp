<?php

declare(strict_types=1);

namespace App\Services;

class Router
{
    private array $routes = [];

    public function get(string $uri, callable|array $handler): void
    {
        $this->map('GET', $uri, $handler);
    }

    public function post(string $uri, callable|array $handler): void
    {
        $this->map('POST', $uri, $handler);
    }

    private function map(string $method, string $uri, callable|array $handler): void
    {
        $this->routes[$method][rtrim($uri, '/') ?: '/'] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = rtrim(parse_url($uri, PHP_URL_PATH) ?: '/', '/') ?: '/';
        $handler = $this->routes[$method][$uri] ?? null;

        if (!$handler) {
            http_response_code(404);
            echo '404 - Recurso no encontrado';
            return;
        }

        if (is_array($handler)) {
            [$class, $action] = $handler;
            (new $class())->{$action}();
            return;
        }

        $handler();
    }
}
