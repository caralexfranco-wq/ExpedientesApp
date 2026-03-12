CREATE TABLE IF NOT EXISTS empresas (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS roles (
    id BIGINT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NULL
);

CREATE TABLE IF NOT EXISTS usuarios (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    empresa_id BIGINT NOT NULL,
    rol_id BIGINT NOT NULL,
    nombre VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefono VARCHAR(25) NULL,
    password_hash VARCHAR(255) NOT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id),
    FOREIGN KEY (rol_id) REFERENCES roles(id)
);

CREATE TABLE IF NOT EXISTS clientes (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    empresa_id BIGINT NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    email VARCHAR(150) NULL,
    telefono VARCHAR(25) NULL,
    direccion VARCHAR(255) NULL,
    rfc VARCHAR(20) NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
);

CREATE TABLE IF NOT EXISTS tipos_asunto (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    empresa_id BIGINT NOT NULL,
    nombre VARCHAR(120) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
);

CREATE TABLE IF NOT EXISTS autoridades (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    empresa_id BIGINT NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
);

CREATE TABLE IF NOT EXISTS expedientes (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    folio VARCHAR(50) NOT NULL,
    numero_expediente VARCHAR(120) NOT NULL,
    cliente_id BIGINT NOT NULL,
    empresa_id BIGINT NOT NULL,
    abogado_responsable_id BIGINT NOT NULL,
    tipo_asunto VARCHAR(120) NOT NULL,
    materia VARCHAR(80) NOT NULL,
    autoridad VARCHAR(120) NOT NULL,
    descripcion TEXT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_vencimiento DATE NOT NULL,
    fecha_termino_real DATE NULL,
    estatus ENUM('ACTIVO','CERRADO') NOT NULL DEFAULT 'ACTIVO',
    porcentaje_avance TINYINT NOT NULL DEFAULT 0,
    semaforo ENUM('VERDE','AMARILLO','ROJO','GRIS') NOT NULL DEFAULT 'VERDE',
    dias_restantes INT NOT NULL DEFAULT 0,
    requiere_convenio TINYINT(1) NOT NULL DEFAULT 0,
    requiere_amparo TINYINT(1) NOT NULL DEFAULT 0,
    notas TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (empresa_id) REFERENCES empresas(id),
    FOREIGN KEY (abogado_responsable_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS historial_expediente (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    expediente_id BIGINT NOT NULL,
    usuario_id BIGINT NOT NULL,
    descripcion TEXT NOT NULL,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (expediente_id) REFERENCES expedientes(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS convenios (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    expediente_id BIGINT NOT NULL,
    detalle TEXT NOT NULL,
    fecha_convenio DATE NOT NULL,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (expediente_id) REFERENCES expedientes(id)
);

CREATE TABLE IF NOT EXISTS amparos (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    expediente_id BIGINT NOT NULL,
    numero_amparo VARCHAR(120) NOT NULL,
    juzgado VARCHAR(150) NULL,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (expediente_id) REFERENCES expedientes(id)
);

CREATE TABLE IF NOT EXISTS notificaciones (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    empresa_id BIGINT NOT NULL,
    expediente_id BIGINT NULL,
    usuario_id BIGINT NOT NULL,
    canal ENUM('EMAIL','WHATSAPP') NOT NULL,
    tipo ENUM('AMARILLO','ROJO','VENCE_HOY','RESUMEN_DIARIO') NOT NULL,
    mensaje TEXT NOT NULL,
    enviado TINYINT(1) NOT NULL DEFAULT 0,
    enviado_en TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id),
    FOREIGN KEY (expediente_id) REFERENCES expedientes(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS agenda_diaria (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    empresa_id BIGINT NOT NULL,
    abogado_id BIGINT NOT NULL,
    fecha DATE NOT NULL,
    resumen TEXT NOT NULL,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id),
    FOREIGN KEY (abogado_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS audit_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    empresa_id BIGINT NOT NULL,
    usuario_id BIGINT NOT NULL,
    tabla VARCHAR(100) NOT NULL,
    registro_id BIGINT NOT NULL,
    accion VARCHAR(50) NOT NULL,
    payload_json JSON NULL,
    ip VARCHAR(45) NOT NULL,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS configuracion (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    empresa_id BIGINT NOT NULL,
    clave VARCHAR(100) NOT NULL,
    valor VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY uk_empresa_clave (empresa_id, clave),
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
);

CREATE TABLE IF NOT EXISTS jobs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    empresa_id BIGINT NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    payload_json JSON NULL,
    status ENUM('PENDING','PROCESSING','DONE','FAILED') NOT NULL DEFAULT 'PENDING',
    run_at DATETIME NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
);
