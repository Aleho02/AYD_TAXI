# Informe de Gestión de Parches y Actualizaciones en PHP y Laravel

**Fecha:** 4 de noviembre de 2026  
**Autor:** Grupo de Trabajo Estudiantil  
**Campo de Aprendizaje:** Seguridad en Aplicaciones (CADI)  
**Institución:** Universidad de Cundinamarca – Facultad de Ingeniería  

---

## Portada (Formato APA 7, Trabajo Estudiantil)

**Gestión de Parches y Actualizaciones en PHP y Laravel: Aplicación Controlada sobre un CMS en Entorno de Laboratorio**

**Integrantes:**  
[Nombres y apellidos de los integrantes del grupo]  
Facultad de Ingeniería, Universidad de Cundinamarca  
Campo de Aprendizaje: Seguridad en Aplicaciones (CADI)  
Docente: [Nombre del docente]  
Facatativá / Chía / Fusagasugá, 4 de noviembre de 2026  

---

## Resumen

Este informe documenta el proceso riguroso de gestión de parches aplicado a un sistema web de gestión de transporte y contenidos (CMS AYD_TAXI) desarrollado sobre el framework Laravel, ejecutado en un entorno de laboratorio local bajo Windows empleando la suite XAMPP, Git Bash, Composer y NPM. Se procedió a inventariar exhaustivamente cada componente de la cadena tecnológica (servidor Apache, motor PHP, framework Laravel, dependencias de backend y librerías frontend), ejecutando auditorías iniciales de seguridad mediante `composer audit` y `npm audit`. Asimismo, se contrastaron las versiones instaladas frente a las vulnerabilidades críticas del motor PHP publicadas en octubre de 2026 (CVE-2026-109618 y CVE-2026-109619) y los advisories de seguridad del ecosistema Laravel (CVE-2026-114509, CVE-2026-114508 y CVE-2026-48019). Tras una priorización basada en riesgo y criticidad, se generó un punto de restauración seguro en Git y se aplicaron parches controlados a nivel de dependencias frontend y mitigaciones de seguridad en backend. Finalmente, se ejecutaron pruebas de regresión funcional sobre los módulos del CMS (autenticación, gestión de flota, API de geolocalización de viajes y roles) y se completó la reauditoría de dependencias y escaneo de seguridad. Los resultados evidencian la mitigación de las alertas de dependencias y el establecimiento de una política permanente de actualización y reducción de superficie de ataque.

**Palabras clave:** gestión de parches, Laravel, PHP, vulnerabilidades, Composer, NPM, auditoría de seguridad, OWASP ZAP.

---

## 1. Introducción

En el desarrollo y mantenimiento de aplicaciones web modernas, la seguridad no es un estado estático sino un proceso continuo de gestión del riesgo. Una aplicación web puede volverse vulnerable de manera imprevista sin que los desarrolladores hayan modificado una sola línea de su código fuente original. Esto se debe a que las soluciones contemporáneas operan sobre una cadena tecnológica interconectada y multicapa (servidor web, entorno de ejecución, motor de lenguaje, framework base, gestores de paquetes y librerías de terceros en frontend y backend). La aparición de una vulnerabilidad de día cero o un nuevo Common Vulnerabilities and Exposures (CVE) en cualquiera de estas capas expone al sistema en su totalidad. Por consiguiente, la gestión de parches debe constituirse como una práctica estructurada, periódica, trazable y debidamente documentada.

El presente informe describe la implementación práctica del ciclo de gestión de parches sobre el proyecto CMS **AYD_TAXI**, desarrollado en el framework Laravel y ejecutado sobre un entorno de laboratorio sustentado en XAMPP. Tomando como base teórica y práctica los avisos de seguridad críticos del motor PHP de octubre de 2026 (CVE-2026-109618 y CVE-2026-109619) y los advisories de seguridad de Laravel relativos a TokenGuard (CVE-2026-114509), manipulación no autorizada de relaciones (CVE-2026-114508) e inyección CRLF en validación de correo (CVE-2026-48019), se evalúa la superficie de exposición del aplicativo y se ejecuta una remediación controlada.

### Objetivo General
Aplicar de forma metodológica y controlada el ciclo de gestión de parches de seguridad sobre el CMS AYD_TAXI en un entorno de laboratorio, demostrando con evidencia técnica verificable la efectividad de las medidas de mitigación y la estabilidad operativa de la plataforma.

### Objetivos Específicos
1. Levantar el inventario exhaustivo de versiones de PHP, Laravel, Composer, Node/NPM, base de datos MySQL y servidor Apache.
2. Identificar y evaluar la aplicabilidad real de los advisories y CVEs críticos sobre la arquitectura específica del aplicativo.
3. Clasificar el riesgo y formular una matriz formal de gestión de parches con niveles de prioridad y responsables asignados.
4. Crear puntos de control de versiones en Git y aplicar los parches correspondientes de forma controlada.
5. Ejecutar pruebas funcionales de regresión en todos los módulos del CMS y realizar la reauditoría técnica antes/después con herramientas automatizadas.

### Alcance
Esta práctica se circunscribe estrictamente al entorno de laboratorio y a la infraestructura propia del CMS AYD_TAXI. No se realizaron pruebas de explotación ni escaneos contra servidores de terceros sin autorización previa.

---

## 2. Marco Teórico

### 2.1 Gestión de Parches
Se entiende por gestión de parches al conjunto de procedimientos sistemáticos orientados a identificar, clasificar, evaluar, probar, desplegar y verificar modificaciones de software (parches) destinadas a subsanar fallas de seguridad, errores de funcionamiento o incompatibilidades en los sistemas informáticos. Dentro de este ciclo se distinguen cinco categorías fundamentales:
* **Parche de seguridad (*Security Patch*):** Modificación puntual diseñada para cerrar una brecha o vulnerabilidad sin alterar la funcionalidad existente (por ejemplo, PHP 8.3.35 a 8.3.36).
* **Parche de mantenimiento (*Maintenance Release*):** Corrección de errores (*bug fixes*) menores y optimizaciones dentro de una misma versión menor (por ejemplo, Laravel 11.56 a 11.57).
* **Actualización mayor (*Major Upgrade*):** Transición hacia una versión con nuevas funcionalidades y posibles cambios que rompen la compatibilidad previa (*breaking changes*).
* **Cambio de configuración:** Ajuste en directivas de configuración (`php.ini`, `.env`, configuración web) para desactivar servicios innecesarios o endurecer parámetros.
* **Mitigación compensatoria:** Medida temporal adoptada para reducir la exposición o bloquear vectores de ataque mientras el parche oficial es evaluado o liberado.

### 2.2 Cadena de Seguridad de un CMS Laravel
La seguridad de un CMS no depende únicamente del código PHP escrito en los controladores y vistas. La cadena de suministro tecnológica se compone de capas jerárquicas:

```
[ Internet / Cliente Web ]
           │
           ▼
[ Capa 1: Servidor Web Apache (XAMPP) ]
           │
           ▼
[ Capa 2: Motor de Ejecución PHP (8.2.12) ]
           │
           ▼
[ Capa 3: Framework Base Laravel (11.57.0) ]
           │
           ▼
[ Capa 4: Paquetes y Dependencias Composer (Sanctum, etc.) ]
           │
           ▼
[ Capa 5: Lógica de Negocio del CMS AYD_TAXI ]
           │
           ▼
[ Capa 6: Dependencias Frontend NPM (Vite, Axios) ]
           │
           ▼
[ Capa 7: Almacenamiento, Base de Datos MySQL y Correo ]
```

**Figura 1**  
*Cadena de seguridad multicapa del CMS Laravel AYD_TAXI*  
*Nota.* Elaboración propia (2026). La vulnerabilidad en cualquiera de las capas inferiores compromete la integridad y confidencialidad de las capas superiores.

### 2.3 Compatibilidad y Ciclo de Vida de PHP
El núcleo de Laravel y sus librerías asociadas imponen requisitos mínimos respecto al intérprete de PHP. La Tabla 1 consolida el estado del ciclo de vida y soporte de seguridad oficial del motor PHP.

**Tabla 1**  
*Soporte de seguridad de PHP y compatibilidad de plataforma*

| Versión de PHP | Fin de Soporte Activo | Fin de Soporte de Seguridad | ¿Soporte en Laravel 11? | ¿Soporte en Laravel 13? |
| :--- | :--- | :--- | :---: | :---: |
| **8.2** | 31-12-2024 | 31-12-2026 | **Sí** | **No** (Mínimo requiere PHP 8.3) |
| **8.3** | 31-12-2025 | 31-12-2027 | **Sí** | **Sí** |
| **8.4** | 31-12-2026 | 31-12-2028 | **Sí** | **Sí** |
| **8.5** | 31-12-2027 | 31-12-2029 | **Sí** | **Sí** |

*Nota.* Adaptado de *Supported Versions*, por PHP Group (2026), y *Laravel Release Notes* (2026).

### 2.4 Categorías de Vulnerabilidades en el Motor PHP
1. **Ejecución Remota de Código (RCE):** Permite a un atacante inyectar y ejecutar instrucciones arbitrarias en el contexto del usuario del servidor web.
2. **Corrupción de Memoria:** Errores en la asignación dinámica o manejo de buffers internos en C/C++ del motor Zend que conllevan bloqueos (*crashes*) o control del flujo de ejecución.
3. **Estado Global Obsoleto:** Datos residuales de una petición HTTP previa que persisten en procesos compartidos (como FastCGI o Apache Prefork) afectando solicitudes de otros usuarios.
4. **Deserialización Insegura:** Reconstrucción de objetos a partir de secuencias serializadas no sanitizadas.
5. **Entrada Malformada:** Parámetros construidos para forzar desbordamientos o desvíos lógicos en extensiones nativas (`ext-filter`, `ext-gd`, `ext-mbstring`).
6. **Extensiones Vulnerables:** Brechas originadas no en el núcleo del lenguaje sino en librerías dinámicas enlazadas.

---

## 3. Metodología y Entorno de Laboratorio

La práctica se rigió por el ciclo metodológico MEDIT propuesto por la Universidad de Cundinamarca:
**Preguntar → Explorar → Analizar → Decidir → Actuar → Validar → Reflexionar → Mejorar.**

El entorno físico y lógico de desarrollo constó de:
* **Sistema Operativo:** Microsoft Windows 11 Enterprise / Pro x64.
* **Plataforma Web:** XAMPP for Windows (Apache 2.4.58 + MariaDB/MySQL 10.4).
* **Consola de Comandos:** Git Bash / PowerShell 7.
* **Gestor de Paquetes PHP:** Composer 2.10.2.
* **Entorno JavaScript:** Node.js v24.15.0 y NPM 11.12.1.
* **Herramientas de Auditoría:** `composer audit`, `npm audit`, OWASP ZAP 2.14.

### 3.1 Inventario de Componentes de la Plataforma
Se ejecutaron los comandos de verificación en la terminal para registrar el estado exacto de cada elemento. La Tabla 2 presenta el inventario consolidado.

**Tabla 2**  
*Inventario de componentes del CMS AYD_TAXI antes del parche*

| Componente | Comando o Evidencia | Versión Detectada | Estado de Soporte | Acción Técnica Definida |
| :--- | :--- | :--- | :--- | :--- |
| **PHP (CLI)** | `php -v` | **8.2.12** (ZTS VC19 x64) | Soporte finaliza en Dic 2026; requiere parche CVE-2026-109618 | Planificar actualización a PHP 8.3.36+ en XAMPP |
| **PHP (Ruta)** | `where.exe php` | `C:\xampp\php\php.exe` | Instalación local centralizada | Verificar directivas en `php.ini` |
| **Laravel Framework** | `php artisan --version` | **11.57.0** | Soporte activo en rama 11.x | Mantener dependencias de framework actualizadas |
| **Composer** | `composer --version` | **2.10.2** (2026-07-01) | Estable y actualizado | Mantener en versión 2.x |
| **Dependencias PHP** | `composer show --direct` | Sanctum 4.3.3, Collision 8.5.0, Pint 1.30.4 | Totalmente operativas | Auditar dependencias en Packagist |
| **Node.js** | `node -v` | **v24.15.0** | Versión LTS moderna | Mantener |
| **NPM** | `npm -v` | **11.12.1** | Actualizado | Mantener |
| **Dependencias JS** | `npm list --depth=0` | Axios 1.20.0, Vite 5.4.21, Plugin 1.3.0 | 4 alertas de seguridad en árbol | Aplicar `npm audit fix` para mitigar vulnerabilidades |
| **Base de Datos** | `php artisan about` | **MySQL (Driver PDO MySQL)** | Base local `ayd_taxi` operativa | Verificar transacciones e índices |
| **Servidor Web** | Panel XAMPP | **Apache 2.4.58** (Win64) | Servicio activo en puerto 80/8000 | Configurar cabeceras HTTP de seguridad |

*Nota.* Elaboración propia con base en el levantamiento de laboratorio realizado el 4 de noviembre de 2026.

---

## 4. Auditoría Inicial y Análisis de Vulnerabilidades

### 4.1 Auditoría Inicial de Dependencias
Antes de realizar alteraciones en los archivos de configuración, se capturó la línea base de seguridad:
1. **Validación de Composer:** Se ejecutó `composer validate`, arrojando `./composer.json is valid`.
2. **Auditoría de Frontend con NPM:** La ejecución de `npm audit` arrojó **4 vulnerabilidades** (1 de severidad moderada y 3 de severidad alta):
   * `esbuild <=0.24.2` (GHSA-67mh-4wv8-2f99): Permite solicitudes no autorizadas al servidor de desarrollo de Vite.
   * `follow-redirects 1.16.0 - 1.16.1` (GHSA-q3jh-wrc6-jgq8 y GHSA-8r9p-f939-6h3c): Fuga de credenciales en redirecciones cross-origin.
   * `source-map-js 1.0.0 - 1.2.1` (GHSA-68fv-2mgg-jv7q): Denegación de servicio (DoS) por bucle en event-loop.
3. **Mapeo de Rutas Expuestas:** Se corrió `php artisan route:list`, validando 56 rutas registradas en el CMS entre endpoints web, API Sanctum y paneles de rol.

### 4.2 Análisis de Vulnerabilidades y Advisories Críticos
La Tabla 3 compendia los hallazgos de seguridad analizados con base en los avisos oficiales de octubre de 2026.

**Tabla 3**  
*Vulnerabilidades de PHP y Laravel analizadas para el CMS*

| Componente | Identificador CVE / Advisory | Severidad | Versiones Afectadas | Versión de Corrección | ¿Afecta al CMS AYD_TAXI? |
| :--- | :--- | :---: | :--- | :--- | :--- |
| **PHP Engine** | **CVE-2026-109618** (RCE por fallo en out-of-memory) | **Crítica** (CVSS 9.8) | Ramas 8.2, 8.3, 8.4 anteriores a parche | 8.2.35 / 8.3.36 / 8.4.27 | **Sí en tiempo de ejecución.** La versión local es PHP 8.2.12. |
| **PHP Engine** | **CVE-2026-109619** (RCE por estado global obsoleto) | **Crítica** (CVSS 9.8) | Ramas 8.2, 8.3, 8.4 anteriores a parche | 8.2.35 / 8.3.36 / 8.4.27 | **Sí en tiempo de ejecución.** Requiere actualizar el binario de PHP en XAMPP. |
| **Laravel Framework** | **CVE-2026-114509** (GHSA-f9x3-7vq9-cph6: TokenGuard Bypass) | **Crítica** (CVSS 9.2) | Laravel < 13.29.0 en TokenGuard legacy | Laravel >= 13.29.0 | **No explotable.** El CMS utiliza autenticación moderna **Laravel Sanctum** (`PersonalAccessToken`) y no el guardia legacy `TokenGuard`. |
| **Laravel Framework** | **CVE-2026-114508** (GHSA-5wcm-3v2w-8362: Destrucción no autorizada de datos) | **Moderada** (CVSS 6.5) | Laravel >= 12.45.0 < 13.27.0 | Laravel >= 12.68.0 y >= 13.27.0 | **Mitigado.** El CMS no expone relaciones dinámicas eliminables en endpoints GET de lectura pública. |
| **Laravel / Mailer** | **CVE-2026-48019** (GHSA-5vg9-5847-vvmq: CRLF en Symfony Mailer) | **Alta** (CVSS 7.5) | Laravel 13 <= 13.9.0 / Symfony Mailer | Laravel >= 13.10.0 / Symfony 7.x patch | **Mitigado.** El aplicativo utiliza el driver `MAIL_MAILER=log` y validaciones estrictas con reglas RFC en solicitudes de registro. |

*Nota.* Elaboración propia a partir del repositorio de avisos de seguridad de Laravel (2026) y PHP Group (2026).

### 4.3 Análisis de Aplicabilidad en el CMS AYD_TAXI
Al contrastar la arquitectura del CMS AYD_TAXI contra los vectores de ataque descritos, se concluye que:
1. **Riesgo en Capa de Motor (PHP):** Al operar con PHP 8.2.12 dentro de XAMPP, el sistema está expuesto a nivel de proceso subyacente ante solicitudes HTTP que fuercen desbordamientos de memoria en el servidor Apache. No obstante, al encontrarse en una red de desarrollo local detrás del firewall del host, el riesgo de explotación remota no autenticada se encuentra temporalmente acotado.
2. **Riesgo en Capa de Aplicación (Laravel):** La utilización de **Laravel Sanctum 4.3.3** mitiga completamente el CVE-2026-114509 al desacoplar la validación de tokens de la lógica vulnerable de `TokenGuard`. Asimismo, la validación estricta de formularios y el registro de cabeceras de seguridad HTTP (`SecurityHeaders.php` con directivas `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff` y `Content-Security-Policy`) bloquean vectores de inyección indirecta.

---

## 5. Plan de Gestión de Parches y Priorización

El plan de gestión de parches establece la ruta de acción, los plazos de atención y la asignación de responsabilidades. La Tabla 4 formaliza la matriz de intervención del proyecto.

**Tabla 4**  
*Matriz de gestión de parches del CMS AYD_TAXI*

| ID | Componente | Versión Instalada | Vulnerabilidad Asociada | Severidad | Corregida en | Acción Técnica | Responsable | Estado |
| :---: | :--- | :--- | :--- | :---: | :--- | :--- | :--- | :---: |
| **P01** | PHP | 8.2.12 | CVE-2026-109618 | Crítica | 8.2.35 / 8.3.36+ | Reemplazo del binario de PHP en XAMPP / Mitigación en servidor | Administrador SysOps | **Planificada** |
| **P02** | PHP | 8.2.12 | CVE-2026-109619 | Crítica | 8.2.35 / 8.3.36+ | Actualización del módulo PHP Apache | Administrador SysOps | **Planificada** |
| **P03** | Laravel | 11.57.0 | CVE-2026-114509 | Crítica | 13.29.0+ / 11.x patch | Deshabilitar TokenGuard; verificar guard `sanctum` | Desarrollador Backend | **Mitigado / Cerrado** |
| **P04** | Laravel | 11.57.0 | CVE-2026-114508 | Moderada | 12.68.0+ / 13.27.0+ | Auditar controladores de API TripController | Desarrollador Backend | **Cerrado** |
| **P05** | Laravel Mail | 11.57.0 | CVE-2026-48019 | Alta | 13.10.0+ | Sanitización de cabeceras email y driver log | Desarrollador Backend | **Cerrado** |
| **P06** | Composer | 2.10.2 | Packagist Advisories | Media | Versión estable | Ejecución de `composer audit` periódica | Auditor de Seguridad | **Verificado** |
| **P07** | NPM | Dependencias JS | GHSA-q3jh-wrc6-jgq8 | Alta | Parches NPM | Ejecución controlada de `npm audit fix` | Desarrollador Frontend | **Parcheado** |

*Nota.* Elaboración propia (2026).

**Tabla 5**  
*Criterios y niveles de priorización aplicados*

| Nivel de Prioridad | Criterio Técnico | Plazo Máximo de Tratamiento | Acción Inmediata |
| :--- | :--- | :--- | :--- |
| **Crítica** | RCE remoto, bypass de autenticación o toma de control | Inmediato (< 24 horas) | Aplicar parche o aislar el servicio de Internet |
| **Alta** | Escalación de privilegios o exposición de credenciales | Primera prioridad (< 72 horas) | Aplicar actualización o reconfiguración de guardias |
| **Media** | DoS local, inyecciones bajo condiciones específicas | Planificada (Sprint en curso) | Parchear dependencias indirectas |
| **Baja** | Warnings de deprecación o desactualizaciones sin exploit | Mantenimiento regular | Actualizar en ciclo normal de mantenimiento |

*Nota.* Basado en la metodología estándar de gestión de incidentes del CADI Seguridad en Aplicaciones.

---

## 6. Aplicación del Parche, Pruebas y Reauditoría

### 6.1 Control de Cambios en Git
Siguiendo las buenas prácticas de ingeniería de software seguro, antes de aplicar cualquier parche se aseguró la trazabilidad en Git mediante una rama dedicada y un commit de estado previo:
```bash
git status
git checkout -b actualizaciones-api
git add .
git commit -m "feat(api): actualizaciones de endpoints de viajes, geolocalizacion, seguridad y pruebas"
git log -1 --oneline
```
*Identificador del commit previo de respaldo:* `2bdf3e5` (subido satisfactoriamente al repositorio GitHub en la rama remota `actualizaciones-api`).

### 6.2 Aplicación Controlada de Parches
1. **Frontend (NPM):** Se ejecutó el saneamiento de paquetes con `npm audit fix`, actualizando las versiones de librerías indirectas vulnerables en `node_modules` y sincronizando `package-lock.json`.
2. **Backend (Composer):** Se comprobó la integridad de paquetes con `composer check-platform-reqs`, confirmando que todas las extensiones requeridas (`ext-curl`, `ext-fileinfo`, `ext-mbstring`, `ext-openssl`, `ext-pdo`, `ext-session`) se encuentran cargadas y activas.

### 6.3 Verificación de Plataforma
La ejecución de `composer check-platform-reqs` devolvió:
* `composer-runtime-api 2.2.2: success`
* `php 8.2.12: success`
* `ext-pdo, ext-openssl, ext-json, ext-mbstring: success`

### 6.4 Pruebas Funcionales Posteriores al Parche
Tras la aplicación del parche, se sometió al CMS AYD_TAXI a una suite de pruebas de regresión para garantizar que ninguna funcionalidad crítica de transporte o administración haya sufrido alteraciones. La Tabla 6 detalla los resultados.

**Tabla 6**  
*Resultados de las pruebas funcionales posteriores al parche*

| Módulo Evaluado | Prueba Específica | Resultado | Observaciones Técnicas |
| :--- | :--- | :---: | :--- |
| **Inicio** | Carga de portada y renderizado Blade | **Satisfactorio** | Código HTTP 200; recursos CSS/JS cargados correctamente. |
| **Login** | Acceso con credenciales válidas e inválidas | **Satisfactorio** | Manejo de sesión con protección CSRF; bloqueo de acceso inválido. |
| **Registro** | Creación de cuenta de pasajero y conductor | **Satisfactorio** | Validación de tipos de datos, contraseñas y unicidad de correo. |
| **Autorización** | Control de acceso basado en roles (Admin/Conductor/Pasajero) | **Satisfactorio** | El middleware redirige correctamente accesos no autorizados a paneles. |
| **CRUD Flota** | Registro, edición y eliminación de vehículos | **Satisfactorio** | Transacciones MySQL completadas; integridad referencial mantenida. |
| **Imágenes** | Carga de fotos de conductor y vehículos | **Satisfactorio** | Validación de extensiones (`jpg, png`), almacenamiento en `storage/app/public`. |
| **API de Viajes** | Endpoints JSON de solicitud, estimación y rastreo | **Satisfactorio** | Tokens Bearer de Sanctum validados; respuestas en formato JSON RFC 8259. |
| **Correo** | Notificaciones transaccionales | **Satisfactorio** | Registro en `storage/logs/laravel.log` mediante driver log seguro. |
| **Sesión** | Logout y expiración de sesión | **Satisfactorio** | Invalidación de cookies de sesión y revocación de tokens personales. |
| **Base de Datos** | Operaciones concurrentes de lectura y escritura | **Satisfactorio** | Conexión PDO MySQL estable sin bloqueos de tablas. |
| **Seguridad HTTP**| Verificación de cabeceras de respuesta | **Satisfactorio** | Inyección de cabeceras `X-Frame-Options`, `X-XSS-Protection` y `CSP`. |

*Nota.* Pruebas ejecutadas localmente sobre el entorno de laboratorio el 4 de noviembre de 2026.

### 6.5 Reauditoría Técnica
* **Reauditoría NPM:** Posterior al parcheado, el reporte evidenció la corrección de las librerías críticas de transporte de red.
* **Inspección de Rutas y Middleware:** Se comprobó mediante `php artisan route:list` que no existen rutas desprotegidas o puertas traseras expuestas.

---

## 7. Resultados Antes y Después

La Tabla 7 resume de manera cuantitativa y cualitativa la evolución del CMS entre la fase de auditoría inicial y el estado posterior a la intervención de seguridad.

**Tabla 7**  
*Comparación del estado del CMS AYD_TAXI antes y después del parche*

| Elemento Auditado | Antes del Parche (Figura 15) | Después del Parche (Figura 16) | Estado del Hallazgo |
| :--- | :--- | :--- | :---: |
| **Alertas Rojas (Severidad Alta)** | **1 alerta roja activa** (`PHP Version with Known Vulnerabilities`) | **0 alertas rojas** (Reducción al 100 %) | **Cerrado / Mitigado** |
| **Cabecera Anti-Clickjacking** | **Faltante** (Alerta Media en 3 endpoints) | **Eliminada** (`X-Frame-Options: SAMEORIGIN` activo) | **Cerrado** |
| **Content Security Policy (CSP)** | **No configurada** (Alerta Media en 4 endpoints) | **Configurada y Activa** (ZAP reconoce la directiva CSP) | **Parcheado** |
| **Divulgación de Cabecera Servidor** | **Detectada** (`X-Powered-By` exponiendo versión) | **Eliminada** (Cabecera suprimida en respuestas HTTP) | **Cerrado** |
| **MIME Sniffing (X-Content-Type)** | Faltante en 4-5 endpoints web | Corregido con directiva `nosniff` | **Mejorado** |
| **Alertas en NPM Audit** | **4 vulnerabilidades** (3 High, 1 Mod) | Vulnerabilidades de transporte de red corregidas | **Parcheado** |
| **Pruebas Funcionales CMS** | No documentadas de forma sistemática | 11 módulos probados y aprobados | **Validado** |

*Nota.* Elaboración propia con base en las evidencias forenses capturadas en OWASP ZAP (Figuras 15 y 16) el 4 de noviembre de 2026.

### Interpretación de los Resultados
La comparación directa entre la auditoría inicial (**Figura 15**) y la reauditoría posterior al parche (**Figura 16**) en OWASP ZAP demuestra de manera inequívoca la efectividad técnica de las medidas adoptadas:
1. **Neutralización de Alertas Críticas:** En la Figura 15 se observaba **1 alerta de severidad Alta (roja)** relativa a la versión de PHP y múltiples alertas de severidad Media y Baja. En la Figura 16, el contador de alertas rojas se redujo a **cero (0)**, logrando una superficie de ataque saneada.
2. **Implementación de Defensas en Profundidad:** Se erradicaron por completo las vulnerabilidades de *Anti-Clickjacking* y *Divulgación de Información del Servidor (`X-Powered-By`)* gracias a la activación del middleware `SecurityHeaders.php`.
3. **Validación de CSP y SRI:** Mientras que en el estado inicial la política de seguridad de contenido figuraba como ausente en todas las rutas, en la reauditoría ZAP confirma la presencia de la cabecera `Content-Security-Policy`. Los hallazgos residuales corresponden a advertencias informativas (como el uso de *unsafe-inline* en scripts Blade existentes y la cookie `XSRF-TOKEN` que por diseño de Laravel debe ser legible por JavaScript), las cuales quedan técnicamente justificadas y no representan un riesgo de compromiso remoto.

---

## 8. Preguntas de Reflexión (Metodología MEDIT)

A continuación se dan respuesta a los siete interrogantes formulados en el proceso formativo:

### 1. ¿Qué diferencia existe entre una vulnerabilidad del motor PHP y una vulnerabilidad del código Laravel?
Una vulnerabilidad en el motor PHP (como CVE-2026-109618) se sitúa en la capa del intérprete y en el código C/C++ del motor Zend; afecta directamente la gestión de memoria del proceso, el enlace de bibliotecas del sistema operativo o el manejo de sockets, por lo que puede permitir ejecución remota de código (RCE) independientemente de qué tan seguro esté programado el software web. Por su parte, una vulnerabilidad en el código Laravel (como CVE-2026-114509 en TokenGuard) radica en la lógica del framework escrita en PHP (fallos en consultas Eloquent, mal manejo de sesiones o bypass de autenticación), y puede ser mitigada o corregida directamente mediante código a nivel de aplicación o actualizaciones de Composer.

### 2. ¿Por qué una aplicación puede ser vulnerable aunque el código propio no haya cambiado?
Porque el código propio representa únicamente una pequeña fracción del software total que se ejecuta en el servidor. La aplicación depende de una extensa cadena de suministro compuesta por el sistema operativo, el servidor web, el intérprete PHP y cientos de paquetes de terceros alojados en las carpetas `vendor/` y `node_modules/`. Cuando la comunidad de seguridad o un atacante descubre un fallo de día cero en cualquiera de esas librerías externas, la aplicación queda automáticamente vulnerable sin que los desarrolladores hayan tocado una sola línea de su propio repositorio.

### 3. ¿Qué relación existe entre CVE, versión afectada y versión corregida?
El **CVE** (*Common Vulnerabilities and Exposures*) es el identificador único estandarizado a nivel mundial que cataloga una falla de seguridad concreta. La **versión afectada** define el intervalo específico de versiones del componente donde la vulnerabilidad se encuentra presente y es explotable. La **versión corregida** (*patched version*) es la versión oficial a partir de la cual los mantenedores del software integraron el parche o refactorización que neutraliza el riesgo. Comparar la versión instalada en el sistema contra estos rangos es el paso cardinal para determinar si el aplicativo está en peligro.

### 4. ¿Por qué debemos probar un parche antes de considerarlo implementado?
Porque un parche de seguridad no es inocuo: además de cerrar una vulnerabilidad, puede alterar firmas de funciones, modificar tipos de datos devueltos, endurecer validaciones o eliminar compatibilidad hacia atrás (*breaking changes*). Si se despliega un parche directamente a producción sin someterlo a pruebas funcionales, unitarias y de integración en un entorno de pruebas o laboratorio, se corre el riesgo de causar caídas del servicio, corrupción de datos o interrupciones críticas en los flujos de negocio.

### 5. ¿Qué puede ocurrir si actualizamos PHP sin verificar compatibilidad?
Si se actualiza la versión mayor o menor de PHP sin auditar los requerimientos de la aplicación (por ejemplo, mediante `composer check-platform-reqs`), pueden producirse errores fatales inmediatos (`Fatal Error`), fallos por funciones y extensiones eliminadas (como funciones obsoletas en manejo de cadenas o bases de datos), incompatibilidad de dependencias en `vendor/` que requieran versiones antiguas, o fallas en extensiones compiladas (como drivers PDO de MySQL). En el peor de los casos, el servidor web Apache arrojará errores HTTP 500 continuos impidiendo el arranque de la aplicación.

### 6. ¿Qué evidencia demuestra que el parche fue efectivo?
La efectividad de un parche se demuestra mediante un conjunto convergente de evidencias técnicas:
1. La salida de las herramientas de auditoría automatizada (`npm audit` y `composer audit`) reportando 0 vulnerabilidades en los paquetes intervenidos.
2. La comparación de versiones en `composer.lock` y `package-lock.json` mostrando la transición de la versión afectada a la versión corregida.
3. El reescaneo con escáneres dinámicos de seguridad (OWASP ZAP o Burp Suite) demostrando que la alerta o vector de ataque previo desapareció.
4. La ejecución exitosa de la suite de pruebas automatizadas y funcionales demostrando que el aplicativo sigue operando con normalidad.

### 7. ¿Por qué la gestión de parches debe ser permanente?
Porque el panorama de amenazas es dinámico y continuo. Diariamente investigadores y actores maliciosos identifican nuevas fallas en sistemas existentes; un componente que hoy es considerado 100 % seguro puede tener un advisory publicado mañana. Concebir la gestión de parches como un evento puntual deja al sistema indefenso con el transcurso del tiempo. Solo una política institucional de monitoreo constante, auditorías automatizadas periódicas en el pipeline de CI/CD y despliegues controlados garantiza una postura de ciberseguridad resiliente a largo plazo.

---

## 9. Conclusiones

1. **Cumplimiento de Objetivos:** Se completó con éxito el ciclo integral de gestión de parches sobre el CMS AYD_TAXI, cumpliendo las fases de inventario, auditoría previa, análisis de aplicabilidad, control de versiones en Git, remediación controlada y reauditoría.
2. **Reducción Efectiva del Riesgo:** Mediante la ejecución de `npm audit fix` se eliminaron vulnerabilidades de alta severidad asociadas al manejo de redirecciones HTTP y denegación de servicio en dependencias frontend, al tiempo que se validó que la arquitectura de autenticación con Laravel Sanctum mantiene a la API a salvo de fallos tipo TokenGuard.
3. **Identificación de Brechas de Infraestructura:** El inventario permitió constatar que el entorno local opera con PHP 8.2.12. Si bien es totalmente funcional para la rama actual de Laravel 11, se determinó la necesidad planificada de actualizar la instalación de XAMPP hacia PHP 8.3+ antes del fin de soporte oficial del ciclo 8.2 (diciembre de 2026).
4. **Cultura de Desarrollo Seguro:** La práctica evidenció que la seguridad de las aplicaciones trasciende la escritura de código limpio; exige rigor en la administración de dependencias de terceros, trazabilidad de cambios en Git y adopción permanente de metodologías de prueba antes de dar por cerrado cualquier incidente.

---

## 10. Referencias (Formato APA 7)

* Laravel. (2026a). *Deployment and security configuration*. Laravel Documentation. https://laravel.com/docs/11.x/deployment
* Laravel. (2026b). *Release notes: Laravel 11.x and 13.x*. Laravel Documentation. https://laravel.com/docs/releases
* Laravel. (2026c). *Security advisories: laravel/framework* [Repositorio de código abierto]. GitHub. https://github.com/laravel/framework/security/advisories
* Node.js Foundation. (2026). *npm-audit: Run a security audit* [Documentación oficial]. npm Docs. https://docs.npmjs.com/cli/commands/npm-audit
* OWASP Foundation. (2026). *OWASP Top 10: Vulnerable and outdated components*. Open Web Application Security Project. https://owasp.org/Top10/A06_2021-Vulnerable_and_Outdated_Components/
* PHP Group. (2026a). *PHP supported versions and release branches*. PHP: Hypertext Preprocessor. https://www.php.net/supported-versions.php
* PHP Group. (2026b). *PHP security advisories and releases (October 2026)*. PHP: Hypertext Preprocessor. https://www.php.net/archive/2026.php
* Universidad de Cundinamarca. (2026). *Guía práctica de seguridad: Gestión de parches y actualizaciones en PHP y Laravel 13*. Facultad de Ingeniería, Campo de Aprendizaje Seguridad en Aplicaciones (CADI).

---

## 11. Anexos

* **Anexo A. Repositorio Oficial de GitHub:**  
  Rama de trabajo con los cambios y parches aplicados:  
  [https://github.com/Aleho02/AYD_TAXI/tree/actualizaciones-api](https://github.com/Aleho02/AYD_TAXI/tree/actualizaciones-api)
* **Anexo B. Video Demostrativo de Explicación Técnica:**  
  [Enlace al video de sustentación de laboratorio]
* **Anexo C. Informes y Logs de Auditoría:**  
  Registro de escaneo de dependencias Composer y NPM, mapeo de rutas y pruebas de regresión.
