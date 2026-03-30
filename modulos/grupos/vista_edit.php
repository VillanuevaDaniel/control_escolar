<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>grupos">Grupos</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">edit</span>Editar Grupo</h1>
        <p>Grupo: <strong><?php echo e($datos['nombre']); ?></strong></p>
    </div>
</div>

<?php if ($errors): ?>
    <div class="alert alert-danger shadow-sm" style="border-radius:12px;">
        <div class="d-flex align-items-center mb-2">
            <span class="material-symbols-outlined mr-2">error</span>
            <strong>Corrige los siguientes errores:</strong>
        </div>
        <ul class="mb-0 pr-4">
            <?php foreach ($errors as $e): ?>
                <li><?php echo e($e); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white font-weight-bold pt-3 pb-2">
                <span class="material-symbols-outlined mr-2 text-warning" style="font-size:20px; vertical-align:middle;">edit_note</span>
                Modificar Datos del Grupo
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo BASE_URL; ?>grupos/edit/<?php echo $datos['id_grupo']; ?>" class="check-dirty">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Nombre del Grupo <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo e($datos['nombre']); ?>" maxlength="20" required style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Grado <span class="text-danger">*</span></label>
                            <select name="grado" class="form-control" required style="border-radius:8px;">
                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if ($datos['grado'] == $i) echo 'selected'; ?>><?php echo $i; ?>° Grado</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Sección <span class="text-danger">*</span></label>
                            <select name="seccion" class="form-control" required style="border-radius:8px;">
                                <?php foreach (array('A', 'B', 'C', 'D', 'E', 'F') as $s): ?>
                                    <option value="<?php echo $s; ?>" <?php if ($datos['seccion'] === $s) echo 'selected'; ?>>Sección <?php echo $s; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 form-group">
                            <label class="small font-weight-bold">Ciclo Escolar <span class="text-danger">*</span></label>
                            <select name="ciclo_id" class="form-control" required style="border-radius:8px;">
                                <?php foreach ($ciclos as $c): ?>
                                    <option value="<?php echo $c['id_grupo']; ?>" <?php if ($datos['ciclo_escolar'] == $c['id_grupo']) echo 'selected'; ?>><?php echo e($c['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Capacidad Máxima</label>
                            <input type="number" name="capacidad_max" class="form-control" value="<?php echo e($datos['capacidad']); ?>" min="1" max="100" style="border-radius:8px;">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold">Turno</label>
                        <div class="d-flex">
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="turnoM" name="turno" class="custom-control-input" value="Matutino" <?php echo (isset($datos['turno']) && $datos['turno'] == 'Matutino') ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="turnoM">Matutino</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="turnoV" name="turno" class="custom-control-input" value="Vespertino" <?php echo (isset($datos['turno']) && $datos['turno'] == 'Vespertino') ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="turnoV">Vespertino</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo BASE_URL; ?>grupos" class="btn btn-outline-secondary" style="border-radius:8px; padding:10px 20px;">
                            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">arrow_back</span> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding:10px 30px; font-weight:600;">
                            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">save</span> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card border-0 shadow-sm" style="border-radius:12px; background:#f8fafc;">
            <div class="card-body p-4 text-center">
                <span class="material-symbols-outlined mb-3 text-secondary" style="font-size:48px;">groups</span>
                <h5 class="font-weight-bold" style="color:#0e141b;">Resumen de Ocupación</h5>
                <p class="text-secondary small mb-3">Este grupo cuenta actualmente con:</p>
                <div class="h3 font-weight-bold text-primary mb-1"><?php echo (isset($datos['total_alumnos'])) ? $datos['total_alumnos'] : '0'; ?></div>
                <div class="text-uppercase small font-weight-bold text-muted mb-4" style="letter-spacing:1px;">Alumnos Inscritos</div>

                <div class="progress mb-2" style="height:8px; border-radius:10px; background:#e2e8f0;">
                    <?php
                    $total = (isset($datos['total_alumnos'])) ? $datos['total_alumnos'] : 0;
                    $capacidad = (isset($datos['capacidad']) && $datos['capacidad'] > 0) ? $datos['capacidad'] : 1;
                    $pct = ($total / $capacidad) * 100;
                    ?>
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $pct; ?>%; background:#197fe6; border-radius:10px;"></div>
                </div>
                <small class="text-muted"><?php echo round($pct); ?>% de la capacidad total ocupada</small>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>