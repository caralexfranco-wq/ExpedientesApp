<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use App\Models\Expediente;
use App\Services\ReportService;

class ReportesController
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $rows = (new Expediente())->allByEmpresa((int)$_SESSION['user']['empresa_id']);
        view('reportes.index', ['title' => 'Reportes', 'rows' => $rows]);
    }

    public function export(): void
    {
        AuthMiddleware::handle();
        $rows = (new Expediente())->allByEmpresa((int)$_SESSION['user']['empresa_id']);
        $format = $_GET['format'] ?? 'excel';
        $service = new ReportService();
        $filename = 'reporte_' . date('Ymd_His');

        $path = match ($format) {
            'word' => $service->exportWord($rows, $filename),
            'ppt' => $service->exportPowerPoint($rows, $filename),
            default => $service->exportExcel($rows, $filename),
        };

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
        readfile($path);
    }
}
