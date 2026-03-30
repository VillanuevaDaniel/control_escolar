<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>grupos">Grupos</a></li>
        <li class="breadcrumb-item active">Nuevo Grupo</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">group_add</span>Nuevo Grupo</h1>
        <p>Complete la información del nuevo grupo escolar</p>
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
                <span class="material-symbols-outlined mr-2 text-primary" style="font-size:20px; vertical-align:middle;">info</span>
                Información del Grupo
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo BASE_URL; ?>grupos/create" class="check-dirty">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Nombre del Grupo <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo e($datos['nombre']); ?>" maxlength="20" placeholder="Ej: 1A" required style="border-radius:8px;">
                            <small class="text-muted">Nombre corto identificador.</small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Grado <span class="text-danger">*</span></label>
                            <select name="grado" class="form-control" required style="border-radius:8px;">
                                <option value="">Seleccionar...</option>
                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if ($datos['grado'] == $i) echo 'selected'; ?>><?php echo $i; ?>° Grado</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Sección <span class="text-danger">*</span></label>
                            <select name="seccion" class="form-control" required style="border-radius:8px;">
                                <option value="">Seleccionar...</option>
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
                                <option value="">Seleccionar...</option>
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
                                <input type="radio" id="turnoM" name="turno" class="custom-control-input" value="Matutino" <?php echo ($datos['turno'] == 'Matutino') ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="turnoM">Matutino</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="turnoV" name="turno" class="custom-control-input" value="Vespertino" <?php echo ($datos['turno'] == 'Vespertino') ? 'checked' : ''; ?>>
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
                            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">save</span> Guardar Grupo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>