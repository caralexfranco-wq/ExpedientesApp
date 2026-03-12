<?php

use App\Services\AuthService;
use App\Services\CsrfService;

$user = AuthService::user();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(($title ?? 'ExpedientesApp')) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<div class="d-flex">
    <?php if ($user): ?>
        <aside class="sidebar p-3">
            <h4 class="mb-4">Inicio</h4>
            <ul class="nav flex-column gap-2">
                <li><a class="btn btn-light text-start w-100" href="/">Inicio</a></li>
                <li><div class="fw-bold mt-2">Clientes</div>
                    <a class="nav-link" href="/clientes">• Altas</a>
                    <a class="nav-link" href="/clientes">• Bajas</a>
                    <a class="nav-link" href="/clientes">• Cambios</a>
                    <a class="nav-link" href="/clientes">• Mostrar información</a>
                </li>
                <li><div class="fw-bold mt-2">Expedientes o Casos</div>
                    <a class="nav-link" href="/expedientes/create">• Alta</a>
                    <a class="nav-link" href="/expedientes">• Cerrar</a>
                    <a class="nav-link" href="/expedientes">• Cambios</a>
                    <a class="nav-link" href="/expedientes">• Mostrar semáforo</a>
                    <a class="nav-link" href="/reportes">• Reportes</a>
                </li>
                <li><div class="fw-bold mt-2">Usuarios</div>
                    <a class="nav-link" href="/usuarios">• Altas</a>
                    <a class="nav-link" href="/usuarios">• Bajas</a>
                    <a class="nav-link" href="/usuarios">• Cambios</a>
                    <a class="nav-link" href="/usuarios">• Mostrar información</a>
                </li>
            </ul>
            <form method="post" action="/logout" class="mt-4">
                <input type="hidden" name="_csrf" value="<?= e(CsrfService::token()) ?>">
                <button class="btn btn-danger w-100">Salir</button>
            </form>
        </aside>
    <?php endif; ?>

    <main class="content flex-grow-1">
        <?php if ($user): ?>
            <header class="topbar d-flex justify-content-between align-items-center p-3 border-bottom bg-white">
                <h5 class="mb-0"><?= e($title ?? 'Panel') ?></h5>
                <span><?= e($user['nombre']) ?></span>
            </header>
        <?php endif; ?>
        <section class="p-4">
            <?php require $viewPath; ?>
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="/js/app.js"></script>
</body>
</html>
