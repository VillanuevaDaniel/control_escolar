<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>docentes">Docentes</a></li>
        <li class="breadcrumb-item active">Editar Docente</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">edit_square</span>Editar Docente</h1>
        <p>Selecciona un docente para cargar y modificar su información</p>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
    <div class="card-body">
        <div class="autocomplete-wrap" style="position:relative;">
            <input type="text" id="docente_search" class="form-control" placeholder="Escribe el nombre o número de empleado..." autocomplete="off"
                   style="height:54px; border:2px solid #e2e8f0; border-radius:10px; font-size:15px; padding:12px 16px;">
            <div id="docente_results" class="autocomplete-results"></div>
        </div>
    </div>
</div>

<!-- Formulario (Bloqueado inicialmente) -->
<div id="form_container" class="opacity-50" style="pointer-events: none; transition: all 0.3s ease;">
    <form id="edit_form" method="post" action="#" class="check-dirty">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4 border-0 shadow-sm" style="border-radius:12px;">
                    <div class="card-header bg-white font-weight-bold">Datos del Docente</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="small font-weight-bold">N° Empleado <span class="text-danger">*</span></label>
                                <input type="text" name="num_empleado" id="f_num_empleado" class="form-control" required style="border-radius:8px;">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="small font-weight-bold">CURP <span class="text-danger">*</span></label>
                                <input type="text" name="curp" id="f_curp" class="form-control" style="text-transform:uppercase; border-radius:8px;" maxlength="18" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">Nombre(s) <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="f_nombre" class="form-control" required style="border-radius:8px;">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">Apellido Paterno <span class="text-danger">*</span></label>
                                <input type="text" name="apellido_p" id="f_apellido_p" class="form-control" required style="border-radius:8px;">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">Apellido Materno</label>
                                <input type="text" name="apellido_m" id="f_apellido_m" class="form-control" style="border-radius:8px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="small font-weight-bold">Grado Académico</label>
                                <input type="text" name="grado_estudio" id="f_grado" class="form-control" style="border-radius:8px;">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="small font-weight-bold">Teléfono</label>
                                <input type="text" name="telefono" id="f_telefono" class="form-control" style="border-radius:8px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="small font-weight-bold">Domicilio</label>
                            <textarea name="domicilio" id="f_domicilio" class="form-control" rows="2" style="border-radius:8px;"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="small font-weight-bold">Estado</label>
                            <select name="estado" id="f_estado" class="form-control" style="border-radius:8px;">
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-5">
            <a href="<?php echo BASE_URL; ?>docentes" class="btn btn-outline-secondary" style="border-radius:8px; padding:10px 25px;">Cancelar</a>
            <button type="submit" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding:10px 30px; font-weight:600;">Guardar Cambios</button>
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
    var items = <?php echo json_encode(array_values(array_map(function($d) {
        return ['id' => $d['id_profesor'], 'label' => $d['nombre_completo'] . ' (' . $d['numero_empleado'] . ')', 'data' => $d];
    }, $docentes)), JSON_HEX_TAG | JSON_HEX_APOS); ?> || [];

    var $input = $('#docente_search');
    var $results = $('#docente_results');

    $input.on('input', function() {
        var q = this.value.toLowerCase().trim();
        $results.empty();
        if (!q) { $results.hide(); $('#form_container').addClass('opacity-50').css('pointer-events', 'none'); return; }
        var matches = items.filter(function(i) { return i.label.toLowerCase().indexOf(q) !== -1; });
        if (!matches.length) {
            $results.html('<div class="ac-empty">Sin resultados</div>').show();
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
        var d = item.data;

        var partes = d.nombre_completo.split(' ');
        $('#f_nombre').val(partes[0] || '');
        $('#f_apellido_p').val(partes[1] || '');
        $('#f_apellido_m').val(partes.slice(2).join(' ') || '');

        $('#f_num_empleado').val(d.numero_empleado);
        $('#f_curp').val(d.curp);
        $('#f_grado').val(d.grado_academico);
        $('#f_telefono').val(d.telefono);
        $('#f_domicilio').val(d.domicilio);
        $('#f_estado').val(d.estado == 1 ? 'Activo' : 'Inactivo');

        $('#edit_form').attr('action', '<?php echo BASE_URL; ?>docentes/edit/' + id);
        $('#form_container').removeClass('opacity-50').css('pointer-events', 'auto');
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.autocomplete-wrap').length) $results.hide();
    });
});
</script>
