<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item active">Grupos</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">groups</span>Grupos</h1>
        <p>Gestión de grupos escolares</p>
    </div>
    <a href="<?php echo BASE_URL; ?>grupos/create" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding: 10px 20px; font-weight:600;">
        <span class="material-symbols-outlined mr-1" style="font-size:20px;">group_add</span> Nuevo Grupo
    </a>
</div>

<div class="row">
    <?php if (!$grupos): ?>
        <div class="col-12">
            <div class="card p-5 text-center text-muted border-0 shadow-sm" style="border-radius:12px;">
                <span class="material-symbols-outlined" style="font-size:48px; opacity:0.2;">group</span>
                <p class="mt-2">No hay grupos registrados aún.</p>
            </div>
        </div>
    <?php endif; ?>

    <?php foreach ($grupos as $g): ?>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card h-100 border-0 shadow-sm group-card" style="border-radius:12px; overflow:hidden; transition: transform 0.2s;">
                <div class="card-body text-center py-4">
                    <div class="mx-auto d-flex align-items-center justify-content-center mb-3 group-count"
                        style="width:72px; height:72px; background:#eff6ff; color:#197fe6; border-radius:16px; font-size:24px; font-weight:bold; border:1px solid #dbeafe;">
                        <?php echo e($g['nombre']); ?>
                    </div>
                    <h5 class="font-weight-bold mb-1" style="color:#0e141b;">Grupo <?php echo e($g['nombre']); ?></h5>
                    <p class="text-secondary small mb-3">Grado <?php echo e($g['grado']); ?> &mdash; Sección <?php echo e($g['seccion']); ?></p>

                    <div class="mb-3">
                        <span class="badge" style="background:#eff6ff; color:#197fe6; border:none; padding:8px 12px; border-radius:20px;">
                            <span class="material-symbols-outlined mr-1" style="font-size:16px; vertical-align:middle;">person</span>
                            <?php echo $g['total_alumnos']; ?> / <?php echo $g['capacidad']; ?>
                        </span>
                    </div>

                    <p class="text-muted small mb-0 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined mr-1" style="font-size:16px;">calendar_today</span>
                        <?php echo e($g['ciclo_nombre']); ?>
                    </p>
                </div>
                <div class="card-footer bg-white border-top-0 pt-0 pb-4 px-4 text-center">
                    <div class="d-flex justify-content-center">
                        <a href="<?php echo BASE_URL; ?>grupos/edit/<?php echo $g['id_grupo']; ?>" class="btn-action mr-2" title="Editar">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmDelete(<?php echo $g['id_grupo']; ?>, '<?php echo e($g['nombre']); ?>')" class="btn-action delete" title="Eliminar">
                            <span class="material-symbols-outlined">delete</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function confirmDelete(id, nombre) {
        if (confirm('¿Estás seguro de que deseas eliminar el grupo ' + nombre + '?')) {
            window.location.href = '<?php echo BASE_URL; ?>grupos/delete/' + id;
        }
    }
</script>

<style>
    .group-card:hover {
        transform: translateY(-5px);
    }
</style>

<?php include 'includes/footer.php'; ?>