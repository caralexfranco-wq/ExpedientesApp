<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use App\Middlewares\RbacMiddleware;
use App\Models\Cliente;
use App\Models\Expediente;
use App\Models\User;
use App\Services\CsrfService;
use App\Services\SemaforoService;

class ExpedientesController
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $expedientes = (new Expediente())->allByEmpresa((int)$_SESSION['user']['empresa_id']);
        view('expedientes.index', ['title' => 'Expedientes', 'expedientes' => $expedientes]);
    }

    public function create(): void
    {
        AuthMiddleware::handle();
        RbacMiddleware::require(['ADMINISTRADOR', 'CAPTURISTA']);
        $empresaId = (int)$_SESSION['user']['empresa_id'];
        view('expedientes.create', [
            'title' => 'Alta de expediente',
            'clientes' => (new Cliente())->allByEmpresa($empresaId),
            'abogados' => (new User())->allByEmpresa($empresaId),
            'materias' => ['Penal','Civil','Familiar','Mercantil','Laboral','Constitucional','Administrativo','Tributario','Propiedad Intelectual'],
        ]);
    }

    public function store(): void
    {
        AuthMiddleware::handle();
        RbacMiddleware::require(['ADMINISTRADOR', 'CAPTURISTA']);
        if (!CsrfService::validate($_POST['_csrf'] ?? null)) {
            exit('Token CSRF inválido');
        }

        $semaforo = SemaforoService::calcular((string)$_POST['fecha_vencimiento'], 'ACTIVO');
        (new Expediente())->create([
            'folio' => 'F-' . date('YmdHis'),
            'numero_expediente' => trim((string)$_POST['numero_expediente']),
            'cliente_id' => (int)$_POST['cliente_id'],
            'empresa_id' => (int)$_SESSION['user']['empresa_id'],
            'abogado_responsable_id' => (int)$_POST['abogado_responsable_id'],
            'tipo_asunto' => trim((string)$_POST['tipo_asunto']),
            'materia' => trim((string)$_POST['materia']),
            'autoridad' => trim((string)$_POST['autoridad']),
            'descripcion' => trim((string)$_POST['descripcion']),
            'fecha_inicio' => (string)$_POST['fecha_inicio'],
            'fecha_vencimiento' => (string)$_POST['fecha_vencimiento'],
            'estatus' => 'ACTIVO',
            'porcentaje_avance' => (int)$_POST['porcentaje_avance'],
            'semaforo' => $semaforo['semaforo'],
            'dias_restantes' => $semaforo['dias_restantes'],
            'requiere_convenio' => isset($_POST['requiere_convenio']) ? 1 : 0,
            'requiere_amparo' => isset($_POST['requiere_amparo']) ? 1 : 0,
            'notas' => trim((string)$_POST['notas']),
        ]);

        redirect('/expedientes');
    }
}
