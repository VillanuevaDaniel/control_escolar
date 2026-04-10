<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item active">Usuarios</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">manage_accounts</span>Gestión de Usuarios</h1>
        <p>Administración de personal con acceso al sistema</p>
    </div>
    <div class="d-flex">
        <a href="<?php echo BASE_URL; ?>usuarios/search_edit" class="btn btn-outline-primary mr-2" style="border-radius:8px; padding: 10px 20px; font-weight:600;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">edit</span> Editar Usuario
            </a>
        <a href="<?php echo BASE_URL; ?>usuarios/create" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding: 10px 20px; font-weight:600;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">person_add</span> Nuevo Usuario
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
    <div class="card-header bg-white font-weight-bold pt-3 pb-2">
        <span class="material-symbols-outlined mr-2 text-primary" style="font-size:20px; vertical-align:middle;">group</span>
        Personal Registrado
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="pl-4">Nombre de usuario</th>
                    <th class="text-center">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td class="pl-4 align-middle">
                            <span class="font-weight-bold text-dark"><?php echo e($u['nombre_usuario']); ?></span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="badge" style="border-radius:20px; padding: 6px 15px; background: <?php echo $u['estado'] ? '#dcfce7' : '#f1f5f9'; ?>; color: <?php echo $u['estado'] ? '#166534' : '#475569'; ?>; font-weight: 600; font-size:11px;">
                                <?php echo $u['estado'] ? 'ACTIVO' : 'INACTIVO'; ?>
                            </span>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(id, nombre) {
        if (confirm('¿Está seguro de que desea eliminar el usuario: ' + nombre + '?')) {
            window.location.href = '<?php echo BASE_URL; ?>usuarios/delete/' + id;
        }
    }
</script>

<?php include 'includes/footer.php'; ?>