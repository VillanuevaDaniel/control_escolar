<?php
// includes/header.php — Cabecera HTML compartida
// Variables esperadas: $page_title (string), $modulo_activo (string)
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/fonts.css">
  <!-- Bootstrap 4 LOCAL -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap-icons.css">
  <!-- Estilos propios -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/app.css">

  <?php
  // Cargar CSS específico por módulo si existe
  $modulos_css = array('alumnos', 'docentes', 'grupos', 'materias', 'horarios', 'calificaciones', 'usuarios', 'reportes', 'salones', 'ciclos');
  if (isset($modulo_activo) && in_array($modulo_activo, $modulos_css)) {
    echo '  <link rel="stylesheet" href="' . BASE_URL . 'assets/css/' . $modulo_activo . '.css">' . "\n";
  }
  ?>
  <!--[if lt IE 9]>
  <script src="<?php echo BASE_URL; ?>assets/js/html5shiv.min.js"></script>
  <![endif]-->
  <script>
    // Forzar recarga si la página se carga desde la caché de "Adelante/Atrás" del navegador
    window.onpageshow = function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    };
  </script>
</head>

<body class="bg-light">

  <?php
  // Mostrar flash si existe
  $flash = get_flash();
  if ($flash): ?>
    <div id="flash-container" style="position:fixed;top:0;left:0;right:0;z-index:9999;padding:0 15px;">
      <div class="alert alert-<?php echo e($flash['tipo']); ?> alert-dismissible fade show mt-2" role="alert">
        <?php echo e($flash['msg']); ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
    </div>
  <?php endif; ?>

  <!-- NAVBAR SUPERIOR -->
  <nav class="navbar navbar-expand-md navbar-light sticky-top shadow-none">
    <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE_URL; ?>dashboard">
      <span class="material-symbols-outlined mr-2" style="background:#197fe6; color:#fff; padding:4px; border-radius:4px;">school</span>
      Control Escolar
    </a>
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ml-auto align-items-center">
        <?php $u = session_user(); ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 5px 10px; border-radius: 8px;">
            <!-- Info -->
            <div class="text-right mr-2 d-none d-md-block">
              <div class="font-weight-bold" style="font-size: 0.9rem; line-height: 1.2; color:#0e141b;"><?php echo e($u['nombre']); ?></div>
              <div class="text-muted small" style="line-height: 1.2;">
                <?php
                $roles = ['director' => 'Director', 'admin' => 'Administrador', 'profesor' => 'Profesor', 'alumno' => 'Alumno'];
                echo e($roles[$u['rol']] ?? $u['rol']);
                ?>
              </div>
            </div>
            <!-- Avatar -->
            <div style="width: 36px; height: 36px; border-radius: 50%; overflow: hidden; border: 1px solid #e2e8f0; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              <?php if (!empty($u['foto'])): ?>
                <img src="<?php echo e($u['foto']); ?>" alt="Perfil" style="width: 100%; height: 100%; object-fit: cover;">
              <?php else: ?>
                <span style="font-size: 1.1rem; font-weight: 600; color: #197fe6;"><?php echo strtoupper(substr($u['nombre'], 0, 1)); ?></span>
              <?php endif; ?>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm mt-2" aria-labelledby="navbarDropdown" style="border-radius: 8px; border: 1px solid rgba(0,0,0,0.05); min-width: 200px; padding: 8px;">
            <a class="dropdown-item text-danger d-flex align-items-center" href="<?php echo BASE_URL; ?>auth/logout" style="border-radius: 6px; padding: 8px 12px;">
              <span class="material-symbols-outlined mr-2" style="font-size: 18px;">logout</span>
              Cerrar sesión
            </a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <!-- SIDEBAR -->
      <?php include dirname(__FILE__) . '/sidebar.php'; ?>

      <!-- CONTENIDO PRINCIPAL -->
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">