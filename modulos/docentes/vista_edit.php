<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>docentes">Docentes</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">edit</span>Editar Docente</h1>
        <p><?php echo e($datos['nombre_completo'] . ' ' . $datos['apellido_paterno'] . ' ' . $datos['apellido_materno']); ?></p>
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

<form method="post" action="<?php echo BASE_URL; ?>docentes/edit/<?php echo $datos['id_profesor']; ?>" class="check-dirty">
    <div class="row">
        <!-- ── COLUMNA IZQUIERDA ── -->
        <div class="col-md-8">

            <!-- Datos generales -->
            <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">badge</span> Datos del Docente</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">N° Empleado <span class="text-danger">*</span></label>
                            <input type="text" name="num_empleado" class="form-control"
                                value="<?php echo e($datos['numero_empleado']); ?>" maxlength="20" required style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">CURP <span class="text-danger">*</span></label>
                            <input type="text" name="curp" class="form-control" style="text-transform:uppercase; border-radius:8px;"
                                value="<?php echo e($datos['curp']); ?>" maxlength="18" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Estado</label>
                            <select name="estado" class="form-control" style="border-radius:8px;">
                                <option value="Activo" <?php if ($datos['estado'] === 'Activo') echo 'selected'; ?>>Activo</option>
                                <option value="Inactivo" <?php if ($datos['estado'] === 'Inactivo') echo 'selected'; ?>>Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Nombre(s) <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control"
                                value="<?php echo e($datos['nombre_completo']); ?>" maxlength="60" required style="border-radius:8px;">
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
                            <label class="small font-weight-bold">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="<?php echo e($datos['email']); ?>" maxlength="120" style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Teléfono</label>
                            <input type="text" name="telefono" class="form-control"
                                value="<?php echo e($datos['telefono']); ?>" maxlength="20" style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Grado de Estudios</label>
                            <input type="text" name="grado_estudio" class="form-control"
                                value="<?php echo e($datos['grado_estudio']); ?>" maxlength="80" style="border-radius:8px;">
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Domicilio</label>
                        <textarea name="domicilio" class="form-control" rows="2"
                            data-maxlength="200" style="border-radius:8px;"><?php echo e($datos['domicilio']); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Acceso -->
            <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">key</span> Credenciales de Acceso (dejar en blanco para no cambiar)</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Usuario</label>
                            <input type="text" name="login_id" class="form-control"
                                value="<?php echo e($datos['login_id']); ?>" maxlength="30" style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Nueva Contraseña</label>
                            <input type="password" name="password" class="form-control" maxlength="100" placeholder="Sin cambios" style="border-radius:8px;">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password2" class="form-control" maxlength="100" placeholder="Sin cambios" style="border-radius:8px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── COLUMNA DERECHA: FOTO ── -->
        <div class="col-md-4">
            <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header bg-white font-weight-bold"><span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">photo_camera</span> Foto del Docente</div>
                <div class="card-body text-center">
                    <div id="foto-preview-wrap" class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width:150px; height:150px; border:2px dashed #cbd5e1; border-radius:12px; cursor:pointer; overflow:hidden; background:#f8fafc;">
                        <?php if ($datos['ruta_foto']): ?>
                            <img src="<?php echo e($datos['ruta_foto']); ?>" style="width:100%; height:100%; object-fit:cover;">
                        <?php else: ?>
                            <span class="material-symbols-outlined text-muted" style="font-size:48px;">add_a_photo</span>
                        <?php endif; ?>
                    </div>
                    <small class="text-muted d-block mb-3">Clic para cambiar foto</small>
                    <input type="file" id="foto_file" accept="image/*" class="d-none">
                    <input type="hidden" name="foto_base64" id="foto_base64" value="">
                    <button type="button" id="btn-quitar-foto" class="btn btn-sm btn-outline-danger <?php echo $datos['ruta_foto'] ? '' : 'd-none'; ?>" style="border-radius:20px;">Quitar foto</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones -->
    <div class="d-flex justify-content-between mb-5">
        <a href="<?php echo BASE_URL; ?>docentes" class="btn btn-outline-secondary" style="border-radius:8px; padding:10px 25px;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">arrow_back</span> Cancelar
        </a>
        <button type="submit" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding:10px 30px; font-weight:600;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">save</span> Guardar Cambios
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