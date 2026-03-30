<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item active">Salones</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">meeting_room</span>Salones</h1>
        <p>Inventario de espacios físicos</p>
    </div>
    <a href="<?php echo BASE_URL; ?>salones/create" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding: 10px 20px; font-weight:600;">
        <span class="material-symbols-outlined mr-1" style="font-size:20px;">add_circle</span> Nuevo Salón
    </a>
</div>

<!-- Filtros -->
<div class="filter-bar">
    <form method="get" action="<?php echo BASE_URL; ?>salones" class="form-row align-items-end">
        <div class="col-12 col-md-8 mb-2 mb-md-0">
            <label class="small font-weight-bold text-secondary">Buscar Salón</label>
            <div class="position-relative">
                <span class="material-symbols-outlined" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:18px;">search</span>
                <input type="text" name="q" class="form-control pl-5" placeholder="Nombre, edificio, tipo..." value="<?php echo e($filtros['q']); ?>">
            </div>
        </div>
        <div class="col-12 col-md-4 d-flex">
            <button type="submit" class="btn btn-primary flex-fill mr-2" style="background:#197fe6; border:none; border-radius:8px;">
                Filtrar
            </button>
            <a href="<?php echo BASE_URL; ?>salones" class="btn btn-outline-secondary" style="border-radius:8px;">
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
            Lista de Salones <span class="badge badge-info ml-2" style="background:#eff6ff; color:#197fe6; border:none;"><?php echo count($salones); ?></span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr class="text-uppercase" style="font-size:11px; letter-spacing:1px; background:#f8fafc;">
                        <th class="pl-4">Salón</th>
                        <th>Edificio</th>
                        <th>Tipo</th>
                        <th>Capacidad</th>
                        <th>Estado</th>
                        <th class="pr-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$salones): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <span class="material-symbols-outlined" style="font-size:48px; opacity:0.2;">door_front</span>
                                <p class="mt-2">No se encontraron salones registrados.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($salones as $s): ?>
                        <tr>
                            <td class="pl-4">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 d-flex align-items-center justify-content-center" style="width:36px; height:36px; background:#f1f5f9; border-radius:8px; color:#64748b;">
                                        <span class="material-symbols-outlined" style="font-size:20px;">meeting_room</span>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold" style="color:#1e293b;"><?php echo e($s['nombre']); ?></div>
                                        <small class="text-muted"><?php echo e($s['descripcion'] ?: 'Sin descripción'); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle"><?php echo e($s['edificio'] ?: '—'); ?></td>
                            <td class="align-middle">
                                <?php
                                $icons = array('Aula' => 'school', 'Laboratorio' => 'biotech', 'Taller' => 'settings', 'Auditorio' => 'theater_comedy', 'Cancha' => 'sports_basketball', 'Otro' => 'more_horiz');
                                $icon  = isset($icons[$s['tipo']]) ? $icons[$s['tipo']] : 'door_open';
                                ?>
                                <span class="badge" style="background:#f1f5f9; color:#475569; padding:6px 10px; border-radius:6px; font-weight:500;">
                                    <span class="material-symbols-outlined mr-1" style="font-size:16px; vertical-align:middle;"><?php echo $icon; ?></span>
                                    <?php echo e($s['tipo']); ?>
                                </span>
                            </td>
                            <td class="align-middle"><span class="font-weight-600"><?php echo e($s['capacidad']); ?></span> <small class="text-muted">pers.</small></td>
                            <td class="align-middle">
                                <span class="badge badge-<?php echo $s['estado'] === 'Activo' ? 'success' : 'secondary'; ?>" style="border-radius:20px; padding:5px 12px; font-weight:500;">
                                    <?php echo e($s['estado']); ?>
                                </span>
                            </td>
                            <td class="pr-4 align-middle text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="<?php echo BASE_URL; ?>salones/edit/<?php echo $s['id_salon']; ?>" class="btn-action mr-1" title="Editar">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="javascript:void(0)" onclick="confirmDelete(<?php echo $s['id_salon']; ?>, '<?php echo e($s['nombre']); ?>')" class="btn-action delete" title="Eliminar">
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
        if (confirm('¿Estás seguro de que deseas eliminar el salón ' + nombre + '?')) {
            window.location.href = '<?php echo BASE_URL; ?>salones/delete/' + id;
        }
    }
</script>

<?php include 'includes/footer.php'; ?>