<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>materias">Materias</a></li>
        <li class="breadcrumb-item active">Editar Materia</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">edit_note</span>Editar Materia</h1>
        <p>Selecciona una materia para modificar su información</p>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
    <div class="card-body">
        <div class="autocomplete-wrap" style="position:relative;">
            <input type="text" id="materia_search" class="form-control" placeholder="Escribe el nombre de la materia o clave..." autocomplete="off"
                   style="height:54px; border:2px solid #e2e8f0; border-radius:10px; font-size:15px; padding:12px 16px;">
            <div id="materia_results" class="autocomplete-results"></div>
        </div>
    </div>
</div>

<div id="form_container" class="opacity-50" style="pointer-events: none;">
    <form id="edit_form" method="post" action="#">
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="small font-weight-bold">Nombre de la Materia</label>
                        <input type="text" name="nombre" id="f_nombre" class="form-control" required style="border-radius:8px;">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="small font-weight-bold">Horas/Cupo</label>
                        <input type="number" name="horas" id="f_horas" class="form-control" style="border-radius:8px;">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="small font-weight-bold">Docente</label>
                        <select name="docente_id" id="f_docente" class="form-control">
                            <option value="">No asignado</option>
                            <?php foreach ($docentes as $d): ?>
                                <option value="<?php echo $d['id_profesor']; ?>"><?php echo e($d['nombre_completo']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="small font-weight-bold">Salón</label>
                        <select name="salon_id" id="f_salon" class="form-control">
                            <option value="">No asignado</option>
                            <?php foreach ($salones as $s): ?>
                                <option value="<?php echo $s['id_salon']; ?>"><?php echo e($s['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="small font-weight-bold">Grupo</label>
                        <select name="grupo_id" id="f_grupo" class="form-control">
                            <option value="">No asignado</option>
                            <?php foreach ($grupos as $g): ?>
                                <option value="<?php echo $g['id_grupo']; ?>"><?php echo e($g['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="small font-weight-bold">Día</label>
                        <select name="dia" id="f_dia" class="form-control">
                             <?php foreach(['LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO'] as $dia): ?>
                                <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                             <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="small font-weight-bold">Hr Inicio</label>
                        <input type="time" name="hora_inicio" id="f_h_inicio" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="small font-weight-bold">Hr Fin</label>
                        <input type="time" name="hora_fin" id="f_h_fin" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between mb-5">
            <a href="<?php echo BASE_URL; ?>materias" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
    var items = <?php echo json_encode(array_values(array_map(function($m) {
        return ['id' => $m['id_materia'], 'label' => $m['nombre'] . ' (' . $m['clave'] . ')', 'data' => $m];
    }, $materias)), JSON_HEX_TAG | JSON_HEX_APOS); ?> || [];

    var $input = $('#materia_search');
    var $results = $('#materia_results');

    $input.on('input', function() {
        var q = this.value.toLowerCase().trim();
        $results.empty();
        if (!q) { $results.hide(); return; }
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
        var m = item.data;
        $('#f_nombre').val(m.nombre);
        $('#f_horas').val(m.horas);
        $('#f_docente').val(m.id_profesor);
        $('#f_salon').val(m.id_salon);
        $('#f_grupo').val(m.id_grupo);
        $('#f_dia').val(m.dia);
        $('#f_h_inicio').val(m.hora_inicio);
        $('#f_h_fin').val(m.hora_fin);
        $('#edit_form').attr('action', '<?php echo BASE_URL; ?>materias/edit/' + id);
        $('#form_container').removeClass('opacity-50').css('pointer-events', 'auto');
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.autocomplete-wrap').length) $results.hide();
    });
});
</script>
