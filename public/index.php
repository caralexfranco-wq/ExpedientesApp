<?php

declare(strict_types=1);

use App\Services\Router;

$autoload = dirname(__DIR__) . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    http_response_code(500);
    exit('Dependencias no instaladas. Ejecuta: composer install');
}

require $autoload;
require dirname(__DIR__) . '/app/helpers/helpers.php';

if (class_exists(\Dotenv\Dotenv::class) && file_exists(dirname(__DIR__) . '/.env')) {
    \Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();
}

date_default_timezone_set(config('app.timezone'));

session_set_cookie_params([
    'httponly' => true,
    'secure' => false,
    'samesite' => 'Lax',
]);
session_start();

$router = new Router();
require dirname(__DIR__) . '/routes/web.php';

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
$_SERVER['APP_BASE_PATH'] = $scriptDir === '/' ? '' : rtrim($scriptDir, '/');

$requestUri = (string)($_SERVER['REQUEST_URI'] ?? '/');
$requestPath = parse_url($requestUri, PHP_URL_PATH) ?: '/';
if ($_SERVER['APP_BASE_PATH'] !== '' && str_starts_with($requestPath, $_SERVER['APP_BASE_PATH'])) {
    $requestPath = substr($requestPath, strlen($_SERVER['APP_BASE_PATH'])) ?: '/';
}

if ($requestPath === '/index.php' || $requestPath === '/index.php/') {
    $requestPath = '/';
}

$router->dispatch($_SERVER['REQUEST_METHOD'], $requestPath);
