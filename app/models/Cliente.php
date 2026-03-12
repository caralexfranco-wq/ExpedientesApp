<?php

declare(strict_types=1);

namespace App\Models;

class Cliente extends BaseModel
{
    public function allByEmpresa(int $empresaId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM clientes WHERE empresa_id = :empresa ORDER BY id DESC');
        $stmt->execute(['empresa' => $empresaId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO clientes (empresa_id, nombre, email, telefono, direccion, rfc, activo, created_at, updated_at) VALUES (:empresa_id, :nombre, :email, :telefono, :direccion, :rfc, 1, NOW(), NOW())';
        return $this->db->prepare($sql)->execute($data);
    }
}
