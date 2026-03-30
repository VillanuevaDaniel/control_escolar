<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item active">Ciclos Escolares</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">event_repeat</span>Ciclos Escolares</h1>
        <p>Administración de los periodos académicos de la institución</p>
    </div>
    <div class="d-flex">
        <a href="<?php echo BASE_URL; ?>ciclos/search_edit" class="btn btn-outline-primary mr-2" style="border-radius:8px; padding: 10px 20px; font-weight:600;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">edit</span> Editar Ciclo
        </a>
        <a href="<?php echo BASE_URL; ?>ciclos/create" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding: 10px 20px; font-weight:600;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">add_circle</span> Nuevo Ciclo
        </a>
    </div>
</div>

<div class="row">
    <!-- Tabla de ciclos -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
            <div class="card-header bg-white font-weight-bold pt-3 pb-2">
                <span class="material-symbols-outlined mr-2 text-primary" style="font-size:20px; vertical-align:middle;">list</span>
                Historial de Ciclos
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="pl-4">Nombre del Ciclo</th>
                            <th>Inicio / Fin</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$ciclos): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No hay ciclos escolares registrados.</td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($ciclos as $c): ?>
                            <tr <?php echo $c['estado'] === 'Activo' ? 'style="background:#f0f9ff;"' : ''; ?>>
                                <td class="pl-4 align-middle">
                                    <span class="font-weight-bold text-dark"><?php echo e($c['nombre']); ?></span>
                                    <?php if ($c['estado'] === 'Activo'): ?>
                                        <span class="ml-2 badge badge-pill badge-primary" style="font-size:9px;">ACTUAL</span>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle small">
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="material-symbols-outlined mr-1 text-success" style="font-size:14px;">input</span>
                                        <?php echo fmt_fecha($c['fecha_inicio']); ?>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="material-symbols-outlined mr-1 text-danger" style="font-size:14px;">output</span>
                                        <?php echo fmt_fecha($c['fecha_fin']); ?>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <?php
                                    $colores = ['Activo' => '#dcfce7', 'Cerrado' => '#f1f5f9', 'Proximo' => '#e0f2fe'];
                                    $tcolores = ['Activo' => '#166534', 'Cerrado' => '#475569', 'Proximo' => '#0369a1'];
                                    $color = $colores[$c['estado']] ?? '#f1f5f9';
                                    $tcolor = $tcolores[$c['estado']] ?? '#475569';
                                    ?>
                                    <span class="badge" style="background:<?php echo $color; ?>; color:<?php echo $tcolor; ?>; border-radius:20px; padding:6px 12px; font-size:10px; font-weight:700;">
                                        <?php echo strtoupper($c['estado']); ?>
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <?php if ($c['estado'] !== 'Activo'): ?>
                                        <a href="javascript:void(0)" onclick="confirmActivar(<?php echo $c['id']; ?>, '<?php echo addslashes($c['nombre']); ?>')"
                                            class="btn btn-sm btn-outline-success" style="border-radius:8px; padding:5px 12px; font-weight:600; font-size:11px;">
                                            <span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">play_circle</span> Activar
                                        </a>
                                    <?php else: ?>
                                        <span class="text-success small font-weight-bold">
                                            <span class="material-symbols-outlined" style="font-size:18px; vertical-align:middle;">check_circle</span>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



<script>
    function confirmActivar(id, nombre) {
        if (confirm('¿Desea activar el ciclo: ' + nombre + '? \n\nEsto cerrará el ciclo activo actual y toda la información (calificaciones, horarios, inscripciones) se referenciará a este nuevo periodo.')) {
            window.location.href = '<?php echo BASE_URL; ?>ciclos/activar/' + id;
        }
    }
</script>

<?php include 'includes/footer.php'; ?>