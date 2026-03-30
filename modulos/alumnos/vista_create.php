<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>alumnos">Alumnos</a></li>
        <li class="breadcrumb-item active">Nuevo Alumno</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">person_add</span>Nuevo Alumno</h1>
        <p>Complete todos los campos requeridos (<span class="required-star text-danger">*</span>)</p>
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

<form method="post" action="<?php echo BASE_URL; ?>alumnos/create" class="check-dirty">
    <div class="row">
        <!-- ── COLUMNA IZQUIERDA ── -->
        <div class="col-md-8">

            <!-- Datos personales -->
            <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">badge</span> Datos Personales</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Matrícula <span class="text-danger">*</span></label>
                            <input type="text" name="matricula" class="form-control"
                                value="<?php echo e($datos['matricula']); ?>" maxlength="20" required style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">CURP <span class="text-danger">*</span></label>
                            <input type="text" name="curp" class="form-control" style="text-transform:uppercase; border-radius:8px;"
                                value="<?php echo e($datos['curp']); ?>" maxlength="18" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Estado</label>
                            <select name="estado" class="form-control" style="border-radius:8px;">
                                <?php foreach (array('Activo', 'Inactivo', 'Baja', 'Egresado') as $opt): ?>
                                    <option value="<?php echo $opt; ?>" <?php if ($datos['estado'] === $opt) echo 'selected'; ?>><?php echo $opt; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Nombre(s) <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control"
                                value="<?php echo e($datos['nombre']); ?>" maxlength="60" required style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Apellido Paterno <span class="text-danger">*</span></label>
                            <input type="text" name="apellido_p" class="form-control"
                                value="<?php echo e($datos['apellido_paterno']); ?>" maxlength="60" required style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Apellido Materno</label>
                            <input type="text" name="apellido_m" class="form-control"
                                value="<?php echo e($datos['apellido_materno']); ?>" maxlength="60" style="border-radius:8px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Sexo <span class="text-danger">*</span></label>
                            <select name="sexo" class="form-control" required style="border-radius:8px;">
                                <option value="">Seleccionar...</option>
                                <?php foreach (array('Masculino', 'Femenino', 'Otro') as $opt): ?>
                                    <option value="<?php echo $opt; ?>" <?php if ($datos['genero'] === $opt) echo 'selected'; ?>><?php echo $opt; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nac" class="form-control"
                                value="<?php echo e($datos['fecha_nac']); ?>" style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Escuela de Procedencia</label>
                            <input type="text" name="escuela_procedencia" class="form-control"
                                value="<?php echo e($datos['escuela_procedencia']); ?>" maxlength="120" style="border-radius:8px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Domicilio</label>
                        <textarea name="direccion" class="form-control" rows="2"
                            data-maxlength="200" style="border-radius:8px;"><?php echo e($datos['direccion']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Grupo Inicial</label>
                        <select name="grupo_id" class="form-control" style="border-radius:8px;">
                            <option value="">Sin asignar</option>
                            <?php foreach ($grupos as $g): ?>
                                <option value="<?php echo $g['id_alumno']; ?>" <?php if ($datos['grupo_id'] == $g['id_alumno']) echo 'selected'; ?>>
                                    <?php echo e($g['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Se asignará al ciclo escolar activo automáticamente.</small>
                    </div>
                </div>
            </div>

            <!-- Tutor -->
            <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">family_restroom</span> Información del Tutor</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Nombre del Tutor</label>
                            <input type="text" name="tutor_nombre" class="form-control"
                                value="<?php echo e($datos['tutor_nombre']); ?>" maxlength="120" style="border-radius:8px;">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Teléfono del Tutor</label>
                            <input type="text" name="tutor_telefono" class="form-control"
                                value="<?php echo e($datos['tutor_telefono']); ?>" maxlength="20" style="border-radius:8px;">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Comentarios / Observaciones</label>
                        <textarea name="comentarios_familia" class="form-control" rows="3"
                            data-maxlength="500" style="border-radius:8px;"><?php echo e($datos['comentarios_familia']); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Acceso -->
            <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">key</span> Credenciales de Acceso</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Usuario (login) <span class="text-danger">*</span></label>
                            <input type="text" name="login_id" class="form-control"
                                value="<?php echo e($datos['login_id']); ?>" maxlength="30" required style="border-radius:8px;">
                            <small class="text-muted">Ej: MAT2025001</small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" maxlength="100" required style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <input type="password" name="password2" class="form-control" maxlength="100" required style="border-radius:8px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── COLUMNA DERECHA: FOTO ── -->
        <div class="col-md-4">
            <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">photo_camera</span> Foto del Alumno</div>
                <div class="card-body text-center">
                    <div id="foto-preview-wrap" class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width:150px; height:150px; border:2px dashed #cbd5e1; border-radius:12px; cursor:pointer; overflow:hidden; background:#f8fafc;">
                        <span class="material-symbols-outlined text-muted" style="font-size:48px;">add_a_photo</span>
                    </div>
                    <small class="text-muted d-block mb-3">Clic en el recuadro para subir foto (Formatos JPG, PNG. Máx 2MB)</small>
                    <input type="file" id="foto_file" accept="image/*" class="d-none">
                    <input type="hidden" name="foto_base64" id="foto_base64" value="">
                    <button type="button" id="btn-quitar-foto" class="btn btn-sm btn-outline-danger d-none" style="border-radius:20px;">Quitar foto</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones -->
    <div class="d-flex justify-content-between mb-5">
        <a href="<?php echo BASE_URL; ?>alumnos" class="btn btn-outline-secondary" style="border-radius:8px; padding:10px 25px;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">arrow_back</span> Cancelar
        </a>
        <button type="submit" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding:10px 30px; font-weight:600;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">save</span> Guardar Alumno
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrap = document.getElementById('foto-preview-wrap');
        const fileInput = document.getElementById('foto_file');
        const base64Input = document.getElementById('foto_base64');
        const btnQuitar = document.getElementById('btn-quitar-foto');

        wrap.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('La imagen es muy grande (máx 2MB)');
                    this.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    wrap.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
                    base64Input.value = e.target.result;
                    btnQuitar.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        });

        btnQuitar.addEventListener('click', function() {
            wrap.innerHTML = '<span class="material-symbols-outlined text-muted" style="font-size:48px;">add_a_photo</span>';
            base64Input.value = '';
            fileInput.value = '';
            this.classList.add('d-none');
        });
    });
</script>

<?php include 'includes/footer.php'; ?>