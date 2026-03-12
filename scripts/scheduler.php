<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/helpers/helpers.php';

use App\Services\Database;
use App\Services\NotificationService;

if (file_exists(__DIR__ . '/../.env')) {
    Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();
}

$db = Database::connection();
$service = new NotificationService();

$expedientes = $db->query('SELECT e.*, u.email, u.telefono, u.nombre AS abogado FROM expedientes e INNER JOIN usuarios u ON u.id = e.abogado_responsable_id WHERE e.estatus = "ACTIVO"')->fetchAll();

foreach ($expedientes as $e) {
    $dias = (int)$e['dias_restantes'];
    if ($dias === 0 || $e['semaforo'] === 'AMARILLO' || $e['semaforo'] === 'ROJO') {
        $msg = "Expediente {$e['numero_expediente']} en estado {$e['semaforo']} (días: {$dias})";
        $service->sendEmail($e['email'], 'Alerta de expediente', $msg);
        if (!empty($e['telefono'])) {
            $service->sendWhatsapp($e['telefono'], $msg);
        }
    }
}

echo "Scheduler ejecutado\n";
