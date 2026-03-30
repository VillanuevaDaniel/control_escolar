<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item active">Docentes</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">badge</span>Docentes</h1>
        <p>Gestión del personal docente</p>
    </div>
    <div class="d-flex">
        <a href="<?php echo BASE_URL; ?>docentes/search_edit" class="btn btn-outline-primary mr-2" style="border-radius:8px; padding: 10px 20px; font-weight:600;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">edit</span> Editar Docente
        </a>
        <a href="<?php echo BASE_URL; ?>docentes/create" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding: 10px 20px; font-weight:600;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">person_add</span> Nuevo Docente
        </a>
    </div>
</div>

<!-- Filtros -->
<div class="filter-bar">
    <form method="get" action="<?php echo BASE_URL; ?>docentes" class="form-row align-items-end">
        <div class="col-12 col-md-5 mb-2 mb-md-0">
            <label class="small font-weight-bold text-secondary">Buscar</label>
            <div class="position-relative">
                <span class="material-symbols-outlined" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:18px;">search</span>
                <input type="text" name="q" class="form-control pl-5" placeholder="Nombre, N° empleado, email..." value="<?php echo e($filtros['q']); ?>">
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
            <a href="<?php echo BASE_URL; ?>docentes" class="btn btn-outline-secondary" style="border-radius:8px;">
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
            Lista de Docentes <span class="badge badge-info ml-2" style="background:#eff6ff; color:#197fe6; border:none;"><?php echo count($docentes); ?></span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr class="text-uppercase" style="font-size:11px; letter-spacing:1px;">
                        <th class="pl-4">Docente</th>
                        <th>N° Empleado</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th class="pr-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$docentes): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <span class="material-symbols-outlined" style="font-size:48px; opacity:0.2;">person</span>
                                <p class="mt-2">No se encontraron docentes.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($docentes as $d): ?>
                        <tr>
                            <td class="pl-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle mr-3" style="width:40px; height:40px; background:#f1f5f9; border:1px solid #e2e8f0;">
                                        <?php if ($d['ruta_foto']): ?>
                                            <img src="<?php echo e($d['ruta_foto']); ?>" alt="">
                                        <?php else: ?>
                                            <span style="color:#64748b;"><?php echo strtoupper(substr($d['nombre_completo'], 0, 1)); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark"><?php echo e($d['apellido_paterno'] . ' ' . $d['apellido_materno']); ?></div>
                                        <div class="small text-secondary"><?php echo e($d['nombre_completo']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="font-weight-600"><?php echo e($d['numero_empleado']); ?></td>
                            <td class="small text-muted"><?php echo e($d['email'] ?: '—'); ?></td>
                            <td><?php echo e($d['telefono'] ?: '—'); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $d['estado'] === 'Activo' ? 'success' : 'secondary'; ?>"><?php echo e($d['estado']); ?></span>
                            </td>
                            <td class="pr-4 text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="<?php echo BASE_URL; ?>docentes/show/<?php echo $d['id_profesor']; ?>" class="btn-action mr-1" title="Ver">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>docentes/edit/<?php echo $d['id_profesor']; ?>" class="btn-action mr-1" title="Editar">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="javascript:void(0)" onclick="confirmDelete(<?php echo $d['id_profesor']; ?>, '<?php echo e($d['nombre_completo']); ?>')" class="btn-action delete" title="Eliminar">
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
        if (confirm('¿Estás seguro de que deseas eliminar al docente ' + nombre + '?')) {
            window.location.href = '<?php echo BASE_URL; ?>docentes/delete/' + id;
        }
    }
</script>

<?php include 'includes/footer.php'; ?>