# ExpedientesApp

Plataforma jurídica empresarial multiempresa (MVC PHP 8.2) para gestión de clientes, expedientes, semaforización, agenda diaria, alertas, reportes y auditoría.

## 1) Árbol completo del proyecto

```text
ExpedientesApp/
├── app/
│   ├── controllers/
│   ├── helpers/
│   ├── middlewares/
│   ├── models/
│   └── services/
├── config/
├── database/
│   ├── migrations/
│   └── seeds/
├── docker/
├── public/
│   ├── css/
│   ├── images/
│   └── js/
├── resources/
│   └── views/
│       ├── auth/
│       ├── clientes/
│       ├── dashboard/
│       ├── expedientes/
│       ├── layouts/
│       ├── partials/
│       ├── reportes/
│       └── usuarios/
├── routes/
├── scripts/
├── storage/
│   ├── exports/
│   ├── logs/
│   └── uploads/
├── .env.example
├── composer.json
└── docker-compose.yml
```

## 2) Migraciones SQL

Archivo: `database/migrations/001_create_tables.sql`

Incluye tablas:
- empresas
- usuarios
- roles
- clientes
- expedientes
- tipos_asunto
- autoridades
- historial_expediente
- convenios
- amparos
- notificaciones
- agenda_diaria
- audit_logs
- configuracion
- jobs (cola/scheduler)

## 3) Seed inicial

Archivo: `database/seeds/001_seed_initial.sql`

Incluye:
- 1 administrador (`admin@demo.com` / `Password123!`)
- 3 usuarios adicionales
- 5 clientes
- 10 expedientes
- estados verde / amarillo / rojo / gris

## 4) Código backend

- MVC ligero PSR-4
- Router propio (`app/services/Router.php`)
- Controladores para login, dashboard, clientes, usuarios, expedientes y reportes
- RBAC por roles obligatorios: ADMINISTRADOR, CAPTURISTA, CONSULTOR
- CSRF, sesiones seguras, bcrypt y escape de salida
- Servicios de notificación email/WhatsApp y exportación (Excel, Word, PowerPoint)

## 5) Código frontend

- Bootstrap 5 + CSS custom estilo Office moderno
- Sidebar izquierda, barra superior, tablas y formularios
- Menú solicitado exactamente con secciones Inicio / Clientes / Expedientes o Casos / Usuarios / Salir
- Responsive

## 6) docker-compose

Archivo raíz: `docker-compose.yml`

Servicios:
- `app` (PHP 8.2 + Apache)
- `mysql` (MySQL 8)
- `phpmyadmin`
- `redis`

## 7) .env.example

Variables incluidas:
- DB_HOST, DB_NAME, DB_USER, DB_PASS
- SMTP_HOST, SMTP_USER, SMTP_PASS
- WHATSAPP_TOKEN, WHATSAPP_PHONE_ID
- APP_URL

Y adicionales operativas: DB_PORT, SMTP_PORT, REDIS_HOST, REDIS_PORT, TWILIO_*

## 8) Instalación en XAMPP

1. Copiar carpeta a: `C:\xampp\htdocs\ExpedientesApp`
2. En la raíz del proyecto:
   ```bash
   copy .env.example .env
   composer install
   ```
3. Crear BD `expedientes_app` en MySQL.
4. Importar:
   - `database/migrations/001_create_tables.sql`
   - `database/seeds/001_seed_initial.sql`
5. Abrir en navegador:
   - `http://localhost/ExpedientesApp/public`
6. Acceso demo:
   - Usuario: `admin@demo.com`
   - Password: `Password123!`

### Solución al error `404 - Recurso no encontrado` en XAMPP

- Causa: acceso con subdirectorio (`/ExpedientesApp/public`) y rutas absolutas (`/login`, `/clientes`, etc.).
- Solución implementada: el front controller ahora detecta automáticamente el `base path` y normaliza rutas/redirects para funcionar tanto en raíz (`http://localhost:8080`) como en subcarpeta (`http://localhost/ExpedientesApp/public`).

## 9) Instalación en Docker

1. En la raíz del proyecto:
   ```bash
   cp .env.example .env
   docker compose up -d --build
   ```
2. Instalar dependencias dentro del contenedor:
   ```bash
   docker compose exec app composer install
   ```
3. Cargar migraciones y seed (phpMyAdmin o mysql CLI):
   - `database/migrations/001_create_tables.sql`
   - `database/seeds/001_seed_initial.sql`
4. URLs:
   - App: `http://localhost:8080`
   - phpMyAdmin: `http://localhost:8081`

### Solución al problema `use Dotenv\\Dotenv` sin carpeta Dotenv

- `Dotenv` no es carpeta del proyecto, es clase del paquete Composer `vlucas/phpdotenv` dentro de `vendor/`.
- El arranque ahora valida `vendor/autoload.php` y muestra mensaje claro si faltan dependencias.
- Ejecutar siempre:
  ```bash
  composer install
  ```

## Scheduler / Notificaciones

- `php scripts/scheduler.php` → alertas email/WhatsApp por semáforo
- `php scripts/notifications.php` → agenda diaria por abogado

Programar cron sugerido:
```cron
0 7 * * * php /ruta/ExpedientesApp/scripts/notifications.php
0 8 * * * php /ruta/ExpedientesApp/scripts/scheduler.php
```

## Supuestos técnicos documentados

1. IDs de rol fijos: 1=ADMINISTRADOR, 2=CAPTURISTA, 3=CONSULTOR.
2. Primera versión con soft multiempresa por columna `empresa_id` en tablas transaccionales.
3. Semaforización se recalcula al alta de expediente y puede ejecutarse en lotes vía scheduler.
4. Integración WhatsApp configurable entre Twilio y Cloud API por `WHATSAPP_PROVIDER`.
5. Redis se deja listo para colas; esta versión ejecuta jobs en tabla `jobs` y scripts cron.
