# Sistema de Control Escolar

Sistema integral de gestión para escuelas e instituciones educativas, desarrollado en **PHP puro** bajo la arquitectura **MVC (Modelo-Vista-Controlador)**. Está diseñado para ejecutarse en entornos locales empresariales compatibles con navegadores de uso diario en sistemas operativos de legado o actuales, empleando tecnologías maduras y robustas.

## Descripción General

Este proyecto permite la administración completa del flujo escolar, con un control detallado de permisos por perfiles. Incluye la matriculación de alumnos, la asignación de docentes a materias, la vinculación a grupos, pero destaca por su sistema dinámico de publicación de "Oferta de Horarios" el cual los alumnos pueden aprovechar para realizar inscripciones. Finalmente permite a los maestros llevar un sistema de calificaciones de forma histórica.

## Características y Módulos

La base de datos actual (`schema.sql`) estructura al sistema en los siguientes módulos principales:

- **Usuarios y Permisos**: Sistema de autenticación central con soporte para relacionar dinámicamente usuarios, módulos (áreas del sistema) y perfiles operativos que determinan privilegios finos (agregar, eliminar, editar, exportar).
- **Alumnos**: Gestión del padrón estudiantil, incluyendo credenciales (matrícula, CURP), contacto (tutor), procedencia escolar y fotografía.
- **Profesores (Docentes)**: Padrón de profesorado, número de empleado, control de grado académico e historial.
- **Materias**: Catálogo de asignaturas donde el director/admin configura completamente la clase: asigna el profesor, el grupo, el salón, el día, la hora y el ciclo escolar.
- **Salones**: Registro de aulas con indicador de `capacidad`.
- **Grupos y Ciclo Escolar**: Definición de grados y secciones en ciclos escolares específicos, controlando turnos. Incluye el rastreo de qué alumnos pertenecen a qué grupo.
- **Horarios**: Vista general e interactiva donde los administradores, docentes y alumnos pueden revisar las clases programadas asociadas a sus respectivos perfiles o grupos. Todo se alimenta directamente de la tabla Materias.
- **Inscripciones**: Los alumnos quedan inscritos a las materias/clases que se generaron ya sea de forma directa o ligados mediante su grupo orgánico.
- **Calificaciones**: Los profesores evalúan a los alumnos usando sus propias "etiquetas de periodo" (por ejemplo: "Primer Parcial", "Final"), lo que permite un control minucioso e histórico de los puntajes alcanzados en cada materia.

## Estructura de Tablas y Formularios

De acuerdo al diseño de la base de datos, cada módulo opera con la siguiente información. Se especifica qué datos se solicitan al crear un registro nuevo (Formulario) y cuáles principales se visualizan en los listados generales (Tablas):

### Alumnos

- **Se solicita al crear:** Matrícula (única), Nombre(s), Apellido paterno, Apellido materno, CURP (única), Género, Domicilio, Escuela de procedencia, Fotografía (ruta), Nombre del tutor familiar, Teléfono del tutor y Comentarios adicionales. *(Se autogenera o asocia un Usuario en el sistema).*
- **Se muestra en tabla:** Matrícula, Nombre completo, CURP, Teléfono del tutor, Estado (Activo/Inactivo).

### Profesores (Docentes)

- **Se solicita al crear:** Número de empleado (único), Nombre completo, CURP (única), Teléfono personal, Domicilio, Escuela de procedencia y Grado académico. *(Se autogenera o asocia un Usuario en el sistema).*
- **Se muestra en tabla:** Número de empleado, Nombre completo, Teléfono, Grado académico y Estado.

### Salones (Aulas)

- **Se solicita al crear:** Nombre o identificador del salón (ej. *Aula 101*, *Laboratorio B*) y Capacidad máxima de alumnos que soporta físicamente.
- **Se muestra en tabla:** Nombre del Salón y Capacidad total.

### Materias (y Horario Integrado)

- **Se solicita al crear:** Datos de la asignatura (clave, nombre, área, horas funcionales), y de manera integrada toda la configuración de su horario: Docente, Ciclo Escolar, Grupo, Salón, Día y Horas de Inicio y Fin.
- **Se muestra en tabla:** Clave, Nombre de la Materia, Área, Horas y Estado. Las configuraciones de horario de dichas materias se visualizan a detalle gráficamente en el panel de "Horarios".

### Grupos

- **Se solicita al crear:** Grado numérico o nombre, Sección (letra), Ciclo escolar que le corresponde y Turno (Matutino / Vespertino).
- **Se muestra en tabla:** Grado, Sección, Turno y Ciclo Escolar asociado.

### Horario e Inscripciones del Alumno

- **Lógica de Visualización:** En la vista de "Mi Horario", el alumno ve reflejadas de manera automática todas aquellas **Materias** que fueron creadas y asignadas específicamente para el **Grupo** al que se inscribió dentro del ciclo en curso, agilizando el proceso de asignación masiva.
- **Se muestra en tabla:** Matrícula y Nombre del Alumno, Materia respectiva, Fecha en que se inscribió y Estado.

### Calificaciones

- **Se solicita al crear:** La Inscripción que se va a evaluar (El historial del Alumno cursando esa Oferta de Horario en específico), una Etiqueta o nombre corto del periodo decidido por el profesor (Ej: *"Tesis"*, *"Parcial 1"*), y el Puntaje numérico final de ese periodo.
- **Se muestra en tabla:** Etiqueta del periodo, Puntaje parcial/final de la etapa y Fecha del registro.

## Arquitectura y Tecnologías

- **Backend**: PHP 7+ / 8 (Desarrollo estructurado con POO).
- **Patrón**: MVC Custom (Controlador Frontal en `index.php`).
- **Base de Datos**: MySQL.
- **Frontend**: HTML5, CSS3, JavaScript.
- **Frameworks UI**: Bootstrap 4 (Local), FontAwesome / Bootstrap Icons.
- **Librerías Extra**: jQuery 3, DataTables (para manejo de listas extensas), SweetAlert2 (Notificaciones).

## Estructura del Proyecto

```text
ControlEscolarPHP/
├── app/
│   ├── Controllers/   # Lógica de negocio e interacciones MVC
│   ├── Models/        # Entidades y consultas a la base de datos (PDO)
│   └── Views/         # Interfaces de usuario e interfaces HTML
├── assets/            # Archivos estáticos
│   ├── css/           # Estilos personalizados (app.css, modulos)
│   ├── js/            # Scripts del frontend
│   ├── img/           # Imágenes y logos
│   └── lib/           # Bibliotecas locales (Bootstrap, jQuery...)
├── config/
│   ├── db.php         # Configuración de base de datos PDO
│   ├── init.php       # Bootstrap y variables globales
│   └── auth.php       # Manejo de sesiones
├── includes/
│   └── core/          # Componentes base como Controller, Model, View
├── schema.sql         # Esquema actualizado de la base de datos MySQL
├── index.php          # Front Controller / Enrutador principal
└── .htaccess          # Redireccionamiento de URLs limpias
```

## Requisitos del Sistema

- Servidor Web: Apache (Ej. XAMPP, WAMPP, Laragon).
- PHP: Versión 7.4 o superior (recomendado 8.1+). Extensiones `pdo_mysql`.
- Base de datos: MySQL 5.7+ o MariaDB.
- Módulo mod_rewrite habilitado en Apache (para el `index.php`).

## Instalación y Configuración de BD (XAMPP / phpMyAdmin)

Sigue estos pasos para echar a andar el proyecto en un entorno local (XAMPP):

1. **Ubicar archivos**: Clona o copia la carpeta del proyecto (`ControlEscolarPHP`) en el directorio público de tu servidor web, por defecto en XAMPP suele ser `C:\xampp\htdocs\ControlEscolarPHP`.
2. **Encender servidor**: Abre el "XAMPP Control Panel" y dale al botón de "Start" en los servicios **Apache** y **MySQL**.
3. **Importar la Base de Datos**:
   - Ingresa desde tu navegador a phpMyAdmin escribiendo en la barra: `http://localhost/phpmyadmin/`
   - No necesitas crear una base de datos nueva, puesto que el archivo base de SQL ya cuenta con su propio script de creación.
   - Dirígete de forma directa a la pestaña que dice **Importar** (en la parte superior de la interfaz).
   - Pulsa en **Seleccionar archivo** y elige tu archivo `schema.sql` (ubicado dentro de tu carpeta `ControlEscolarPHP`).
   - Baja hasta el final y da clic al botón de **Importar** / **Continuar**.
   - Si todo salió bien, a tu lado izquierdo aparecerá la base de datos `control_escolar` generada ya con sus tablas y datos base bien estructurados dependiendo de sus llaves foráneas.
4. **Validar conexión**: Asegúrate de que los credenciales de la variable PDO en `config/db.php` sean las por defecto para tu ambiente (casi siempre usuario `root` con contraseña en blanco para localhost).
5. **Comprobar acceso**: Entra desde tu navegador a `http://localhost/ControlEscolarPHP`.