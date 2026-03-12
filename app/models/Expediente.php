<?php

declare(strict_types=1);

namespace App\Models;

class Expediente extends BaseModel
{
    public function allByEmpresa(int $empresaId): array
    {
        $sql = 'SELECT e.*, c.nombre AS cliente, u.nombre AS abogado
                FROM expedientes e
                INNER JOIN clientes c ON c.id = e.cliente_id
                INNER JOIN usuarios u ON u.id = e.abogado_responsable_id
                WHERE e.empresa_id = :empresa
                ORDER BY e.fecha_vencimiento ASC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['empresa' => $empresaId]);
        return $stmt->fetchAll();
    }

    public function dashboard(int $empresaId): array
    {
        $sql = 'SELECT
                    SUM(CASE WHEN estatus = "ACTIVO" THEN 1 ELSE 0 END) AS activos,
                    SUM(CASE WHEN estatus = "CERRADO" THEN 1 ELSE 0 END) AS cerrados,
                    SUM(CASE WHEN semaforo = "VERDE" THEN 1 ELSE 0 END) AS verdes,
                    SUM(CASE WHEN semaforo = "AMARILLO" THEN 1 ELSE 0 END) AS amarillos,
                    SUM(CASE WHEN semaforo = "ROJO" THEN 1 ELSE 0 END) AS rojos
                FROM expedientes
                WHERE empresa_id = :empresa';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['empresa' => $empresaId]);
        return $stmt->fetch() ?: [];
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO expedientes (
                    folio, numero_expediente, cliente_id, empresa_id, abogado_responsable_id, tipo_asunto, materia, autoridad,
                    descripcion, fecha_inicio, fecha_vencimiento, estatus, porcentaje_avance, semaforo, dias_restantes,
                    requiere_convenio, requiere_amparo, notas, created_at, updated_at
                ) VALUES (
                    :folio, :numero_expediente, :cliente_id, :empresa_id, :abogado_responsable_id, :tipo_asunto, :materia, :autoridad,
                    :descripcion, :fecha_inicio, :fecha_vencimiento, :estatus, :porcentaje_avance, :semaforo, :dias_restantes,
                    :requiere_convenio, :requiere_amparo, :notas, NOW(), NOW()
                )';
        return $this->db->prepare($sql)->execute($data);
    }
}
