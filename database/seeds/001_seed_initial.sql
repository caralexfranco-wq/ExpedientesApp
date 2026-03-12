INSERT INTO empresas (id, nombre, slug, activo, created_at, updated_at)
VALUES (1, 'Despacho Demo', 'despacho-demo', 1, NOW(), NOW());

INSERT INTO roles (id, nombre, descripcion) VALUES
(1, 'ADMINISTRADOR', 'Control total'),
(2, 'CAPTURISTA', 'Operación de expedientes'),
(3, 'CONSULTOR', 'Solo consulta');

INSERT INTO usuarios (empresa_id, rol_id, nombre, email, telefono, password_hash, activo, created_at, updated_at) VALUES
(1, 1, 'Administrador General', 'admin@demo.com', '5551000001', '$2y$10$2kX3mcrZW1yA7HjR5flT1O9V0WCzQltD0J3MAnPkQei7f39w6dZrK', 1, NOW(), NOW()),
(1, 2, 'Capturista Uno', 'capturista1@demo.com', '5551000002', '$2y$10$2kX3mcrZW1yA7HjR5flT1O9V0WCzQltD0J3MAnPkQei7f39w6dZrK', 1, NOW(), NOW()),
(1, 2, 'Capturista Dos', 'capturista2@demo.com', '5551000003', '$2y$10$2kX3mcrZW1yA7HjR5flT1O9V0WCzQltD0J3MAnPkQei7f39w6dZrK', 1, NOW(), NOW()),
(1, 3, 'Consultor Uno', 'consultor1@demo.com', '5551000004', '$2y$10$2kX3mcrZW1yA7HjR5flT1O9V0WCzQltD0J3MAnPkQei7f39w6dZrK', 1, NOW(), NOW());

INSERT INTO clientes (empresa_id, nombre, email, telefono, direccion, rfc, activo, created_at, updated_at) VALUES
(1, 'Cliente Alfa', 'alfa@cliente.com', '555200001', 'CDMX', 'ALFA010101AA1', 1, NOW(), NOW()),
(1, 'Cliente Beta', 'beta@cliente.com', '555200002', 'Monterrey', 'BETA010101BB2', 1, NOW(), NOW()),
(1, 'Cliente Gamma', 'gamma@cliente.com', '555200003', 'Guadalajara', 'GAMM010101CC3', 1, NOW(), NOW()),
(1, 'Cliente Delta', 'delta@cliente.com', '555200004', 'Puebla', 'DELT010101DD4', 1, NOW(), NOW()),
(1, 'Cliente Épsilon', 'epsilon@cliente.com', '555200005', 'Querétaro', 'EPSI010101EE5', 1, NOW(), NOW());

INSERT INTO expedientes (folio, numero_expediente, cliente_id, empresa_id, abogado_responsable_id, tipo_asunto, materia, autoridad, descripcion, fecha_inicio, fecha_vencimiento, estatus, porcentaje_avance, semaforo, dias_restantes, requiere_convenio, requiere_amparo, notas, created_at, updated_at) VALUES
('F-0001', 'EXP-2026-001', 1, 1, 1, 'Audiencia Inicial', 'Penal', 'Juzgado Penal 1', 'Caso penal activo', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 20 DAY), 'ACTIVO', 35, 'VERDE', 20, 0, 0, 'Seguimiento semanal', NOW(), NOW()),
('F-0002', 'EXP-2026-002', 2, 1, 2, 'Demanda Ordinaria', 'Civil', 'Juzgado Civil 4', 'Caso civil', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 8 DAY), 'ACTIVO', 50, 'AMARILLO', 8, 1, 0, 'Conciliación en curso', NOW(), NOW()),
('F-0003', 'EXP-2026-003', 3, 1, 3, 'Custodia', 'Familiar', 'Juzgado Familiar 2', 'Caso familiar', CURDATE(), DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'ACTIVO', 70, 'ROJO', -1, 0, 1, 'Requiere amparo', NOW(), NOW()),
('F-0004', 'EXP-2026-004', 4, 1, 1, 'Cobro de pagaré', 'Mercantil', 'Juzgado Mercantil 3', 'Caso mercantil', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 12 DAY), 'ACTIVO', 10, 'VERDE', 12, 0, 0, '', NOW(), NOW()),
('F-0005', 'EXP-2026-005', 5, 1, 2, 'Despido injustificado', 'Laboral', 'Tribunal Laboral 1', 'Caso laboral', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 4 DAY), 'ACTIVO', 40, 'AMARILLO', 4, 0, 0, '', NOW(), NOW()),
('F-0006', 'EXP-2026-006', 1, 1, 3, 'Amparo Indirecto', 'Constitucional', 'Juzgado Distrito', 'Caso constitucional', CURDATE(), DATE_SUB(CURDATE(), INTERVAL 3 DAY), 'ACTIVO', 80, 'ROJO', -3, 0, 1, '', NOW(), NOW()),
('F-0007', 'EXP-2026-007', 2, 1, 1, 'Nulidad administrativa', 'Administrativo', 'Tribunal Administrativo', 'Caso administrativo', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 16 DAY), 'ACTIVO', 15, 'VERDE', 16, 0, 0, '', NOW(), NOW()),
('F-0008', 'EXP-2026-008', 3, 1, 2, 'Crédito fiscal', 'Tributario', 'SAT', 'Caso tributario', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 9 DAY), 'ACTIVO', 65, 'AMARILLO', 9, 1, 0, '', NOW(), NOW()),
('F-0009', 'EXP-2026-009', 4, 1, 3, 'Marca registrada', 'Propiedad Intelectual', 'IMPI', 'PI marca', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 25 DAY), 'ACTIVO', 20, 'VERDE', 25, 0, 0, '', NOW(), NOW()),
('F-0010', 'EXP-2026-010', 5, 1, 1, 'Incidente cerrado', 'Civil', 'Juzgado Civil 6', 'Caso cerrado', CURDATE(), DATE_SUB(CURDATE(), INTERVAL 5 DAY), 'CERRADO', 100, 'GRIS', 0, 0, 0, 'Concluido', NOW(), NOW());
