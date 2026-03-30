<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>salones">Salones</a></li>
        <li class="breadcrumb-item active">Nuevo Salón</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">add_circle</span>Nuevo Salón</h1>
        <p>Registre un nuevo espacio físico en el plantel</p>
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
                <span class="material-symbols-outlined mr-2 text-primary" style="font-size:20px; vertical-align:middle;">meeting_room</span>
                Detalles del Espacio
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo BASE_URL; ?>salones/create" class="check-dirty">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Nombre del Salón <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo e($datos['nombre']); ?>" maxlength="80" required placeholder="Ej: Aula 101" style="border-radius:8px;">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Edificio / Ubicación</label>
                            <input type="text" name="edificio" class="form-control" value="<?php echo e($datos['edificio']); ?>" maxlength="80" placeholder="Ej: Edificio A" style="border-radius:8px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Tipo de Espacio</label>
                            <select name="tipo" class="form-control" style="border-radius:8px;">
                                <?php foreach (array('Aula', 'Laboratorio', 'Taller', 'Auditorio', 'Cancha', 'Otro') as $t): ?>
                                    <option value="<?php echo $t; ?>" <?php if ($datos['tipo'] === $t) echo 'selected'; ?>><?php echo $t; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Capacidad (Personas)</label>
                            <input type="number" name="capacidad" class="form-control" value="<?php echo e($datos['capacidad']); ?>" min="1" max="1000" style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Estado</label>
                            <select name="estado" class="form-control" style="border-radius:8px;">
                                <option value="Activo" <?php if ($datos['estado'] === 'Activo') echo 'selected'; ?>>Activo</option>
                                <option value="Inactivo" <?php if ($datos['estado'] === 'Inactivo') echo 'selected'; ?>>Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Descripción Adicional</label>
                        <textarea name="descripcion" class="form-control" rows="3" data-maxlength="200" style="border-radius:8px;" placeholder="Características especiales del salón..."><?php echo e($datos['descripcion']); ?></textarea>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo BASE_URL; ?>salones" class="btn btn-outline-secondary" style="border-radius:8px; padding:10px 20px;">
                            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">arrow_back</span> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding:10px 30px; font-weight:600;">
                            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">save</span> Guardar Salón
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>