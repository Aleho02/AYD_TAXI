# AYD TAXII 🚖

**Sistema de Información Geoespacial Distribuido** diseñado para optimizar, solicitar y gestionar el servicio de transporte público individual de taxis en tiempo real en la provincia del **Valle de Ubaté, Cundinamarca**.

---

## 📌 Descripción del Proyecto

AYD TAXII conecta de forma transparente y eficiente a pasajeros y taxistas, reemplazando los métodos tradicionales de despacho (frecuencias de radio y llamadas telefónicas) por un canal digital con **geolocalización continua**, **estimación previa de tarifas** y **trazabilidad completa de las carreras**.

### 👥 Roles del Sistema

1. **Pasajero (Usuario cliente):**
   * Solicita servicios de taxi en tiempo real con captura GPS.
   * Consulta la estimación previa de la tarifa calculada según la distancia al destino.
   * Visualiza información de seguridad del conductor (foto, nombre, teléfono y placa del vehículo).

2. **Conductor:**
   * Recibe, acepta y gestiona solicitudes de carreras asignadas.
   * Transmite su posición geográfica en tiempo real mediante telemetría GPS.
   * Consulta el desglose del valor estimado del servicio.

3. **Administrador / Operador (Panel Web CMS):**
   * Control centralizado de la flota automotora y conductores autorizados.
   * Carga, validación y gestión de documentos y fotografías de conductores (JPG, PNG, WEBP).
   * Monitoreo transaccional de viajes y analítica de movilidad en el Valle de Ubaté.

---

## 🛠️ Tecnologías Utilizadas

* **Backend & API:** Laravel 11 (PHP 8.2) + Laravel Sanctum (Tokens Bearer)
* **Base de Datos:** MySQL / MariaDB (XAMPP)
* **Frontend CMS:** Blade Engine, Vanilla CSS responsivo, micro-animaciones y Google Fonts (Outfit & Inter)
* **Pruebas y Auditoría:** Postman, Composer Audit, NPM Audit, Artisan CLI

---

## 🚀 Instalación y Puesta en Marcha

### 1. Clonar el repositorio

```bash
git clone https://github.com/layton777/AYD.git
cd AYD
```

### 2. Instalar dependencias

```bash
composer install
npm install
```

### 3. Configurar variables de entorno (`.env`)

Copia el archivo de ejemplo:
```bash
cp .env.example .env
php artisan key:generate
```

Asegúrate de configurar la conexión a **MySQL (XAMPP)** en tu `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ayd_taxi
DB_USERNAME=root
DB_PASSWORD=
DB_COLLATION=utf8mb4_unicode_ci
```

Crea el enlace simbólico para las imágenes de almacenamiento:
```bash
php artisan storage:link
```

### 4. Migrar y sembrar la base de datos

```bash
php artisan migrate:fresh --seed
```

### 5. Iniciar los servidores

```bash
# Terminal 1: Servidor Web / API de Laravel
php artisan serve

# Terminal 2: Vite para assets
npm run dev
```

El aplicativo estará disponible en: **`http://127.0.0.1:8000`**

---

## 🔑 Usuarios de Prueba Sembrados

| Rol | Correo Electrónico | Contraseña | Detalles |
| :--- | :--- | :--- | :--- |
| **Administrador** | `admin@aydtaxi.com` | `password123` | Acceso completo al Panel CMS |
| **Conductor** | `conductor@aydtaxi.com` | `password123` | Taxi Hyundai Accent `UBT345`, Lic: `LIC-UBATE-9988` |
| **Pasajero** | `pasajero@aydtaxi.com` | `password123` | Cliente en Ubaté con historial de carreras |

---

## 🌐 Endpoints Principales de la API (Sanctum)

URL Base: `http://127.0.0.1:8000/api`

| Método | Endpoint | Cabeceras | Descripción |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/register` | `Accept: application/json` | Registro de nuevo usuario (Pasajero / Conductor) |
| `POST` | `/api/login` | `Accept: application/json` | Inicio de sesión y emisión de Bearer Token |
| `GET` | `/api/profile` | `Authorization: Bearer <TOKEN>` | Perfil del usuario autenticado |
| `POST` | `/api/logout` | `Authorization: Bearer <TOKEN>` | Revocación de token y cierre de sesión |
| `GET` | `/api/trips` | `Authorization: Bearer <TOKEN>` | Listado de viajes según rol |
| `POST` | `/api/trips` | `Authorization: Bearer <TOKEN>` | Pasajero solicita viaje con cálculo tarifario GPS |
| `GET` | `/api/trips/{id}` | `Authorization: Bearer <TOKEN>` | Detalle de viaje con **control estricto de autorización (403 si es ajeno)** |
| `PATCH` | `/api/trips/{id}/accept` | `Authorization: Bearer <TOKEN>` | Conductor acepta carrera asignada |
| `POST` | `/api/driver/location` | `Authorization: Bearer <TOKEN>` | Transmisión de telemetría GPS del conductor |
| `GET` | `/api/drivers/available`| `Authorization: Bearer <TOKEN>` | Lista de taxis disponibles en el Valle de Ubaté |

---

## 🛡️ Matriz de Auditoría y Pruebas Técnicas

* **Control de Acceso (403):** Las rutas de flota, conductores y usuarios están restringidas exclusivamente al rol `admin` mediante el middleware `CheckRole`. Pasajeros o conductores que intenten ingresar reciben HTTP 403.
* **Protección CSRF:** Todos los formularios web CMS contienen `@csrf`. Peticiones alteradas sin token generan error HTTP 419.
* **Validación de Archivos:** Las fotos de perfil de conductores se validan estrictamente (`image`, `mimes:jpeg,jpg,png,webp`, `max:2048`). Archivos `.pdf`, `.php` o sobredimensionados son rechazados.
* **Seguridad de Datos:** El archivo `.env` se encuentra ignorado por Git (`.gitignore`) para proteger credenciales y llaves criptográficas.
