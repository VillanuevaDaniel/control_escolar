# 📚 Reporte del Sistema — Control Escolar PHP

> **Versión:** 1.0 · **Fecha del reporte:** 13 de marzo de 2026  
> **Tecnología:** PHP 8+, MySQL/MariaDB, PDO, Bootstrap 5, Material Symbols  
> **Entorno:** XAMPP (Apache + MySQL en puerto 3307)  
> **Base de datos:** `control_escolar`  
> **URL base:** `/ControlEscolarPHP/`

---

## Tabla de contenidos

1. [Arquitectura General](#1-arquitectura-general)
2. [Capa de Configuración](#2-capa-de-configuración)
3. [Área: Acceso al Sistema](#3-área-acceso-al-sistema)
4. [Área: Comunidad Escolar](#4-área-comunidad-escolar)
5. [Área: Académico](#5-área-académico)
6. [Área: Infraestructura](#6-área-infraestructura)
7. [Área: Administración](#7-área-administración)
8. [Área: Portal del Alumno](#8-área-portal-del-alumno)
9. [Área: Dashboard](#9-área-dashboard)
10. [Base de Datos](#10-base-de-datos)
11. [Sistema de Roles y Permisos](#11-sistema-de-roles-y-permisos)
12. [Flujo completo de una solicitud HTTP](#12-flujo-completo-de-una-solicitud-http)

---

## 1. Arquitectura General

El sistema sigue el patrón **MVC (Modelo–Vista–Controlador)** implementado de forma artesanal (sin framework externo):

```
index.php (Front Controller)
├── config/
│   ├── init.php       ← Bootstrap: constantes, helpers, zona horaria
│   ├── db.php         ← Conexión PDO singleton
│   └── auth.php       ← Sesiones, guards y control de permisos
├── includes/
│   ├── core/
│   │   └── Controller.php   ← Clase base de todos los controladores
│   ├── header.php     ← Cabecera HTML (navbar + sesión de usuario)
│   ├── sidebar.php    ← Menú lateral dinámico por rol
│   └── footer.php     ← Pie de página + créditos de tecnologías
└── modulos/
    └── {nombre}/
        ├── logica.php         ← Controlador del módulo
        ├── conexion.php       ← Modelo (acceso a BD)
        └── vista_*.html       ← Vistas HTML renderizadas por PHP
```

### Enrutamiento

El enrutamiento se basa en el parámetro GET `url`:

```
GET /ControlEscolarPHP/?url=alumnos/edit/5
                              ↓       ↓   ↓
                        Controller  Método  Params
                        AlumnosController::edit(5)
```

El [index.php](file:///c:/xampp/htdocs/ControlEscolarPHP/index.php) registra un **autoloader** con `spl_autoload_register` que mapea nombres de clase a archivos en `modulos/`:

| Clase | Archivo |
|-------|---------|
| [AlumnosController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumnos/logica.php#4-134) | [modulos/alumnos/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumnos/logica.php) |
| [Alumno](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumnos/conexion.php#4-80) | [modulos/alumnos/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumnos/conexion.php) |
| [DocentesController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/docentes/logica.php#2-129) | [modulos/docentes/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/docentes/logica.php) |
| [Docente](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/docentes/conexion.php#4-70) | [modulos/docentes/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/docentes/conexion.php) |
| [HorariosController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php#5-107) | [modulos/horarios/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php) |
| [Horario](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/conexion.php#4-95) | [modulos/horarios/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/conexion.php) |
| ... | ... |

---

## 2. Capa de Configuración

### [config/db.php](file:///c:/xampp/htdocs/ControlEscolarPHP/config/db.php) — Conexión a la base de datos

- Define las constantes `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`, `DB_CHARSET`.
- Expone la función [db_connect()](file:///c:/xampp/htdocs/ControlEscolarPHP/config/db.php#8-34) que devuelve una instancia **PDO singleton** (se reutiliza en toda la petición).
- Opciones PDO: modo excepción, fetch asociativo, sin emulación de _prepared statements_.
- En caso de error muestra un bloque HTML amigable en lugar de un stack trace.

### [config/auth.php](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php) — Control de sesiones y permisos

| Función | Propósito |
|---------|-----------|
| [require_auth()](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php#4-12) | Redirige al login si no hay sesión activa |
| [session_user()](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php#13-29) | Devuelve el array del usuario en sesión (`id`, `nombre`, [rol](file:///c:/xampp/htdocs/ControlEscolarPHP/includes/core/Controller.php#4-41), `tipo`, `foto`) |
| [puede_ver($modulo)](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php#30-46) | ACL por rol: devuelve `true` si el rol tiene permiso sobre el módulo |
| [solo_director()](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php#47-56) | Guard exclusivo para el rol [director](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php#47-56) |

**Mapa de permisos por rol:**

| Rol | Módulos visibles |
|-----|-----------------|
| [director](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php#47-56) / `admin` | Todos los módulos |
| `profesor` | [calificaciones](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumno/logica.php#49-68), `horarios`, `materias`, `grupos`, `reportes` |
| `alumno` | `mi_horario`, `mis_calificaciones` |

### [config/init.php](file:///c:/xampp/htdocs/ControlEscolarPHP/config/init.php) — Bootstrap

- Define `BASE_URL = '/ControlEscolarPHP/'`
- Zona horaria: `America/Mexico_City`
- Incluye [db.php](file:///c:/xampp/htdocs/ControlEscolarPHP/config/db.php) y [auth.php](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php)
- **Helpers globales:**
  - [e($str)](file:///c:/xampp/htdocs/ControlEscolarPHP/config/init.php#15-20) → `htmlspecialchars()` para escapar salidas HTML
  - [redirect($url, $msg, $tipo)](file:///c:/xampp/htdocs/ControlEscolarPHP/config/init.php#21-31) → Redirección con mensaje flash en sesión
  - [get_flash()](file:///c:/xampp/htdocs/ControlEscolarPHP/config/init.php#32-43) → Recupera y limpia el mensaje flash
  - [fmt_fecha($mysql_date)](file:///c:/xampp/htdocs/ControlEscolarPHP/config/init.php#44-52) → Convierte `YYYY-MM-DD` → `DD/MM/YYYY`

### [includes/core/Controller.php](file:///c:/xampp/htdocs/ControlEscolarPHP/includes/core/Controller.php) — Clase base

- [view($view, $data)](file:///c:/xampp/htdocs/ControlEscolarPHP/includes/core/Controller.php#6-34) → Localiza y renderiza `modulos/{modulo}/vista_{nombre}.html` extrayendo `$data` como variables PHP.
- [model($model)](file:///c:/xampp/htdocs/ControlEscolarPHP/includes/core/Controller.php#35-40) → Instancia una clase de modelo (cargada por el autoloader).

---

## 3. Área: Acceso al Sistema

**Módulo:** [auth](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php#4-12)  
**Archivos:** [modulos/auth/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/auth/logica.php), [modulos/auth/vista_login.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/auth/vista_login.html)

### ¿Qué hace?

Es el punto de entrada al sistema. Gestiona el **inicio y cierre de sesión**.

### Flujo de login

```
Usuario accede a / o /?url=auth
         ↓
¿Ya hay sesión activa? → Redirige a /dashboard
         ↓ (no hay sesión)
Muestra formulario de login (vista_login.html)
         ↓ (POST con usuario y contraseña)
1. Busca usuario en tabla `usuarios` por `nombre_usuario`
2. Verifica estado (activo/inactivo)
3. Valida contraseña con password_verify()
4. Detecta el tipo de usuario:
   - ¿Existe registro en `alumnos` con ese id_usuario? → rol = alumno
   - ¿Existe registro en `profesores` con ese id_usuario? → rol = docente/profesor
   - De lo contrario → rol = admin
5. Guarda en $_SESSION: id, nombre, login, rol, tipo, foto, entidad_id
6. Redirige a /dashboard
```

### Cierre de sesión

`AuthController::logout()` destruye la sesión con `session_destroy()` y redirige al login.

---

## 4. Área: Comunidad Escolar

El sidebar agrupa bajo **"Comunidad Escolar"** los módulos de gestión de personas.

### 4.1 Módulo: Alumnos

**Archivos:**  
- Controlador: [modulos/alumnos/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumnos/logica.php) → clase [AlumnosController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumnos/logica.php#4-134)  
- Modelo: [modulos/alumnos/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumnos/conexion.php) → clase [Alumno](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumnos/conexion.php#4-80)  
- Vistas: [vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/ciclos/vista_index.html), [vista_create.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_create.html), [vista_edit.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_edit.html), [vista_show.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumnos/vista_show.html)

**Tabla BD:** `alumnos`

#### ¿Qué hace?

Gestión completa del **padrón de alumnos** de la institución.

#### Operaciones (CRUD)

| Acción | Método | Ruta URL |
|--------|--------|----------|
| Listar alumnos | [index()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php#23-28) | `/alumnos` |
| Alta de alumno | [create()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#26-40) | `/alumnos/create` |
| Editar alumno | [edit($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#36-57) | `/alumnos/edit/{id}` |
| Eliminar alumno | [delete($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#58-64) | `/alumnos/delete/{id}` |

#### Campos del alumno

| Campo | Descripción |
|-------|-------------|
| `matricula` | Clave única del alumno |
| `nombre` / `apellido_paterno` / `apellido_materno` | Nombre completo |
| `curp` | CURP único (18 caracteres) |
| `genero` | M / F |
| `domicilio` | Dirección del alumno |
| `escuela_procedencia` | Escuela de origen |
| `ruta_foto` | Ruta a imagen de perfil |
| `nombre_tutor` / `telefono_tutor` | Datos del responsable |
| `comentarios` | Notas adicionales |
| `estado` | Activo (1) / Inactivo (0) |
| `id_usuario` | Vínculo con cuenta de acceso |

#### Filtros en el listado

- Búsqueda por texto (`q`) sobre nombre, apellido paterno y matrícula.
- Filtro por estado (Activo / Inactivo).

---

### 4.2 Módulo: Docentes

**Archivos:**  
- Controlador: [modulos/docentes/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/docentes/logica.php) → clase [DocentesController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/docentes/logica.php#2-129)  
- Modelo: [modulos/docentes/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/docentes/conexion.php) → clase [Docente](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/docentes/conexion.php#4-70)  
- Vistas: [vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/ciclos/vista_index.html), [vista_create.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_create.html), [vista_edit.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_edit.html), [vista_show.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumnos/vista_show.html)

**Tabla BD:** `profesores`

#### ¿Qué hace?

Gestión completa del **catálogo de docentes/profesores**.

#### Operaciones (CRUD)

| Acción | Método | Ruta URL |
|--------|--------|----------|
| Listar docentes | [index()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php#23-28) | `/docentes` |
| Alta de docente | [create()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#26-40) | `/docentes/create` |
| Editar docente | [edit($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#36-57) | `/docentes/edit/{id}` |
| Eliminar docente | [delete($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#58-64) | `/docentes/delete/{id}` |

#### Campos del docente

| Campo | Descripción |
|-------|-------------|
| `numero_empleado` | Clave única del empleado |
| `nombre_completo` | Nombre completo concatenado |
| `curp` | CURP único |
| `telefono` | Teléfono de contacto |
| `domicilio` | Dirección |
| `grado_academico` | Nivel de estudios (Lic., Maestría, etc.) |
| `estado` | Activo (1) / Inactivo (0) |
| `id_usuario` | Vínculo con cuenta de acceso |

#### Filtros en el listado

- Búsqueda por texto sobre nombre completo y número de empleado.
- Filtro por estado.

---

## 5. Área: Académico

El sidebar agrupa bajo **"Académico"** los módulos relacionados con el plan de estudios y evaluaciones.

### 5.1 Módulo: Materias

**Archivos:**  
- Controlador: [modulos/materias/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/logica.php) → clase [MateriasController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/logica.php#4-66)  
- Modelo: [modulos/materias/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php) → clase [Materia](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#4-87)  
- Vistas: [vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/ciclos/vista_index.html), [vista_create.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_create.html), [vista_edit.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_edit.html)

**Tablas BD:** `materias`, `profesor_materia`

#### ¿Qué hace?

Gestiona el **catálogo de materias** y la asignación de profesores a cada una.

#### Operaciones (CRUD)

| Acción | Método | Ruta URL |
|--------|--------|----------|
| Listar materias | [index()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php#23-28) | `/materias` |
| Alta de materia | [create()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#26-40) | `/materias/create` |
| Editar materia | [edit($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#36-57) | `/materias/edit/{id}` |
| Eliminar materia | [delete($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#58-64) | `/materias/delete/{id}` |

#### Campos de la materia

| Campo | Descripción |
|-------|-------------|
| `nombre` | Nombre de la materia |
| `cupo_maximo` | Número máximo de alumnos por materia |
| `vigencia_inicio` / `vigencia_fin` | Periodo de validez de la materia |

#### Relación Profesor–Materia

El modelo [Materia](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#4-87) incluye métodos adicionales para gestionar la relación **muchos-a-muchos** con profesores vía la tabla `profesor_materia`:

- [getProfesores($id_materia)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#62-74) → Lista profesores asignados
- [addProfesor($id_materia, $id_profesor)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#75-80) → Asigna un profesor (INSERT IGNORE)
- [clearProfesores($id_materia)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#81-86) → Limpia asignaciones previas antes de actualizar

---

### 5.2 Módulo: Grupos

**Archivos:**  
- Controlador: [modulos/grupos/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php) → clase [GruposController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#4-65)  
- Modelo: [modulos/grupos/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/conexion.php) → clase [Grupo](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/conexion.php#2-60)  
- Vistas: [vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/ciclos/vista_index.html), [vista_create.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_create.html), [vista_edit.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_edit.html)

**Tablas BD:** `grupos`, `alumno_grupo`

#### ¿Qué hace?

Gestiona los **grupos escolares** (ej. 1°A Matutino, 2°B Vespertino) y su pertenencia a ciclos escolares.

#### Operaciones (CRUD)

| Acción | Método | Ruta URL |
|--------|--------|----------|
| Listar grupos | [index()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php#23-28) | `/grupos` |
| Alta de grupo | [create()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#26-40) | `/grupos/create` |
| Editar grupo | [edit($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#36-57) | `/grupos/edit/{id}` |
| Eliminar grupo | [delete($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#58-64) | `/grupos/delete/{id}` |

#### Campos del grupo

| Campo | Descripción |
|-------|-------------|
| `grado` | Grado o nivel (ej. "1°", "2°") |
| `seccion` | Letra de sección (ej. "A", "B") |
| `ciclo_escolar` | Año o período (ej. "2025-2026") |
| `turno` | `MATUTINO` o `VESPERTINO` |

---

### 5.3 Módulo: Calificaciones

**Archivos:**  
- Controlador: [modulos/calificaciones/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/calificaciones/logica.php) → clase [CalificacionesController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/calificaciones/logica.php#4-74)  
- Modelo: [modulos/calificaciones/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/calificaciones/conexion.php) → clase [Calificacion](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/calificaciones/conexion.php#4-76)  
- Vistas: [vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/ciclos/vista_index.html), [vista_create.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_create.html), [vista_edit.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_edit.html)

**Tabla BD:** [calificaciones](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumno/logica.php#49-68)

#### ¿Qué hace?

Registra y administra las **calificaciones** de los alumnos por materia y período. Cada calificación está vinculada a una inscripción específica (alumno + oferta de horario).

#### Operaciones (CRUD)

| Acción | Método | Ruta URL |
|--------|--------|----------|
| Listar calificaciones | [index()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php#23-28) | `/calificaciones` |
| Registrar calificación | [create()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#26-40) | `/calificaciones/create` |
| Editar calificación | [edit($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#36-57) | `/calificaciones/edit/{id}` |
| Eliminar calificación | [delete($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#58-64) | `/calificaciones/delete/{id}` |

#### Campos de la calificación

| Campo | Descripción |
|-------|-------------|
| `id_inscripcion` | FK a `inscripciones` (alumno + materia) |
| `etiqueta_periodo` | Nombre libre del período: "Parcial 1", "Final", etc. |
| `puntaje` | Calificación numérica (`DECIMAL 4,2`) |
| `estado` | `ACTIVO` o `HISTORICO` |
| `fecha_registro` | Fecha de captura (automática) |

#### Vista de listado

El [getAll()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/conexion.php#11-16) del modelo hace un JOIN multi-tabla:
`calificaciones ← inscripciones ← alumnos + oferta_horario ← materias`  
Mostrando: matrícula, nombre del alumno, materia, período y puntaje.

#### Método especial

- [getByInscripcion($id_inscripcion)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/calificaciones/conexion.php#69-75) → Útil para ver el historial completo de calificaciones de un alumno en una materia específica.

---

### 5.4 Módulo: Ciclos Escolares

**Archivos:**  
- Vista: [modulos/ciclos/vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/ciclos/vista_index.html)

> **Nota:** Este módulo cuenta únicamente con vista. La lógica de ciclo activo se gestiona mediante la función `ciclo_activo()` consumida por el portal del alumno y el dashboard.

---

## 6. Área: Infraestructura

El sidebar agrupa bajo **"Infraestructura"** los módulos relacionados con la asignación de recursos físicos y temporales.

### 6.1 Módulo: Salones

**Archivos:**  
- Controlador: [modulos/salones/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/salones/logica.php) → clase [SalonesController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/salones/logica.php#4-61)  
- Modelo: [modulos/salones/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/salones/conexion.php) → clase [Salon](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/salones/conexion.php#4-57)  
- Vistas: [vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/ciclos/vista_index.html), [vista_create.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_create.html), [vista_edit.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_edit.html)

**Tabla BD:** `salones`

#### ¿Qué hace?

Gestiona el **catálogo de aulas/salones** disponibles en la institución.

#### Operaciones (CRUD)

| Acción | Método | Ruta URL |
|--------|--------|----------|
| Listar salones | [index()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php#23-28) | `/salones` |
| Alta de salón | [create()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#26-40) | `/salones/create` |
| Editar salón | [edit($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#36-57) | `/salones/edit/{id}` |
| Eliminar salón | [delete($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#58-64) | `/salones/delete/{id}` |

#### Campos del salón

| Campo | Descripción |
|-------|-------------|
| `nombre` | Identificador del salón (ej. "Aula 101") |
| `capacidad` | Número máximo de alumnos que caben |

> **Importante:** La `capacidad` del salón se usa como **restrictor de cupo** en la creación de ofertas de horario.

---

### 6.2 Módulo: Horarios (Oferta)

**Archivos:**  
- Controlador: [modulos/horarios/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php) → clase [HorariosController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php#5-107)  
- Modelo: [modulos/horarios/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/conexion.php) → clase [Horario](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/conexion.php#4-95)  
- Vistas: [vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/ciclos/vista_index.html), [vista_create.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_create.html), [vista_edit.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_edit.html)

**Tabla BD:** `oferta_horario`

#### ¿Qué hace?

Gestiona las **ofertas de horario**: la publicación de qué materia, con qué profesor, en qué salón, a qué hora y qué día se imparte. Es el núcleo de la planeación académica.

#### Operaciones (CRUD)

| Acción | Método | Ruta URL |
|--------|--------|----------|
| Listar ofertas | [index()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php#23-28) | `/horarios` |
| Crear oferta | [create()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#26-40) | `/horarios/create` |
| Editar oferta | [edit($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#36-57) | `/horarios/edit/{id}` |
| Eliminar oferta | [delete($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#58-64) | `/horarios/delete/{id}` |

#### Campos de la oferta de horario

| Campo | Descripción |
|-------|-------------|
| `id_materia` | FK a `materias` |
| `id_profesor` | FK a `profesores` |
| `id_salon` | FK a `salones` |
| `id_grupo` | FK a `grupos` (opcional) |
| `dia` | Día de la semana: `LUNES`–`VIERNES` |
| `hora_inicio` / `hora_fin` | Rango horario |
| `cupo_maximo` | Calculado automáticamente (regla de negocio) |
| `ciclo_escolar` | Período académico |
| `estado` | Activo (1) / Inactivo (0) |

#### 🔑 Regla de negocio clave

> El `cupo_maximo` de una oferta **se calcula automáticamente** en la capa de negocio como el **mínimo** entre `materias.cupo_maximo` y `salones.capacidad`:
>
> ```sql
> SELECT LEAST(
>   (SELECT cupo_maximo FROM materias WHERE id_materia=?),
>   (SELECT capacidad   FROM salones   WHERE id_salon=?)
> ) AS cupo_maximo
> ```
>
> Garantiza que nunca se exceda la capacidad física del salón ni el límite por materia.

#### Vista de listado

El [getAll()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/conexion.php#11-16) hace JOIN con `materias`, `profesores`, `salones` y `grupos` para mostrar la tabla completa.

---

### 6.3 Módulo: Inscripciones

**Archivos:**  
- Controlador: [modulos/inscripciones/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/inscripciones/logica.php) → clase [InscripcionesController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/inscripciones/logica.php#4-53)  
- Modelo: [modulos/inscripciones/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/inscripciones/conexion.php) → clase [Inscripcion](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/inscripciones/conexion.php#4-82)  
- Vistas: [vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/ciclos/vista_index.html) *(sin vista de edición individual)*

**Tabla BD:** `inscripciones`

#### ¿Qué hace?

Gestiona el **proceso de inscripción** de un alumno a una oferta de horario específica. Es el vínculo entre alumnos y materias que hace posible el registro de calificaciones.

#### Operaciones

| Acción | Método | Ruta URL |
|--------|--------|----------|
| Listar inscripciones | [index()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php#23-28) | `/inscripciones` |
| Inscribir alumno | [create()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#26-40) | `/inscripciones/create` |
| Cancelar inscripción | [delete($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#58-64) | `/inscripciones/delete/{id}` |

#### Campos de inscripción

| Campo | Descripción |
|-------|-------------|
| `id_alumno` | FK a `alumnos` |
| `id_oferta` | FK a `oferta_horario` |
| `fecha_inscripcion` | Fecha automática (CURRENT_DATE) |
| `estado` | Activo (1) / Baja (0) |

> Existe restricción UNIQUE en [(id_alumno, id_oferta)](file:///c:/xampp/htdocs/ControlEscolarPHP/config/init.php#15-20), lo que impide inscripciones duplicadas.

#### Método especial

- [getByAlumno($id_alumno)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/inscripciones/conexion.php#66-81) → Devuelve todas las inscripciones de un alumno con datos expandidos de materia, profesor, salón y horario.

---

## 7. Área: Administración

El sidebar agrupa bajo **"Administración"** los módulos de control del sistema.

### 7.1 Módulo: Usuarios

**Archivos:**  
- Controlador: [modulos/usuarios/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/usuarios/logica.php) → clase [UsuariosController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/usuarios/logica.php#4-64)  
- Modelo: [modulos/usuarios/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/usuarios/conexion.php) → clase [Usuario](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/usuarios/conexion.php#4-78)  
- Vistas: [vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/ciclos/vista_index.html), [vista_create.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_create.html), [vista_edit.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/vista_edit.html)

**Tabla BD:** `usuarios`

#### ¿Qué hace?

Gestiona las **cuentas de acceso** al sistema. Cada usuario puede vincularse a un alumno o docente, determinando así su rol en la aplicación.

#### Operaciones (CRUD)

| Acción | Método | Ruta URL |
|--------|--------|----------|
| Listar usuarios | [index()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/horarios/logica.php#23-28) | `/usuarios` |
| Crear usuario | [create()](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/materias/conexion.php#26-40) | `/usuarios/create` |
| Editar usuario | [edit($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#36-57) | `/usuarios/edit/{id}` |
| Eliminar usuario | [delete($id)](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/grupos/logica.php#58-64) | `/usuarios/delete/{id}` |

#### Campos del usuario

| Campo | Descripción |
|-------|-------------|
| `nombre_usuario` | Login único del usuario |
| `contrasena` | Hash bcrypt (`password_hash()`) |
| `estado` | Activo (1) / Inactivo (0) |

#### Seguridad de contraseñas

- Al **crear**: la contraseña se hashea con `password_hash($pass, PASSWORD_DEFAULT)` (bcrypt).
- Al **editar**: si el campo contraseña viene vacío, se conserva la existente; si viene con valor, se re-hashea.

---

### 7.2 Módulo: Reportes

**Archivos:**  
- Controlador: [modulos/reportes/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/reportes/logica.php) → clase [ReportesController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/reportes/logica.php#4-73)  
- Modelo: [modulos/reportes/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/reportes/conexion.php) → clase [Reporte](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/reportes/conexion.php#4-66)  
- Vistas: [vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/ciclos/vista_index.html), [vista_lista_grupo_print.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/reportes/vista_lista_grupo_print.html), [vista_boleta_print.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/reportes/vista_boleta_print.html)

#### ¿Qué hace?

Genera **reportes imprimibles** del estado académico. Implementa dos tipos de reporte:

#### Reporte 1: Lista de grupo

- **Ruta:** `/reportes/lista_grupo?id={id_grupo}`
- **Función:** Obtiene todos los alumnos activos de un grupo mediante la tabla `alumno_grupo`. Renderiza una lista imprimible ordenada alfabéticamente con nombre, matrícula y género.

#### Reporte 2: Boleta de calificaciones

- **Ruta:** `/reportes/boleta?matricula={matricula}`
- **Función:** Busca al alumno por matrícula, obtiene su grupo y todas sus calificaciones activas vía JOINs: `calificaciones → inscripciones → oferta_horario → materias`. Calcula el promedio general.

```sql
SELECT m.nombre AS materia, c.puntaje, c.fecha_registro, c.etiqueta_periodo
FROM calificaciones c
JOIN inscripciones i   ON c.id_inscripcion = i.id_inscripcion
JOIN oferta_horario o  ON i.id_oferta = o.id_oferta
JOIN materias m        ON o.id_materia = m.id_materia
WHERE i.id_alumno = ? AND c.estado = 'ACTIVO'
ORDER BY o.ciclo_escolar DESC, m.nombre
```

#### Página de selección ([vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/ciclos/vista_index.html))

Muestra un panel donde el director/admin:
1. Selecciona un grupo → genera lista de grupo
2. Ingresa una matrícula → genera boleta individual

---

## 8. Área: Portal del Alumno

**Módulo:** `alumno` (singular, diferente a `alumnos`)  
**Archivos:**  
- Controlador: [modulos/alumno/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumno/logica.php) → clase [AlumnoController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumno/logica.php#4-69)  
- Modelo: [modulos/alumno/conexion.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumno/conexion.php) → clase [AlumnoPortal](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumno/conexion.php#4-49)  
- Vistas: [vista_horario.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumno/vista_horario.html), [vista_calificaciones.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumno/vista_calificaciones.html)

#### ¿Qué hace?

Proporciona una **vista personal** exclusiva para usuarios con rol `alumno`. Si intentan acceder usuarios de otro rol son redirigidos al dashboard.

> **Guard de rol explícito:** El constructor verifica `$_SESSION['usuario_rol'] === 'alumno'`.

#### Sub-módulo: Mi Horario

- **Ruta:** `/alumno/horario`
- Obtiene el ciclo activo vigente.
- Busca el grupo al que pertenece el alumno en `alumnos_grupos`.
- Recupera todos los horarios del grupo para ese ciclo.
- **Organiza las clases en una grilla por día** (Lunes–Viernes) para mostrar como tabla semanal.

#### Sub-módulo: Mis Calificaciones

- **Ruta:** `/alumno/calificaciones`
- Obtiene el ciclo activo vigente.
- Consulta [calificaciones](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumno/logica.php#49-68) filtrando por `alumno_id` y `ciclo_id`.
- **Calcula el promedio general** de todas las materias del ciclo.
- Muestra nombre de materia, clave y calificación.

---

## 9. Área: Dashboard

**Archivos:**  
- Controlador: [modulos/dashboard/logica.php](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/dashboard/logica.php) → clase [DashboardController](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/dashboard/logica.php#4-51)  
- Vista: [modulos/dashboard/vista_index.html](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/dashboard/vista_index.html)

#### ¿Qué hace?

Es la **página principal** después del login. Su contenido varía según el rol del usuario.

#### Comportamiento por rol

| Rol | Qué muestra |
|-----|-------------|
| `docente` / `profesor` | Clases del día actual según `oferta_horario` (materia, grupo, salón, horario) |
| `admin` / [director](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php#47-56) | Panel general del sistema |
| `alumno` | Accesos rápidos a horario y calificaciones personales |

#### Consulta para docentes

Detecta el día actual en español, busca el `id_profesor` del usuario en sesión, y trae sus clases:

```sql
SELECT h.hora_inicio, h.hora_fin, m.nombre AS materia,
       g.grado, g.seccion, s.nombre AS salon
FROM oferta_horario h
JOIN materias m ON m.id_materia = h.id_materia
LEFT JOIN grupos g ON g.id_grupo = h.id_grupo
JOIN salones s ON s.id_salon = h.id_salon
WHERE h.id_profesor = ? AND h.dia = ? AND h.estado = 1
ORDER BY h.hora_inicio
```

---

## 10. Base de Datos

**Nombre:** `control_escolar` · **Motor:** MySQL / MariaDB

### Diagrama de relaciones

```
usuarios ──────────────┬──── alumnos ──── alumno_grupo ──── grupos
                       └──── profesores ─── profesor_materia ─── materias
                                                                      │
                                                               oferta_horario ←─ salones
                                                                      │         └── grupos
                                                               inscripciones
                                                                      │
                                                               calificaciones
```

### Tablas principales

| Tabla | Descripción |
|-------|-------------|
| `usuarios` | Cuentas de acceso (login, contraseña hash, estado) |
| `alumnos` | Padrón de estudiantes con datos personales |
| `profesores` | Catálogo de docentes con datos académicos |
| `salones` | Aulas con capacidad física |
| `materias` | Catálogo de asignaturas con cupo máximo y vigencia |
| `grupos` | Grupos escolares por grado, sección, ciclo y turno |

### Tablas relacionales

| Tabla | Relaciona | Descripción |
|-------|-----------|-------------|
| `alumno_grupo` | `alumnos` ↔ `grupos` | Qué alumnos están en qué grupo |
| `profesor_materia` | `profesores` ↔ `materias` | Qué materias puede impartir cada docente |
| `oferta_horario` | `materias` + `profesores` + `salones` + `grupos` | Clase publicada con horario y cupo |
| `inscripciones` | `alumnos` ↔ `oferta_horario` | Alumnos inscritos a clases específicas |
| [calificaciones](file:///c:/xampp/htdocs/ControlEscolarPHP/modulos/alumno/logica.php#49-68) | `inscripciones` | Notas por período de cada inscripción |

### Tablas de permisos (esquema planificado)

| Tabla | Descripción |
|-------|-------------|
| `modulos` | Catálogo de módulos del sistema |
| `perfiles` | Conjuntos de permisos (agregar, eliminar, editar, exportar) |
| `permisos` | Relación usuario-módulo-perfil |

> **Nota:** Las tablas `modulos`, `perfiles` y `permisos` están definidas en el esquema SQL, pero actualmente el control de acceso se implementa mediante el mapa de roles en [config/auth.php](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php). La integración completa de permisos granulares es un objetivo futuro.

---

## 11. Sistema de Roles y Permisos

El sistema implementa **control de acceso basado en roles (RBAC)** de manera simplificada:

### Roles disponibles

| Rol | Tipo de usuario | Acceso |
|-----|----------------|--------|
| `admin` | Administrador del sistema | Total |
| [director](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php#47-56) | Director de la institución | Total |
| `profesor` | Docente registrado | Módulos académicos |
| `alumno` | Estudiante registrado | Portal personal |

### Detección automática del rol en el login

```
1. ¿Existe en tabla alumnos?    → rol = alumno
2. ¿Existe en tabla profesores? → rol = docente/profesor
3. De lo contrario              → rol = admin
```

### Visibilidad del menú lateral

El sidebar usa [puede_ver($modulo)](file:///c:/xampp/htdocs/ControlEscolarPHP/config/auth.php#30-46) para mostrar u ocultar cada elemento dinámicamente:

```php
// Director/Admin: ven todo
if ($u['rol'] === 'director' || $u['rol'] === 'admin') return true;

// Profesor: módulos académicos
'profesor' => ['calificaciones', 'horarios', 'materias', 'grupos', 'reportes']

// Alumno: portal personal
'alumno' => ['mi_horario', 'mis_calificaciones']
```

---

## 12. Flujo completo de una solicitud HTTP

```
[Navegador]
    │
    ▼
GET /?url=alumnos/edit/5
    │
    ▼
[index.php — Front Controller]
    ├── require_once config/init.php  (inicia sesión, carga helpers)
    ├── spl_autoload_register(...)    (mapea clases a archivos)
    ├── Parsea URL → controlador=Alumnos, método=edit, params=[5]
    ├── new AlumnosController()
    │     └── __construct() → require_auth() (¿hay sesión? si no, redirige login)
    │         └── new Alumno()  → db_connect() → PDO singleton
    └── $controller->edit(5)
            ├── $this->alumnoModel->getById(5)
            │     └── SELECT * FROM alumnos WHERE id_alumno = 5
            └── $this->view('alumnos/edit', ['alumno' => $alumno, ...])
                    ├── extract($data)  → variables PHP disponibles en la vista
                    └── require_once 'modulos/alumnos/vista_edit.html'
                              ├── includes/header.php  → navbar con usuario en sesión
                              ├── includes/sidebar.php → menú filtrado por rol
                              ├── <formulario de edición del alumno>
                              └── includes/footer.php  → pie de página

[Respuesta HTML completa al navegador]
```

---

*Reporte generado el 13 de marzo de 2026.*  
