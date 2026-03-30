CREATE DATABASE control_escolar;

USE control_escolar;

-- tabla de usuarios, maneja el login de todos (alumnos, profes, director)
CREATE TABLE usuarios (
    id_usuario BIGINT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    estado BOOLEAN DEFAULT TRUE
);

-- modulos del sistema, para el control de permisos
CREATE TABLE modulos (
    id_modulo BIGINT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion VARCHAR(150) NOT NULL,
    area VARCHAR(50) NOT NULL,
    estado BOOLEAN NOT NULL
);

-- ciclos escolares
CREATE TABLE ciclos_escolares (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    estado VARCHAR(20) DEFAULT 'Activo'
);

-- perfiles definen que puede hacer un usuario dentro de un modulo
CREATE TABLE perfiles (
    id_perfil BIGINT AUTO_INCREMENT PRIMARY KEY,
    apodo VARCHAR(50),
    descripcion VARCHAR(300),
    clave_agregar BOOLEAN NOT NULL DEFAULT FALSE,
    clave_eliminar BOOLEAN NOT NULL DEFAULT FALSE,
    clave_editar BOOLEAN NOT NULL DEFAULT FALSE,
    clave_exportar BOOLEAN NOT NULL DEFAULT FALSE
);

-- relaciona usuarios con modulos usando un perfil especifico
CREATE TABLE permisos (
    id_permiso BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT NOT NULL,
    id_modulo BIGINT NOT NULL,
    id_perfil BIGINT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario),
    FOREIGN KEY (id_modulo) REFERENCES modulos (id_modulo),
    FOREIGN KEY (id_perfil) REFERENCES perfiles (id_perfil),
    UNIQUE (id_usuario, id_modulo)
);

-- alumnos
CREATE TABLE alumnos (
    id_alumno BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT UNIQUE,
    matricula VARCHAR(20) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellido_paterno VARCHAR(50),
    apellido_materno VARCHAR(50),
    curp VARCHAR(18) UNIQUE,
    genero CHAR(1),
    domicilio VARCHAR(150),
    escuela_procedencia VARCHAR(100),
    ruta_foto VARCHAR(255),
    nombre_tutor VARCHAR(100),
    telefono_tutor VARCHAR(20),
    comentarios TEXT,
    estado BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario)
);

-- profesores
CREATE TABLE profesores (
    id_profesor BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT UNIQUE,
    numero_empleado VARCHAR(20) UNIQUE,
    nombre_completo VARCHAR(100) NOT NULL,
    curp VARCHAR(18) UNIQUE,
    telefono VARCHAR(20),
    domicilio VARCHAR(150),
    escuela_procedencia VARCHAR(100),
    ruta_foto VARCHAR(255),
    grado_academico VARCHAR(100),
    estado BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario)
);

-- salones
CREATE TABLE salones (
    id_salon BIGINT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20),
    capacidad INT
);

-- grupos tipo 1A, 2B, etc.
CREATE TABLE grupos (
    id_grupo BIGINT AUTO_INCREMENT PRIMARY KEY,
    grado VARCHAR(10),
    seccion VARCHAR(5),
    ciclo_escolar VARCHAR(20),
    turno ENUM('MATUTINO', 'VESPERTINO') DEFAULT 'MATUTINO'
);

-- que alumnos pertenecen a que grupo
CREATE TABLE alumno_grupo (
    id_ag BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_alumno BIGINT NOT NULL,
    id_grupo BIGINT NOT NULL,
    FOREIGN KEY (id_alumno) REFERENCES alumnos (id_alumno),
    FOREIGN KEY (id_grupo) REFERENCES grupos (id_grupo),
    UNIQUE (id_alumno, id_grupo)
);

-- materias, el director define la materia junto con su horario y asignación
CREATE TABLE materias (
    id_materia BIGINT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cupo_maximo INT NOT NULL, -- cupo maximo de alumnos por materia
    vigencia_inicio DATE,
    vigencia_fin DATE,
    id_profesor BIGINT,
    id_salon BIGINT,
    id_grupo BIGINT,
    dia ENUM(
        'LUNES',
        'MARTES',
        'MIERCOLES',
        'JUEVES',
        'VIERNES'
    ),
    hora_inicio TIME,
    hora_fin TIME,
    ciclo_escolar VARCHAR(20),
    FOREIGN KEY (id_profesor) REFERENCES profesores (id_profesor),
    FOREIGN KEY (id_salon) REFERENCES salones (id_salon),
    FOREIGN KEY (id_grupo) REFERENCES grupos (id_grupo)
);

-- relacion muchos a muchos entre profesores y materias
-- define que materias puede impartir cada profe
CREATE TABLE profesor_materia (
    id_pm BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_profesor BIGINT NOT NULL,
    id_materia BIGINT NOT NULL,
    FOREIGN KEY (id_profesor) REFERENCES profesores (id_profesor),
    FOREIGN KEY (id_materia) REFERENCES materias (id_materia),
    UNIQUE (id_profesor, id_materia)
);

-- ya no hay oferta_horario como tabla, los campos se movieron a materias

-- el alumno se inscribe a una materia especifica
CREATE TABLE inscripciones (
    id_inscripcion BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_alumno BIGINT NOT NULL,
    id_materia BIGINT NOT NULL,
    fecha_inscripcion DATE DEFAULT(CURRENT_DATE),
    estado BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (id_alumno) REFERENCES alumnos (id_alumno),
    FOREIGN KEY (id_materia) REFERENCES materias (id_materia),
    UNIQUE (id_alumno, id_materia)
);

-- calificaciones, el profe decide como nombrar el periodo
CREATE TABLE calificaciones (
    id_calificacion BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_inscripcion BIGINT NOT NULL,
    etiqueta_periodo VARCHAR(50), -- el profe lo nombra como quiera: "Parcial 1", "Final", etc.
    puntaje DECIMAL(4, 2),
    fecha_registro DATE DEFAULT(CURRENT_DATE),
    estado ENUM('ACTIVO', 'HISTORICO') DEFAULT 'ACTIVO',
    FOREIGN KEY (id_inscripcion) REFERENCES inscripciones (id_inscripcion)
);

INSERT INTO
    usuarios (
        nombre_usuario,
        contrasena,
        estado
    )
VALUES ('Admin', '123', TRUE);