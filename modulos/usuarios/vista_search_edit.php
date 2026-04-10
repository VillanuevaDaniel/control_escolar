<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>usuarios">Usuarios</a></li>
        <li class="breadcrumb-item active">Editar Usuario</li>
    </ol>
</nav>

<div class="page-header mb-4">
    <h1><span class="material-symbols-outlined mr-2">manage_accounts</span>Editar Usuario</h1>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
    <div class="card-body">
        <div class="autocomplete-wrap" style="position:relative;">
            <input type="text" id="user_search" class="form-control" placeholder="Escribe el nombre de usuario..." autocomplete="off"
                   style="height:54px; border:2px solid #e2e8f0; border-radius:10px; font-size:15px; padding:12px 16px;">
            <div id="user_results" class="autocomplete-results"></div>
        </div>
    </div>
</div>

<div id="form_container" class="opacity-50" style="pointer-events: none;">
    <form id="edit_form" method="post" action="#">
        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
            <div class="card-body">
                <div class="form-group">
                    <label class="small font-weight-bold">Nombre de Usuario</label>
                    <input type="text" name="nombre_usuario" id="f_user" class="form-control" required style="border-radius:8px;">
                </div>
                <div class="form-group">
                    <label class="small font-weight-bold">Nueva Contraseña (opcional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Dejar en blanco si no se desea cambiar" style="border-radius:8px;">
                </div>
                <div class="form-group">
                    <label class="small font-weight-bold">Estado</label>
                    <select name="estado" id="f_estado" class="form-control" style="border-radius:8px;">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between mb-5">
            <a href="<?php echo BASE_URL; ?>usuarios" class="btn btn-outline-secondary">Cancelar</a>
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
    var items = <?php echo json_encode(array_values(array_filter(array_map(function($u) {
        if ($u['id_usuario'] == $_SESSION['usuario_id']) return null;
        return ['id' => $u['id_usuario'], 'label' => $u['nombre_usuario'], 'data' => $u];
    }, $usuarios))), JSON_HEX_TAG | JSON_HEX_APOS); ?> || [];

    var $input = $('#user_search');
    var $results = $('#user_results');

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
        var u = item.data;
        $('#f_user').val(u.nombre_usuario);
        $('#f_estado').val(u.estado);
        $('#edit_form').attr('action', '<?php echo BASE_URL; ?>usuarios/edit/' + id);
        $('#form_container').removeClass('opacity-50').css('pointer-events', 'auto');
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.autocomplete-wrap').length) $results.hide();
    });
});
</script>
