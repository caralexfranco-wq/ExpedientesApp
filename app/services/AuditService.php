<?php

declare(strict_types=1);

namespace App\Services;

class AuditService
{
    public static function log(int $empresaId, int $usuarioId, string $tabla, int $registroId, string $accion, array $payload = []): void
    {
        $sql = 'INSERT INTO audit_logs (empresa_id, usuario_id, tabla, registro_id, accion, payload_json, ip, created_at) VALUES (:empresa_id, :usuario_id, :tabla, :registro_id, :accion, :payload_json, :ip, NOW())';
        Database::connection()->prepare($sql)->execute([
            'empresa_id' => $empresaId,
            'usuario_id' => $usuarioId,
            'tabla' => $tabla,
            'registro_id' => $registroId,
            'accion' => $accion,
            'payload_json' => json_encode($payload, JSON_UNESCAPED_UNICODE),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'CLI',
        ]);
    }
}
