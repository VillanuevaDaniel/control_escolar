<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>ciclos">Ciclos Escolares</a></li>
        <li class="breadcrumb-item active">Nuevo Ciclo</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">event_repeat</span>Nuevo Ciclo Escolar</h1>
        <p>Complete los datos para abrir un nuevo periodo académico (<span class="text-danger">*</span>)</p>
    </div>
</div>

<?php if ($errors): ?>
    <div class="alert alert-danger shadow-sm" style="border-radius:12px;">
        <div class="d-flex align-items-center mb-2">
            <span class="material-symbols-outlined mr-2">error</span>
            <strong>Corrige los siguientes errores:</strong>
        </div>
        <ul class="mb-0 pl-4">
            <?php foreach ($errors as $e): ?>
                <li><?php echo e($e); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="<?php echo BASE_URL; ?>ciclos/create" class="check-dirty">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">calendar_month</span> Datos del Ciclo Académico</div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold">Nombre descriptivo <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" value="<?php echo e($datos['nombre']); ?>" maxlength="50" placeholder="Ej: Ciclo Escolar 2025-2026" required style="border-radius:8px;">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Fecha de Inicio <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_inicio" class="form-control" value="<?php echo e($datos['fecha_inicio']); ?>" required style="border-radius:8px;">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Fecha de Término <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_fin" class="form-control" value="<?php echo e($datos['fecha_fin']); ?>" required style="border-radius:8px;">
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label class="small font-weight-bold">Estado Inicial</label>
                        <select name="estado" class="form-control" style="border-radius:8px;">
                            <option value="Proximo" <?php if ($datos['estado'] === 'Proximo') echo 'selected'; ?>>Próximo Periodo (Recomendado)</option>
                            <option value="Activo" <?php if ($datos['estado'] === 'Activo') echo 'selected'; ?>>Activo Inmediatamente</option>
                        </select>
                        <small class="text-muted mt-2 d-block">Si seleccionas "Activo Inmediatamente", el ciclo escolar actual pasará a estado cerrado automáticamente.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones -->
    <div class="row mb-5">
        <div class="col-md-8 d-flex justify-content-between">
            <a href="<?php echo BASE_URL; ?>ciclos" class="btn btn-outline-secondary" style="border-radius:8px; padding:10px 25px;">
                <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">arrow_back</span> Cancelar
            </a>
            <button type="submit" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding:10px 30px; font-weight:600;">
                <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">save</span> Guardar Ciclo
            </button>
        </div>
    </div>
</form>

<?php include 'includes/footer.php'; ?>
