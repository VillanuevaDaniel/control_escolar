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
    <a href="<?php echo BASE_URL; ?>usuarios/create" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding:10px 20px; font-weight:600;">
        <span class="material-symbols-outlined mr-1" style="font-size:20px;">person_add</span> Nuevo Usuario
    </a>
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
                    <th class="text-center">Acciones</th>
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
                        <td class="align-middle text-center no-wrap">
                            <a href="<?php echo BASE_URL; ?>usuarios/edit/<?php echo $u['id_usuario']; ?>" class="btn btn-sm btn-outline-warning mx-1" title="Editar" style="border-radius:8px; width:36px; height:36px; padding:0; display:inline-flex; align-items:center; justify-content:center;">
                                <span class="material-symbols-outlined" style="font-size:18px;">edit</span>
                            </a>
                            <?php if ($u['id_usuario'] !== $_SESSION['usuario_id']): ?>
                                <a href="javascript:void(0)" onclick="confirmDelete(<?php echo $u['id_usuario']; ?>, '<?php echo addslashes($u['nombre_usuario']); ?>')" class="btn btn-sm btn-outline-danger mx-1" title="Eliminar" style="border-radius:8px; width:36px; height:36px; padding:0; display:inline-flex; align-items:center; justify-content:center;">
                                    <span class="material-symbols-outlined" style="font-size:18px;">delete</span>
                                </a>
                            <?php endif; ?>
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