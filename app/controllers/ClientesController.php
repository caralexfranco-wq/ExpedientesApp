<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use App\Middlewares\RbacMiddleware;
use App\Models\Cliente;
use App\Services\CsrfService;

class ClientesController
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $clientes = (new Cliente())->allByEmpresa((int)$_SESSION['user']['empresa_id']);
        view('clientes.index', ['title' => 'Clientes', 'clientes' => $clientes]);
    }

    public function store(): void
    {
        AuthMiddleware::handle();
        RbacMiddleware::require(['ADMINISTRADOR']);
        if (!CsrfService::validate($_POST['_csrf'] ?? null)) {
            exit('Token CSRF inválido');
        }

        (new Cliente())->create([
            'empresa_id' => (int)$_SESSION['user']['empresa_id'],
            'nombre' => trim((string)$_POST['nombre']),
            'email' => trim((string)$_POST['email']),
            'telefono' => trim((string)$_POST['telefono']),
            'direccion' => trim((string)$_POST['direccion']),
            'rfc' => trim((string)$_POST['rfc']),
        ]);

        redirect('/clientes');
    }
}
