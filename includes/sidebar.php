<?php
// includes/sidebar.php — Menú lateral por áreas
$activo = isset($modulo_activo) ? $modulo_activo : '';
$u      = session_user();
$rol    = $u ? $u['rol'] : '';

/**
 * Ayuda: retorna 'active' si el módulo coincide.
 * Ahora recibe el módulo activo actual para evitar problemas de scope.
 */
function nav_active($modulo, $actual)
{
  return ($actual === $modulo) ? 'active' : '';
}

/**
 * Ayuda: genera un enlace de sidebar
 */
function nav_link($modulo, $label, $icon, $url, $actual)
{
  $cls = nav_active($modulo, $actual);
  echo '<a href="' . htmlspecialchars($url) . '" class="nav-link ' . $cls . '">'
    . '<span class="material-symbols-outlined mr-2" style="font-size:20px;">' . $icon . '</span>' . htmlspecialchars($label)
    . '</a>';
}
?>

<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse" style="padding-right: 0;">
  <div class="sidebar-sticky pt-3 pb-0">

    <!-- CONTENEDOR DE ENLACES (Flex 1) -->
    <div style="flex: 1; overflow-y: hidden;">
      <!-- GENERAL -->
      <ul class="nav flex-column">
        <?php nav_link('dashboard', 'Inicio', 'dashboard', BASE_URL . 'dashboard', $activo); ?>
      </ul>

      <?php if (puede_ver('alumnos') || puede_ver('docentes')): ?>
        <p class="sidebar-heading">Comunidad Escolar</p>
        <ul class="nav flex-column">
          <?php if (puede_ver('alumnos')): ?>
            <?php nav_link('alumnos', 'Alumnos', 'person', BASE_URL . 'alumnos', $activo); ?>
          <?php endif; ?>
          <?php if (puede_ver('docentes')): ?>
            <?php nav_link('docentes', 'Docentes', 'badge', BASE_URL . 'docentes', $activo); ?>
          <?php endif; ?>
        </ul>
      <?php endif; ?>

      <?php if (puede_ver('materias') || puede_ver('grupos') || puede_ver('calificaciones') || puede_ver('ciclos')): ?>
        <p class="sidebar-heading">Académico</p>
        <ul class="nav flex-column">
          <?php if (puede_ver('materias')): ?>
            <?php nav_link('materias', 'Materias', 'menu_book', BASE_URL . 'materias', $activo); ?>
          <?php endif; ?>
          <?php if (puede_ver('grupos')): ?>
            <?php nav_link('grupos', 'Grupos', 'groups', BASE_URL . 'grupos', $activo); ?>
          <?php endif; ?>
          <?php if (puede_ver('calificaciones')): ?>
            <?php nav_link('calificaciones', 'Calificaciones', 'assignment_turned_in', BASE_URL . 'calificaciones', $activo); ?>
          <?php endif; ?>
          <?php if (puede_ver('ciclos')): ?>
            <?php nav_link('ciclos', 'Ciclos Escolares', 'event_repeat', BASE_URL . 'ciclos', $activo); ?>
          <?php endif; ?>
        </ul>
      <?php endif; ?>

      <?php if (puede_ver('salones') || puede_ver('horarios')): ?>
        <p class="sidebar-heading">Infraestructura</p>
        <ul class="nav flex-column">
          <?php if (puede_ver('salones')): ?>
            <?php nav_link('salones', 'Salones', 'meeting_room', BASE_URL . 'salones', $activo); ?>
          <?php endif; ?>
          <?php if (puede_ver('horarios')): ?>
            <?php nav_link('horarios', 'Horarios', 'calendar_month', BASE_URL . 'horarios', $activo); ?>
          <?php endif; ?>
        </ul>
      <?php endif; ?>

      <?php if (puede_ver('reportes') || puede_ver('usuarios')): ?>
        <p class="sidebar-heading">Administración</p>
        <ul class="nav flex-column">
          <?php if (puede_ver('reportes')): ?>
            <?php nav_link('reportes', 'Reportes', 'analytics', BASE_URL . 'reportes', $activo); ?>
          <?php endif; ?>
          <?php if (puede_ver('usuarios')): ?>
            <?php nav_link('usuarios', 'Usuarios', 'admin_panel_settings', BASE_URL . 'usuarios', $activo); ?>
          <?php endif; ?>
        </ul>
      <?php endif; ?>

      <?php if ($rol === 'alumno'): ?>
        <p class="sidebar-heading">Mi Espacio</p>
        <ul class="nav flex-column">
          <?php nav_link('mi_horario', 'Mi Horario', 'calendar_month', BASE_URL . 'alumno/horario', $activo); ?>
          <?php nav_link('mis_calificaciones', 'Mis Calificaciones', 'grade', BASE_URL . 'alumno/calificaciones', $activo); ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</nav>