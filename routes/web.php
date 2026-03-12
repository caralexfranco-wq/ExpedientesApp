<?php

use App\Controllers\AuthController;
use App\Controllers\ClientesController;
use App\Controllers\DashboardController;
use App\Controllers\ExpedientesController;
use App\Controllers\ReportesController;
use App\Controllers\UsuariosController;

$router->get('/', [DashboardController::class, 'index']);
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/clientes', [ClientesController::class, 'index']);
$router->post('/clientes', [ClientesController::class, 'store']);

$router->get('/expedientes', [ExpedientesController::class, 'index']);
$router->get('/expedientes/create', [ExpedientesController::class, 'create']);
$router->post('/expedientes', [ExpedientesController::class, 'store']);

$router->get('/usuarios', [UsuariosController::class, 'index']);
$router->post('/usuarios', [UsuariosController::class, 'store']);

$router->get('/reportes', [ReportesController::class, 'index']);
$router->get('/reportes/export', [ReportesController::class, 'export']);
