<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\AuthService;
use App\Services\CsrfService;

class AuthController
{
    public function loginForm(): void
    {
        view('auth.login', ['title' => 'Acceso']);
    }

    public function login(): void
    {
        if (!CsrfService::validate($_POST['_csrf'] ?? null)) {
            exit('Token CSRF inválido');
        }

        if (AuthService::attempt((string)$_POST['email'], (string)$_POST['password'])) {
            redirect('/');
        }

        $_SESSION['error'] = 'Credenciales inválidas';
        redirect('/login');
    }

    public function logout(): void
    {
        AuthService::logout();
        redirect('/login');
    }
}
