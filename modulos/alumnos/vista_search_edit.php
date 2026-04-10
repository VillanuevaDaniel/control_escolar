<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>alumnos">Alumnos</a></li>
        <li class="breadcrumb-item active">Editar Alumno</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">edit_square</span>Editar Alumno</h1>
        <p>Selecciona un alumno para cargar y modificar su información</p>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
    <div class="card-body">
        <div class="autocomplete-wrap" style="position:relative;">
            <input type="text" id="alumno_search" class="form-control" placeholder="Escribe el nombre, matrícula o usuario del alumno..." autocomplete="off"
                   style="height:54px; border:2px solid #e2e8f0; border-radius:10px; font-size:15px; padding:12px 16px;">
            <div id="alumno_results" class="autocomplete-results"></div>
        </div>
    </div>
</div>

<!-- Formulario (Bloqueado inicialmente) -->
<div id="form_container" class="opacity-50" style="pointer-events: none; transition: all 0.3s ease;">
    <form id="edit_form" method="post" action="#" class="check-dirty">
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
                                <input type="text" name="matricula" id="f_matricula" class="form-control" maxlength="20" required style="border-radius:8px;">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">CURP <span class="text-danger">*</span></label>
                                <input type="text" name="curp" id="f_curp" class="form-control" style="text-transform:uppercase; border-radius:8px;" maxlength="18" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">Estado</label>
                                <select name="estado" id="f_estado" class="form-control" style="border-radius:8px;">
                                    <?php foreach (array('Activo', 'Inactivo', 'Baja', 'Egresado') as $opt): ?>
                                        <option value="<?php echo $opt; ?>"><?php echo $opt; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">Nombre(s) <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="f_nombre" class="form-control" maxlength="60" required style="border-radius:8px;">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">Apellido Paterno <span class="text-danger">*</span></label>
                                <input type="text" name="apellido_p" id="f_apellido_p" class="form-control" maxlength="60" required style="border-radius:8px;">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">Apellido Materno</label>
                                <input type="text" name="apellido_m" id="f_apellido_m" class="form-control" maxlength="60" style="border-radius:8px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">Sexo <span class="text-danger">*</span></label>
                                <select name="sexo" id="f_sexo" class="form-control" required style="border-radius:8px;">
                                    <option value="">Seleccionar...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nac" id="f_fecha_nac" class="form-control" style="border-radius:8px;">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">Escuela de Procedencia</label>
                                <input type="text" name="escuela_procedencia" id="f_escuela" class="form-control" maxlength="120" style="border-radius:8px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="small font-weight-bold">Domicilio</label>
                            <textarea name="direccion" id="f_direccion" class="form-control" rows="2" data-maxlength="200" style="border-radius:8px;"></textarea>
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
                                <input type="text" name="tutor_nombre" id="f_tutor_nombre" class="form-control" maxlength="120" style="border-radius:8px;">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="small font-weight-bold">Teléfono del Tutor</label>
                                <input type="text" name="tutor_telefono" id="f_tutor_telefono" class="form-control" maxlength="20" style="border-radius:8px;">
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label class="small font-weight-bold">Comentarios / Observaciones</label>
                            <textarea name="comentarios_familia" id="f_comentarios" class="form-control" rows="3" data-maxlength="500" style="border-radius:8px;"></textarea>
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
                            <span id="foto_icon" class="material-symbols-outlined text-muted" style="font-size:48px;">add_a_photo</span>
                            <img id="foto_img" src="" class="d-none" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <input type="file" id="foto_file" accept="image/*" class="d-none">
                        <input type="hidden" name="foto_base64" id="foto_base64">
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
                <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">save</span> Guardar Cambios
            </button>
        </div>
    </form>
</div>

<style>
.autocomplete-results { position:absolute; z-index:1050; width:100%; max-height:250px; overflow-y:auto; background:#fff; border:1px solid #e2e8f0; border-top:none; border-radius:0 0 10px 10px; box-shadow:0 4px 12px rgba(0,0,0,.1); display:none; }
.autocomplete-results .ac-item { padding:10px 16px; cursor:pointer; font-size:14px; border-bottom:1px solid #f1f5f9; transition:background .15s; }
.autocomplete-results .ac-item:hover { background:#e8f0fe; color:#1a56db; }
.autocomplete-results .ac-empty { padding:10px 16px; color:#94a3b8; font-size:14px; }
.opacity-50 { opacity: 0.2; }
</style>

<?php include 'includes/footer.php'; ?>

<script>
$(document).ready(function() {
    var items = <?php echo json_encode(array_values(array_map(function($a) {
        return ['id' => $a['id_alumno'], 'label' => $a['nombre'] . ' ' . $a['apellido_paterno'] . ' ' . $a['apellido_materno'] . ' (' . $a['matricula'] . ')', 'data' => $a];
    }, $alumnos)), JSON_HEX_TAG | JSON_HEX_APOS); ?> || [];

    var $input = $('#alumno_search');
    var $results = $('#alumno_results');

    $input.on('input', function() {
        var q = this.value.toLowerCase().trim();
        $results.empty();
        if (!q) { $results.hide(); resetForm(); return; }
        var matches = items.filter(function(i) { return i.label.toLowerCase().indexOf(q) !== -1; });
        if (!matches.length) {
            $results.html('<div class="ac-empty">No se encontraron coincidencias</div>').show();
            return;
        }
        matches.forEach(function(item) {
            $('<div class="ac-item"></div>').attr('data-id', item.id).text(item.label).appendTo($results);
        });
        $results.show();
    });

    $results.on('click', '.ac-item', function() {
        var id = $(this).data('id');
        var item = items.find(function(i) { return i.id == id; });
        $input.val($(this).text());
        $results.hide();
        if (!item) return;
        var data = item.data;

        $('#f_matricula').val(data.matricula);
        $('#f_curp').val(data.curp);
        $('#f_nombre').val(data.nombre);
        $('#f_apellido_p').val(data.apellido_paterno);
        $('#f_apellido_m').val(data.apellido_materno);
        $('#f_estado').val(data.estado == 1 ? 'Activo' : 'Inactivo');
        $('#f_sexo').val(data.genero == 'M' ? 'Masculino' : (data.genero == 'F' ? 'Femenino' : (data.genero || '')));
        $('#f_fecha_nac').val(data.fecha_nac || '');
        $('#f_escuela').val(data.escuela_procedencia || '');
        $('#f_direccion').val(data.domicilio || '');
        $('#f_tutor_nombre').val(data.nombre_tutor || '');
        $('#f_tutor_telefono').val(data.telefono_tutor || '');
        $('#f_comentarios').val(data.comentarios || '');

        if (data.ruta_foto) {
            $('#foto_img').attr('src', data.ruta_foto).removeClass('d-none');
            $('#foto_icon').addClass('d-none');
        } else {
            $('#foto_img').addClass('d-none');
            $('#foto_icon').removeClass('d-none');
        }

        $('#edit_form').attr('action', '<?php echo BASE_URL; ?>alumnos/edit/' + id);
        $('#form_container').removeClass('opacity-50').css('pointer-events', 'auto');
    });

    function resetForm() {
        $('#form_container').addClass('opacity-50').css('pointer-events', 'none');
        $('#edit_form')[0].reset();
        $('#foto_img').addClass('d-none').attr('src', '');
        $('#foto_icon').removeClass('d-none');
    }

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.autocomplete-wrap').length) $results.hide();
    });
});
</script>
