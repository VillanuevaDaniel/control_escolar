<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>horarios">Horarios</a></li>
        <li class="breadcrumb-item active">Agregar Clase</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">more_time</span>Agregar Clase</h1>
        <p>Asigne una nueva materia y horario a un grupo</p>
    </div>
</div>

<?php if ($errors && !$warnings): ?>
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

<?php if ($warnings): ?>
    <div class="alert alert-warning shadow-sm" style="border-radius:12px; border-left: 5px solid #ffa000;">
        <div class="d-flex align-items-center mb-2">
            <span class="material-symbols-outlined mr-2 text-warning">warning</span>
            <strong class="text-dark">Conflictos de Horario Detectados:</strong>
        </div>
        <ul class="mb-2 pr-4 text-dark">
            <?php foreach ($errors as $e): ?>
                <li><?php echo e($e); ?></li>
            <?php endforeach; ?>
        </ul>
        <div class="mt-3 p-2 bg-white-50 shadow-sm" style="border-radius:8px; background: rgba(255,255,255,0.5);">
            <p class="small mb-2 font-weight-bold italic">¿Deseas guardar la clase a pesar de estos traslapes?</p>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-9">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white font-weight-bold pt-3 pb-2">
                <span class="material-symbols-outlined mr-2 text-primary" style="font-size:20px; vertical-align:middle;">calendar_view_day</span>
                Configuración de la Sesión
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo BASE_URL; ?>horarios/create" class="check-dirty">

                    <?php if ($warnings): ?>
                        <div class="custom-control custom-checkbox mb-4 p-3 bg-warning-light" style="border:1px dashed #ffa000; border-radius:8px; background:#fffbf0;">
                            <input type="checkbox" name="forzar" id="forzar" value="1" class="custom-control-input">
                            <label for="forzar" class="custom-control-label font-weight-bold text-dark" style="cursor:pointer;">
                                Sí, autorizo guardar con conflictos (ignorar advertencias)
                            </label>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Asignatura <span class="text-danger">*</span></label>
                            <select name="materia_id" class="form-control select2" required style="border-radius:8px;">
                                <option value="">Seleccionar Materia...</option>
                                <?php foreach ($materias as $m): ?>
                                    <option value="<?php echo $m['id_materia']; ?>" <?php if ($datos['materia_id'] == $m['id_materia']) echo 'selected'; ?>><?php echo e($m['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Docente <span class="text-danger">*</span></label>
                            <select name="docente_id" class="form-control select2" required style="border-radius:8px;">
                                <option value="">Seleccionar Profesor...</option>
                                <?php foreach ($docentes as $d): ?>
                                    <option value="<?php echo $d['id_profesor']; ?>" <?php if ($datos['docente_id'] == $d['id_profesor']) echo 'selected'; ?>><?php echo e($d['nombre_completo']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Grupo <span class="text-danger">*</span></label>
                            <select name="grupo_id" class="form-control" required style="border-radius:8px;">
                                <option value="">Seleccionar Grupo...</option>
                                <?php foreach ($grupos as $g): ?>
                                    <option value="<?php echo $g['id_grupo']; ?>" <?php if ($datos['grupo_id'] == $g['id_grupo']) echo 'selected'; ?>><?php echo e($g['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Salón <span class="text-danger">*</span></label>
                            <select name="salon_id" class="form-control" required style="border-radius:8px;">
                                <option value="">Seleccionar Salón...</option>
                                <?php foreach ($salones as $s): ?>
                                    <option value="<?php echo $s['id_salon']; ?>" <?php if ($datos['salon_id'] == $s['id_salon']) echo 'selected'; ?>><?php echo e($s['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4" style="border-style:dashed;">

                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Ciclo <span class="text-danger">*</span></label>
                            <select name="ciclo_id" class="form-control" required style="border-radius:8px;">
                                <?php foreach ($ciclos as $c): ?>
                                    <option value="<?php echo $c['id']; ?>" <?php if ($datos['ciclo_id'] == $c['id']) echo 'selected'; ?>><?php echo e($c['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Día <span class="text-danger">*</span></label>
                            <select name="dia" class="form-control" required style="border-radius:8px;">
                                <?php foreach (array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes') as $d): ?>
                                    <option value="<?php echo $d; ?>" <?php if ($datos['dia'] === $d) echo 'selected'; ?>><?php echo $d; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Hora Inicio <span class="text-danger">*</span></label>
                            <input type="time" name="hora_inicio" class="form-control" value="<?php echo e($datos['hora_inicio']); ?>" required style="border-radius:8px;">
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Hora Fin <span class="text-danger">*</span></label>
                            <input type="time" name="hora_fin" class="form-control" value="<?php echo e($datos['hora_fin']); ?>" required style="border-radius:8px;">
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between border-top pt-4">
                        <a href="<?php echo BASE_URL; ?>horarios" class="btn btn-outline-secondary" style="border-radius:8px; padding:10px 25px;">
                            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">arrow_back</span> Regresar
                        </a>
                        <button type="submit" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding:10px 40px; font-weight:600; box-shadow: 0 4px 6px rgba(25, 127, 230, 0.2);">
                            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">save</span> Guardar Clase
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>