<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use App\Middlewares\RbacMiddleware;
use App\Models\User;
use App\Services\CsrfService;

class UsuariosController
{
    public function index(): void
    {
        AuthMiddleware::handle();
        RbacMiddleware::require(['ADMINISTRADOR']);
        $usuarios = (new User())->allByEmpresa((int)$_SESSION['user']['empresa_id']);
        view('usuarios.index', ['title' => 'Usuarios', 'usuarios' => $usuarios]);
    }

    public function store(): void
    {
        AuthMiddleware::handle();
        RbacMiddleware::require(['ADMINISTRADOR']);
        if (!CsrfService::validate($_POST['_csrf'] ?? null)) {
            exit('Token CSRF inválido');
        }

        (new User())->create([
            'empresa_id' => (int)$_SESSION['user']['empresa_id'],
            'rol_id' => (int)$_POST['rol_id'],
            'nombre' => trim((string)$_POST['nombre']),
            'email' => trim((string)$_POST['email']),
            'telefono' => trim((string)$_POST['telefono']),
            'password_hash' => password_hash((string)$_POST['password'], PASSWORD_BCRYPT),
        ]);

        redirect('/usuarios');
    }
}
