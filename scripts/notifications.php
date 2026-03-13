<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/helpers/helpers.php';

use App\Services\Database;

if (file_exists(__DIR__ . '/../.env')) {
    Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();
}

$db = Database::connection();
$sql = 'SELECT u.id abogado_id, u.nombre, u.email, COUNT(e.id) total, SUM(CASE WHEN e.semaforo = "ROJO" THEN 1 ELSE 0 END) rojos, SUM(CASE WHEN e.semaforo = "AMARILLO" THEN 1 ELSE 0 END) amarillos FROM usuarios u LEFT JOIN expedientes e ON e.abogado_responsable_id = u.id AND e.estatus = "ACTIVO" GROUP BY u.id';
$rows = $db->query($sql)->fetchAll();

foreach ($rows as $r) {
    $resumen = "Agenda diaria {$r['nombre']}: Total {$r['total']}, Amarillos {$r['amarillos']}, Rojos {$r['rojos']}";
    $db->prepare('INSERT INTO agenda_diaria (empresa_id, abogado_id, fecha, resumen, created_at) VALUES (1, :abogado_id, CURDATE(), :resumen, NOW())')
        ->execute(['abogado_id' => (int)$r['abogado_id'] ?? 1, 'resumen' => $resumen]);
}

echo "Agenda diaria generada\n";
