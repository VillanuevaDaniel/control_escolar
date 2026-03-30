<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>docentes">Docentes</a></li>
        <li class="breadcrumb-item active">Detalle</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">badge</span>Expediente del Docente</h1>
        <p><?php echo e($d['nombre_completo'] . ' ' . $d['apellido_paterno'] . ' ' . $d['apellido_materno']); ?></p>
    </div>
    <div>
        <a href="<?php echo BASE_URL; ?>docentes/edit/<?php echo $d['id_profesor']; ?>" class="btn btn-warning mr-2" style="border-radius:8px;">
            <span class="material-symbols-outlined mr-1" style="font-size:18px; vertical-align:middle;">edit</span> Editar
        </a>
        <a href="<?php echo BASE_URL; ?>docentes" class="btn btn-outline-secondary" style="border-radius:8px;">
            <span class="material-symbols-outlined mr-1" style="font-size:18px; vertical-align:middle;">arrow_back</span> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-center border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body py-4">
                <?php if ($d['ruta_foto']): ?>
                    <img src="<?php echo e($d['ruta_foto']); ?>" alt="" style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid #eff6ff;">
                <?php else: ?>
                    <div class="avatar-circle mx-auto" style="width:90px;height:90px;font-size:2rem; background:#eff6ff; color:#197fe6; border:2px solid #d0dbe7;">
                        <?php echo strtoupper(substr($d['nombre_completo'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
                <h6 class="font-weight-bold mt-3 mb-1" style="color:#0e141b;"><?php echo e($d['nombre_completo'] . ' ' . $d['apellido_paterno']); ?></h6>
                <p class="text-muted small mb-2">N° Empleado: <?php echo e($d['numero_empleado']); ?></p>
                <span class="badge badge-<?php echo $d['estado'] === 'Activo' ? 'success' : 'secondary'; ?> px-3" style="border-radius:20px;"><?php echo e($d['estado']); ?></span>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">badge</span> Datos Personales</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th class="text-muted small" style="width:40%;">CURP</th>
                                <td><?php echo e($d['curp']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted small">Email</th>
                                <td><?php echo e($d['email'] ?: '—'); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted small">Teléfono</th>
                                <td><?php echo e($d['telefono'] ?: '—'); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th class="text-muted small" style="width:40%;">Grado</th>
                                <td><?php echo e($d['grado_estudio'] ?: '—'); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted small">Domicilio</th>
                                <td><?php echo e($d['domicilio'] ?: '—'); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted small">Usuario</th>
                                <td><?php echo e($d['login_id']); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($horarios): ?>
            <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
                <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">calendar_month</span> Horario Asignado</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="text-uppercase" style="font-size:11px; letter-spacing:1px; background:#f8fafc;">
                                <th class="pl-3">Día</th>
                                <th>Hora</th>
                                <th>Materia</th>
                                <th>Grupo</th>
                                <th>Salón</th>
                                <th class="pr-3">Ciclo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($horarios as $h): ?>
                                <tr>
                                    <td class="pl-3 font-weight-bold text-primary"><?php echo e($h['dia']); ?></td>
                                    <td class="no-wrap"><?php echo substr($h['hora_inicio'], 0, 5) . ' – ' . substr($h['hora_fin'], 0, 5); ?></td>
                                    <td><?php echo e($h['materia']); ?></td>
                                    <td><?php echo e($h['grupo']); ?></td>
                                    <td><?php echo e($h['salon']); ?></td>
                                    <td class="pr-3 small text-muted"><?php echo e($h['ciclo']); ?></td>
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