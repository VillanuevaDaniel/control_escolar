# Especificación de Requerimientos Técnicos

El stack tecnológico que se decidió para trabajar este proyecto es **PHP**, **HTML/CSS (Bootstrap)** y **MySQL**, utilizando una arquitectura **basada en Módulos** para agilizar el desarrollo y mantener una estructura ligera y fácil de mantener.


--------------------------------------------------------------------------------

### 2. Matriz de Permisos y Perfiles de Usuario

La jerarquía de privilegios se define de la siguiente manera:

1. **Director (Admin):**
    - Gestión administrativa total: altas y bajas de personal docente.
    - Facultad de delegación: creación de perfiles administrativos con permisos granulares.
    - Control de tiempos: configuración de periodos de validez para las materias y ciclos escolares.
2. **Profesor:**
    - Gestión de materias impartidas y consulta de grupos/grados asignados.
    - Captura de calificaciones en escala decimal (0-10) con autonomía de periodos.
    - Generación de reportes académicos descargables.
3. **Alumno:**
    - Autogestión académica: registro manual de materias para conformación de horario.
    - Consulta de historial académico y visualización de estatus de calificaciones.


--------------------------------------------------------------------------------

### 3. Módulos del Sistema

#### 3.1 Módulo de Registro

Este módulo gestiona la persistencia de identidades y la estructura organizacional:

- **Alumnos:** Captura que incluye nombre, apellidos, dirección, sexo, escuela de procedencia, fotografía y **CURP**. Incorpora de forma obligatoria los datos del tutor (nombre, teléfono) y un campo de **comentarios para familias**. Es responsable de la **asociación a grados y grupos** (ej. 1°A, 2°B) mediante una relación lógica que permite la agrupación masiva.
- **Profesores:** Registro de número de empleado, **CURP**, escuela de procedencia, contacto, domicilio, grado de estudio y **estatus del profesor** (activo/inactivo).

#### 3.2 Módulo de Horarios y Salones

Controla la oferta académica y la infraestructura física. Permite al alumno la elección manual de materias basándose en los horarios definidos por el Director. Incluye la gestión de capacidad de aulas y **Detección automática de conflictos**, el cual emite avisos si se detectan cruces de horarios para un profesor o salón en la franja de **8:00 a 20:00**.

#### 3.3 Módulo de Calificaciones

Cálculo automático de promedios (por materia y general). Este módulo implementa la lógica de **estatus histórico**: cuando un alumno es dado de baja, sus registros de calificación no se eliminan, sino que cambian su estado para preservar la trazabilidad legal del historial académico. Las salidas de este módulo se consolidan en un reporte general por alumno.


--------------------------------------------------------------------------------

### 4. Arquitectura del Sistema (Modular)

El sistema renuncia a la complejidad del patrón MVC estricto a favor de una **Arquitectura por Módulos**. Esto reduce la sobrecarga de dependencias dando prioridad al rendimiento en equipos limitados:

- **Presentación:** Archivos de interfaz web (HTML, CSS (Bootstrap) y JS) cargados eficientemente en cada módulo.
- **Lógica de Procesamiento y Acceso a Datos (Módulos):** Archivos **PHP** agrupados por función (Registro, Horarios, Calificaciones). Estos archivos gestionan directamente tanto el flujo de información, la manipulación de datos y las consultas a **MySQL**, consolidando los procesos para obtener menores tiempos de ejecución y menor gasto de memoria.

--------------------------------------------------------------------------------

### 5. Requerimientos No Funcionales y Salidas de Información


- **Interoperabilidad:** El sistema permitirá la descarga de reportes **exclusivamente en formato Excel**, garantizando que la administración pueda procesar datos en herramientas estándar de oficina.
- **Rendimiento:** Optimización para alta concurrencia y búsqueda eficiente por campos significativos (Nombre, CURP, Matrícula, Grupo/Grado).
- **Interfaz de Usuario:** Diseño minimalista de ventana única, enfocado en la operatividad. Se descarta el modo oscuro para priorizar la legibilidad en entornos administrativos. Operación 100% en español.

---

### 6. Duración del proyecto y especificaciones

- **Plataforma y Hardware:** Optimizado para correr en entornos heredados o muy limitados, específicamente con capacidad de ejecutarse en **Windows 7 con un mínimo de 2 GB de RAM** (ej. servidor local vía XAMPP o como cliente en red).
- **Tecnología:** PHP, HTML5, CSS3 (Bootstrap), JavaScript puro, MySQL.
- **Optimización de Recursos:**
    - Arquitectura modular simple sin frameworks pesados ni abstracciones innecesarias.
    - Carga web ultraligera para no saturar la memoria RAM del equipo.
    - Minimización de peticiones y consultas simples directas.

---

### 7. Presupuesto previsto: Bottom-Up, Horas-Hombre

Se desgloso el proyecto en módulos, capas, se establecieron las horas base, la contingencia y tarifa ajustada.

Aplicando una formula básica: **Costo total = (Horas base + Contingencia) × Tarifa** se calculo el costo total y de en base a este costo se establecieron las etapas del proyecto y se estableció un porcentaje estimado para cada etapa.

El calculo quedo de esta manera:

**Inversión Total Final: $25,000 MXN**

|Etapa del Proyecto|Descripción|Porcentaje|Monto Estimado (MXN)|
|---|---|---|---|
|**Análisis y Requerimientos**|Levantamiento de requerimientos y adaptación del diseño|20%|$5,000|
|**Desarrollo y Codificación**|Programación backend (PHP), frontend (HTML/CSS (Bootstrap)/JS) y BD|45%|$11,250|
|**Pruebas y QA**|Pruebas de funcionamiento multiplataforma y navegador|20%|$5,000|
|**Implementación y Capacitación**|Despliegue en servidor web y capacitación básica|15%|$3,750|
|**TOTAL**||**100%**|**$25,000 MXN**|

---

**Negociado a Presupuesto Ajustado: $20,000 MXN**

| Etapa del Proyecto                | Descripción                                                                  | Porcentaje | Monto Estimado (MXN) |
| --------------------------------- | ---------------------------------------------------------------------------- | ---------- | -------------------- |
| **Análisis y Requerimientos**     | Levantamiento de requerimientos y adaptación del diseño                      | 20%        | $4,000               |
| **Desarrollo y Codificación**     | Programación backend (PHP), frontend (HTML/CSS (Bootstrap)/JS) y BD                      | 45%        | $9,000               |
| **Pruebas y QA**                  | Pruebas de funcionamiento multiplataforma y navegador                        | 20%        | $4,000               |
| **Implementación y Capacitación** | Despliegue en web hosting y capacitación básica                              | 15%        | $3,000               |
| **TOTAL**                         |                                                                              | **100%**   | **$20,000 MXN**      |
