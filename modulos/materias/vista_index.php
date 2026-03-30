<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item active">Materias</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">menu_book</span>Materias</h1>
        <p>Catálogo de materias del plantel</p>
    </div>
    <div class="d-flex">
        <a href="<?php echo BASE_URL; ?>materias/search_edit" class="btn btn-outline-primary mr-2" style="border-radius:8px; padding: 10px 20px; font-weight:600;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">edit</span> Editar Materia
        </a>
        <a href="<?php echo BASE_URL; ?>materias/create" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding: 10px 20px; font-weight:600;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">add_box</span> Nueva Materia
        </a>
    </div>
</div>

<!-- Filtros -->
<div class="filter-bar">
    <form method="get" action="<?php echo BASE_URL; ?>materias" class="form-row align-items-end">
        <div class="col-12 col-md-5 mb-2 mb-md-0">
            <label class="small font-weight-bold text-secondary">Buscar</label>
            <div class="position-relative">
                <span class="material-symbols-outlined" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:18px;">search</span>
                <input type="text" name="q" class="form-control pl-5" placeholder="Nombre, clave, área..." value="<?php echo e($filtros['q']); ?>">
            </div>
        </div>
        <div class="col-6 col-md-3 mb-2 mb-md-0">
            <label class="small font-weight-bold text-secondary">Estado</label>
            <select name="estado" class="form-control">
                <option value="">Todos</option>
                <option value="Activo" <?php if ($filtros['estado'] === 'Activo')   echo 'selected'; ?>>Activo</option>
                <option value="Inactivo" <?php if ($filtros['estado'] === 'Inactivo') echo 'selected'; ?>>Inactivo</option>
            </select>
        </div>
        <div class="col-12 col-md-4 d-flex">
            <button type="submit" class="btn btn-primary flex-fill mr-2" style="background:#197fe6; border:none; border-radius:8px;">
                Filtrar
            </button>
            <a href="<?php echo BASE_URL; ?>materias" class="btn btn-outline-secondary" style="border-radius:8px;">
                <span class="material-symbols-outlined" style="font-size:20px;">restart_alt</span>
            </a>
        </div>
    </form>
</div>

<!-- Tabla -->
<div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
        <h5 class="font-weight-bold mb-0">
            <span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle; color:#197fe6;">list</span>
            Lista de Materias <span class="badge badge-info ml-2" style="background:#eff6ff; color:#197fe6; border:none;"><?php echo count($materias); ?></span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr class="text-uppercase" style="font-size:11px; letter-spacing:1px;">
                        <th class="pl-4">Clave</th>
                        <th>Nombre</th>
                        <th>Área</th>
                        <th>Grado</th>
                        <th>Hrs</th>
                        <th>Estado</th>
                        <th class="pr-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$materias): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <span class="material-symbols-outlined" style="font-size:48px; opacity:0.2;">menu_book</span>
                                <p class="mt-2">No se encontraron materias.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($materias as $m): ?>
                        <tr>
                            <td class="pl-4 font-weight-bold" style="color:#197fe6;"><?php echo e($m['clave'] ?: '—'); ?></td>
                            <td class="font-weight-600"><?php echo e($m['nombre']); ?></td>
                            <td><span class="badge" style="background:#f1f5f9; color:#475569; font-weight:500;"><?php echo e($m['area'] ?: 'General'); ?></span></td>
                            <td><?php echo e($m['grado'] ? $m['grado'] . '°' : '—'); ?></td>
                            <td><span class="text-secondary"><?php echo e($m['horas']); ?>h</span></td>
                            <td>
                                <span class="badge badge-<?php echo $m['estado'] === 'Activo' ? 'success' : 'secondary'; ?>"><?php echo e($m['estado']); ?></span>
                            </td>
                            <td class="pr-4 text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="<?php echo BASE_URL; ?>materias/edit/<?php echo $m['id_materia']; ?>" class="btn-action mr-1" title="Editar">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="javascript:void(0)" onclick="confirmDelete(<?php echo $m['id_materia']; ?>, '<?php echo e($m['nombre']); ?>')" class="btn-action delete" title="Eliminar">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, nombre) {
        if (confirm('¿Estás seguro de que deseas eliminar la materia ' + nombre + '?')) {
            window.location.href = '<?php echo BASE_URL; ?>materias/delete/' + id;
        }
    }
</script>

<?php include 'includes/footer.php'; ?>