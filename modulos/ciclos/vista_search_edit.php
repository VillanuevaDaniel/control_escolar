<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>ciclos">Ciclos Escolares</a></li>
        <li class="breadcrumb-item active">Editar Ciclo</li>
    </ol>
</nav>

<div class="page-header mb-4">
    <h1><span class="material-symbols-outlined mr-2">edit_calendar</span>Editar Ciclo Escolar</h1>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
    <div class="card-body">
        <div class="autocomplete-wrap" style="position:relative;">
            <input type="text" id="ciclo_search" class="form-control" placeholder="Escribe el nombre del ciclo..." autocomplete="off"
                   style="height:54px; border:2px solid #e2e8f0; border-radius:10px; font-size:15px; padding:12px 16px;">
            <div id="ciclo_results" class="autocomplete-results"></div>
        </div>
    </div>
</div>

<div id="form_container" class="opacity-50" style="pointer-events: none;">
    <form id="edit_form" method="post" action="#">
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
            <div class="card-body">
                <div class="form-group">
                    <label class="small font-weight-bold">Nombre del Ciclo</label>
                    <input type="text" name="nombre" id="f_nombre" class="form-control" required style="border-radius:8px;">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" id="f_fecha_inicio" class="form-control" required style="border-radius:8px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold">Fecha de Término</label>
                            <input type="date" name="fecha_fin" id="f_fecha_fin" class="form-control" required style="border-radius:8px;">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="small font-weight-bold">Estado</label>
                    <select name="estado" id="f_estado" class="form-control" style="border-radius:8px;">
                        <option value="Proximo">Próximo</option>
                        <option value="Activo">Activo</option>
                        <option value="Cerrado">Cerrado</option>
                    </select>
                </div>
            </div>
        </div>

        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                    <li><?php echo htmlspecialchars($e); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between mb-5">
            <a href="<?php echo BASE_URL; ?>ciclos" class="btn btn-outline-secondary">Cancelar</a>
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
    var items = <?php echo json_encode(array_values(array_map(function($c) {
        return ['id' => $c['id'], 'label' => $c['nombre'], 'data' => $c];
    }, $ciclos)), JSON_HEX_TAG | JSON_HEX_APOS); ?> || [];

    var $input = $('#ciclo_search');
    var $results = $('#ciclo_results');

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
        var c = item.data;
        $('#f_nombre').val(c.nombre);
        $('#f_fecha_inicio').val(c.fecha_inicio);
        $('#f_fecha_fin').val(c.fecha_fin);
        $('#f_estado').val(c.estado);
        $('#edit_form').attr('action', '<?php echo BASE_URL; ?>ciclos/edit/' + id);
        $('#form_container').removeClass('opacity-50').css('pointer-events', 'auto');
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.autocomplete-wrap').length) $results.hide();
    });
});
</script>
