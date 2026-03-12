<?php

declare(strict_types=1);

namespace App\Models;

class User extends BaseModel
{
    public function allByEmpresa(int $empresaId): array
    {
        $stmt = $this->db->prepare('SELECT u.*, r.nombre AS rol FROM usuarios u INNER JOIN roles r ON r.id = u.rol_id WHERE u.empresa_id = :empresa ORDER BY u.id DESC');
        $stmt->execute(['empresa' => $empresaId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO usuarios (empresa_id, rol_id, nombre, email, telefono, password_hash, activo, created_at, updated_at) VALUES (:empresa_id, :rol_id, :nombre, :email, :telefono, :password_hash, 1, NOW(), NOW())';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
}
