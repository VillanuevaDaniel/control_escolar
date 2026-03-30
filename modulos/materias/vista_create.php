<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>materias">Materias</a></li>
        <li class="breadcrumb-item active">Nueva Materia</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">add_box</span>Nueva Materia</h1>
        <p>Agregue una nueva asignatura al catálogo</p>
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
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white font-weight-bold pt-3 pb-2">
                <span class="material-symbols-outlined mr-2 text-primary" style="font-size:20px; vertical-align:middle;">book</span>
                Datos de la Asignatura
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo BASE_URL; ?>materias/create" class="check-dirty">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Clave</label>
                            <input type="text" name="clave" class="form-control" value="<?php echo e($datos['clave']); ?>" maxlength="20" placeholder="Ej: MAT-101" style="border-radius:8px;">
                        </div>
                        <div class="col-md-8 form-group">
                            <label class="small font-weight-bold">Nombre de la Materia <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo e($datos['nombre']); ?>" maxlength="100" required style="border-radius:8px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Área / Departamento</label>
                            <input type="text" name="area" class="form-control" value="<?php echo e($datos['area']); ?>" maxlength="50" placeholder="Ej: Matemáticas" style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Horas Semanales</label>
                            <input type="number" name="horas" class="form-control" value="<?php echo e($datos['horas'] ?: 4); ?>" min="1" max="20" style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Grado Sugerido</label>
                            <select name="grado" class="form-control" style="border-radius:8px;">
                                <option value="">Cualquiera</option>
                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if ($datos['grado'] == $i) echo 'selected'; ?>><?php echo $i; ?>° Grado</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 form-group">
                            <label class="small font-weight-bold">Ciclo Escolar (Opcional)</label>
                            <select name="ciclo_id" class="form-control" style="border-radius:8px;">
                                <option value="">Sin ciclo específico</option>
                                <?php foreach ($ciclos as $c): ?>
                                    <option value="<?php echo $c['id_materia'] ?? $c['id']; ?>" <?php if ($datos['ciclo_id'] == ($c['id_materia'] ?? $c['id'])) echo 'selected'; ?>><?php echo e($c['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Estado</label>
                            <select name="estado" class="form-control" style="border-radius:8px;">
                                <option value="Activo" <?php if ($datos['estado'] === 'Activo') echo 'selected'; ?>>Activo</option>
                                <option value="Inactivo" <?php if ($datos['estado'] === 'Inactivo') echo 'selected'; ?>>Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4" style="border-style:dashed;">
                    <h6 class="font-weight-bold text-primary mb-3"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">schedule</span>Horario y Asignación</h6>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Docente</label>
                            <select name="docente_id" class="form-control select2" style="border-radius:8px;">
                                <option value="">Seleccionar Profesor...</option>
                                <?php foreach ($docentes as $d): ?>
                                    <option value="<?php echo $d['id_profesor']; ?>" <?php if ($datos['docente_id'] == $d['id_profesor']) echo 'selected'; ?>><?php echo e($d['nombre_completo']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Grupo</label>
                            <select name="grupo_id" class="form-control" style="border-radius:8px;">
                                <option value="">Seleccionar Grupo...</option>
                                <?php foreach ($grupos as $g): ?>
                                    <option value="<?php echo $g['id_grupo'] ?? $g['id']; ?>" <?php if ($datos['grupo_id'] == ($g['id_grupo'] ?? $g['id'])) echo 'selected'; ?>><?php echo e($g['nombre'] ?? ($g['grado'].$g['seccion'])); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Salón</label>
                            <select name="salon_id" class="form-control" style="border-radius:8px;">
                                <option value="">Seleccionar Salón...</option>
                                <?php foreach ($salones as $s): ?>
                                    <option value="<?php echo $s['id_salon']; ?>" <?php if ($datos['salon_id'] == $s['id_salon']) echo 'selected'; ?>><?php echo e($s['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Día</label>
                            <select name="dia" class="form-control" style="border-radius:8px;">
                                <option value="">Seleccionar Día...</option>
                                <?php foreach (array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes') as $d): ?>
                                    <option value="<?php echo $d; ?>" <?php if ($datos['dia'] === $d) echo 'selected'; ?>><?php echo $d; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Hora Inicio</label>
                            <input type="time" name="hora_inicio" class="form-control" value="<?php echo e($datos['hora_inicio']); ?>" style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Hora Fin</label>
                            <input type="time" name="hora_fin" class="form-control" value="<?php echo e($datos['hora_fin']); ?>" style="border-radius:8px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Descripción / Notas</label>
                        <textarea name="descripcion" class="form-control" rows="3" data-maxlength="300" style="border-radius:8px;"><?php echo e($datos['descripcion']); ?></textarea>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo BASE_URL; ?>materias" class="btn btn-outline-secondary" style="border-radius:8px; padding:10px 20px;">
                            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">arrow_back</span> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding:10px 30px; font-weight:600;">
                            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">save</span> Guardar Materia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>