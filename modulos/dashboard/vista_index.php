<?php
$page_title    = 'Dashboard';
$modulo_activo = 'dashboard';
include 'includes/header.php';
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><span class="material-symbols-outlined mr-1" style="font-size:18px;">home</span> Inicio</li>
    </ol>
</nav>

<!-- Page header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">dashboard</span>Panel Principal</h1>
    </div>
</div>

<?php if ($u['rol'] === 'director' || $u['rol'] === 'admin'): ?>
    <!-- ══════════ ACCIONES RÁPIDAS ══════════ -->
    <div class="card mb-4">
        <div class="card-header bg-white">Acciones Rápidas</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6 col-md-3 col-lg-2 mb-3">
                    <a href="<?php echo BASE_URL; ?>alumnos/create" class="quick-card">
                        <span class="material-symbols-outlined mb-2" style="font-size:32px;">person_add</span>
                        <span>Nuevo Alumno</span>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-2 mb-3">
                    <a href="<?php echo BASE_URL; ?>docentes/create" class="quick-card">
                        <span class="material-symbols-outlined mb-2" style="font-size:32px;">person_add</span>
                        <span>Nuevo Docente</span>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-2 mb-3">
                    <a href="<?php echo BASE_URL; ?>grupos/create" class="quick-card">
                        <span class="material-symbols-outlined mb-2" style="font-size:32px;">group_add</span>
                        <span>Nuevo Grupo</span>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-2 mb-3">
                    <a href="<?php echo BASE_URL; ?>horarios/create" class="quick-card">
                        <span class="material-symbols-outlined mb-2" style="font-size:32px;">more_time</span>
                        <span>Agregar Horario</span>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-2 mb-3">
                    <a href="<?php echo BASE_URL; ?>calificaciones" class="quick-card">
                        <span class="material-symbols-outlined mb-2" style="font-size:32px;">assignment_turned_in</span>
                        <span>Calificaciones</span>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-2 mb-3">
                    <a href="<?php echo BASE_URL; ?>reportes" class="quick-card">
                        <span class="material-symbols-outlined mb-2" style="font-size:32px;">analytics</span>
                        <span>Reportes</span>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-2 mb-3">
                    <a href="<?php echo BASE_URL; ?>usuarios" class="quick-card">
                        <span class="material-symbols-outlined mb-2" style="font-size:32px;">manage_accounts</span>
                        <span>Usuarios</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($u['rol'] === 'profesor'): ?>
    <!-- ══════════ PANEL PROFESOR ══════════ -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <span class="material-symbols-outlined mr-2 text-primary" style="font-size:20px;">calendar_today</span>Mi Horario de Hoy
                    <span class="float-right text-muted small"><?php echo date('d/m/Y'); ?></span>
                </div>
                <div class="card-body p-0">
                    <?php if ($mis_horarios_hoy): ?>
                        <div class="table-responsive border-0">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Hora</th>
                                        <th>Materia</th>
                                        <th>Grupo</th>
                                        <th>Salón</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mis_horarios_hoy as $h): ?>
                                        <tr>
                                            <td class="no-wrap">
                                                <?php echo substr($h['hora_inicio'], 0, 5); ?> – <?php echo substr($h['hora_fin'], 0, 5); ?>
                                            </td>
                                            <td><?php echo e($h['materia']); ?></td>
                                            <td><?php echo e($h['grupo']); ?></td>
                                            <td><?php echo e($h['salon']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">
                            <span class="material-symbols-outlined mb-2" style="font-size:48px; opacity:0.3;">event_busy</span>
                            <p class="mt-2 mb-0">No tienes clases programadas hoy.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <span class="material-symbols-outlined mr-2 text-warning" style="font-size:20px;">bolt</span>Acceso Rápido
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <a href="<?php echo BASE_URL; ?>calificaciones" class="quick-card">
                                <span class="material-symbols-outlined mb-2">edit_note</span>
                                <span>Capturar Calificaciones</span>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="<?php echo BASE_URL; ?>horarios" class="quick-card">
                                <span class="material-symbols-outlined mb-2">calendar_month</span>
                                <span>Mi Horario Completo</span>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="<?php echo BASE_URL; ?>grupos" class="quick-card">
                                <span class="material-symbols-outlined mb-2">groups</span>
                                <span>Mis Grupos</span>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="<?php echo BASE_URL; ?>reportes" class="quick-card">
                                <span class="material-symbols-outlined mb-2">description</span>
                                <span>Reportes</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($u['rol'] === 'alumno'): ?>
    <!-- ══════════ PANEL ALUMNO ══════════ -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-center shadow-none border">
                <div class="card-body py-4">
                    <div class="avatar-circle mx-auto mb-3" style="width:80px; height:80px; font-size:2rem; background:#eff6ff; color:#197fe6; border:2px solid #d0dbe7;">
                        <?php echo strtoupper(substr($u['nombre'], 0, 1)); ?>
                    </div>
                    <h5 class="font-weight-bold mb-1" style="color:#0e141b;"><?php echo e($u['nombre']); ?></h5>
                    <p class="text-secondary small mb-3">Alumno del Plantel</p>
                    <span class="badge badge-primary px-3 py-2" style="background:#197fe6; border-radius:30px;">Estado: Activo</span>
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white"><span class="material-symbols-outlined mr-2 text-warning" style="font-size:20px;">bolt</span>Mi Espacio Educativo</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <a href="<?php echo BASE_URL; ?>alumno/horario" class="quick-card">
                                <span class="material-symbols-outlined mb-2" style="font-size:32px;">calendar_month</span>
                                <span>Mi Horario</span>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="<?php echo BASE_URL; ?>alumno/calificaciones" class="quick-card">
                                <span class="material-symbols-outlined mb-2" style="font-size:32px;">grade</span>
                                <span>Mis Calificaciones</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>