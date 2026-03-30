<?php

require_once 'config/init.php';

// Autoloader para clases de core y módulos
spl_autoload_register(function ($className) {
  if (file_exists('includes/core/' . $className . '.php')) {
    require_once 'includes/core/' . $className . '.php';
    return;
  }

  $map = [
    'AlumnoController' => 'alumno/logica.php',
    'AlumnosController' => 'alumnos/logica.php',
    'AuthController' => 'auth/logica.php',
    'CalificacionesController' => 'calificaciones/logica.php',
    'DashboardController' => 'dashboard/logica.php',
    'DocentesController' => 'docentes/logica.php',
    'GruposController' => 'grupos/logica.php',
    'HorariosController' => 'horarios/logica.php',
    'InscripcionesController' => 'inscripciones/logica.php',
    'MateriasController' => 'materias/logica.php',
    'ReportesController' => 'reportes/logica.php',
    'CiclosController'   => 'ciclos/logica.php',
    'SalonesController'  => 'salones/logica.php',
    'UsuariosController' => 'usuarios/logica.php',

    'Alumno' => 'alumnos/conexion.php',
    'AlumnoPortal' => 'alumno/conexion.php',
    'Calificacion' => 'calificaciones/conexion.php',
    'Docente' => 'docentes/conexion.php',
    'Grupo' => 'grupos/conexion.php',
    'Horario' => 'horarios/conexion.php',
    'Inscripcion' => 'inscripciones/conexion.php',
    'Materia' => 'materias/conexion.php',
    'Reporte' => 'reportes/conexion.php',
    'CicloEscolar' => 'ciclos/conexion.php',
    'Salon'        => 'salones/conexion.php',
    'Usuario'      => 'usuarios/conexion.php',
  ];

  if (isset($map[$className])) {
    $file = 'modulos/' . $map[$className];
    if (file_exists($file)) {
      require_once $file;
    }
  }
});

// Obtener la URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

// Valores por defecto
$controllerName = 'AuthController';
$methodName = 'index';
$params = [];

if (!empty($url)) {
  $parts = explode('/', $url);

  // El primer segmento es el controlador
  $controllerName = ucfirst($parts[0]) . 'Controller';

  // El segundo segmento es el método (opcional)
  if (isset($parts[1])) {
    $methodName = $parts[1];
  }

  // El resto son parámetros
  $params = array_slice($parts, 2);
}

// El Front Controller ya tiene el autoloader, por lo que no es necesario require_once manual
if (class_exists($controllerName)) {
  $controller = new $controllerName();

  if (method_exists($controller, $methodName)) {
    call_user_func_array([$controller, $methodName], $params);
  } else {
    die("Método $methodName no encontrado en $controllerName.");
  }
} else {
  // Si no existe el controlador, intentar AuthController por defecto
  if (class_exists('AuthController')) {
    $controller = new AuthController();
    $controller->index();
  } else {
    die("Error fatal: No se pudo cargar el controlador base.");
  }
}
