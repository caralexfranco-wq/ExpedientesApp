<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use App\Models\Expediente;

class DashboardController
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $stats = (new Expediente())->dashboard((int)$_SESSION['user']['empresa_id']);
        view('dashboard.index', ['title' => 'Inicio', 'stats' => $stats]);
    }
}
