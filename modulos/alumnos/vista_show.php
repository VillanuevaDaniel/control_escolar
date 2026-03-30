<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>alumnos">Alumnos</a></li>
        <li class="breadcrumb-item active">Detalle</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">person</span>Expediente del Alumno</h1>
        <p><?php echo e($a['nombre'] . ' ' . $a['apellido_paterno'] . ' ' . $a['apellido_materno']); ?></p>
    </div>
    <div>
        <a href="<?php echo BASE_URL; ?>alumnos/edit/<?php echo $a['id_alumno']; ?>" class="btn btn-warning mr-2" style="border-radius:8px;">
            <span class="material-symbols-outlined mr-1" style="font-size:18px; vertical-align:middle;">edit</span> Editar
        </a>
        <a href="<?php echo BASE_URL; ?>alumnos" class="btn btn-outline-secondary" style="border-radius:8px;">
            <span class="material-symbols-outlined mr-1" style="font-size:18px; vertical-align:middle;">arrow_back</span> Volver
        </a>
    </div>
</div>

<div class="row">
    <!-- Foto + info básica -->
    <div class="col-md-3 mb-4">
        <div class="card text-center border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body py-4">
                <?php if ($a['ruta_foto']): ?>
                    <img src="<?php echo e($a['ruta_foto']); ?>" alt="foto"
                        style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid #eff6ff;">
                <?php else: ?>
                    <div class="avatar-circle mx-auto mb-0" style="width:90px;height:90px;font-size:2.2rem; background:#eff6ff; color:#197fe6; border:2px solid #d0dbe7;">
                        <?php echo strtoupper(substr($a['nombre'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
                <h6 class="font-weight-bold mt-3 mb-1" style="color:#0e141b;">
                    <?php echo e($a['nombre'] . ' ' . $a['apellido_paterno']); ?>
                </h6>
                <p class="text-muted small mb-2"><?php echo e($a['matricula']); ?></p>
                <?php
                $bc = array('Activo' => 'success', 'Inactivo' => 'secondary', 'Baja' => 'danger', 'Egresado' => 'info');
                $badge = isset($bc[$a['estado']]) ? $bc[$a['estado']] : 'secondary';
                ?>
                <span class="badge badge-<?php echo $badge; ?> px-3" style="border-radius:20px;"><?php echo e($a['estado']); ?></span>
            </div>
        </div>

        <?php if ($grupos_alumno): ?>
            <div class="card mt-3 border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-1" style="font-size:18px; vertical-align:middle;">groups</span> Grupos</div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($grupos_alumno as $g): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                            <span class="font-weight-600"><?php echo e($g['grupo']); ?></span>
                            <small class="text-muted"><?php echo e($g['ciclo']); ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <!-- Datos del alumno -->
    <div class="col-md-9">
        <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">badge</span> Datos Personales</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th class="text-muted small" style="width:40%;">CURP</th>
                                <td><?php echo e($a['curp']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted small">Sexo</th>
                                <td><?php echo e($a['genero']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted small">Nacimiento</th>
                                <td><?php echo fmt_fecha($a['fecha_nac']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted small">Procedencia</th>
                                <td><?php echo e($a['escuela_procedencia'] ?: '—'); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th class="text-muted small" style="width:40%;">Domicilio</th>
                                <td><?php echo e($a['direccion'] ?: '—'); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted small">Usuario</th>
                                <td><?php echo e($a['login_id']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted small">Registro</th>
                                <td><?php echo fmt_fecha($a['created_at']); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">family_restroom</span> Información del Tutor</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Nombre:</strong> <?php echo e($a['tutor_nombre'] ?: '—'); ?></p>
                        <p class="mb-0"><strong>Teléfono:</strong> <?php echo e($a['tutor_telefono'] ?: '—'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-0"><strong>Observaciones:</strong><br>
                            <span class="text-muted"><?php echo e($a['comentarios_familia'] ?: '—'); ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($calificaciones): ?>
            <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
                <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">assignment_turned_in</span> Calificaciones</div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="text-uppercase" style="font-size:11px; letter-spacing:1px; background:#f8fafc;">
                                <th class="pl-3">Materia</th>
                                <th>Grupo</th>
                                <th>Ciclo</th>
                                <th class="pr-3 text-right">Calificación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($calificaciones as $cal): ?>
                                <?php
                                $v = floatval($cal['calificacion']);
                                $cls = '';
                                if ($v >= 9) $cls = 'text-success';
                                elseif ($v >= 7.5) $cls = 'text-primary';
                                elseif ($v >= 6)   $cls = 'text-warning';
                                else               $cls = 'text-danger';
                                ?>
                                <tr>
                                    <td class="pl-3 font-weight-bold"><?php echo e($cal['materia']); ?></td>
                                    <td><?php echo e($cal['grupo']); ?></td>
                                    <td><?php echo e($cal['ciclo']); ?></td>
                                    <td class="pr-3 text-right font-weight-bold <?php echo $cls; ?>"><?php echo number_format($v, 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>