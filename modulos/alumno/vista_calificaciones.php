<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item active">Mis Calificaciones</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px; color: #10b981;">history_edu</span>Mis Calificaciones</h1>
        <p>Avance académico del ciclo: <strong><?php echo e($ciclo['nombre']); ?></strong></p>
    </div>
    <div class="card border-0 shadow-sm px-4 py-2 text-center" style="border-radius:12px; min-width:180px;">
        <div class="small text-secondary font-weight-bold text-uppercase" style="letter-spacing:1px; font-size:10px;">Promedio General</div>
        <div class="h3 font-weight-bold mb-0 <?php echo $promedio >= 6 ? 'text-success' : 'text-danger'; ?>">
            <?php echo number_format($promedio, 2); ?>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
    <div class="card-header bg-white font-weight-bold pt-3 pb-2">
        <span class="material-symbols-outlined mr-2 text-success" style="font-size:20px; vertical-align:middle;">list_alt</span>
        Resumen de Aprovechamiento
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr class="text-uppercase" style="font-size:11px; letter-spacing:1px;">
                    <th class="pl-4">Clave</th>
                    <th>Materia</th>
                    <th class="text-center">Calificación</th>
                    <th class="text-center">Estado</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$calificaciones): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Aún no se han registrado calificaciones para este ciclo.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($calificaciones as $c): ?>
                    <tr>
                        <td class="pl-4"><code class="text-primary"><?php echo e($c['clave']); ?></code></td>
                        <td class="font-weight-bold" style="color:#334155;"><?php echo e($c['materia']); ?></td>
                        <td class="text-center align-middle">
                            <span class="h5 font-weight-bold mb-0 <?php echo $c['puntaje'] >= 6 ? 'text-dark' : 'text-danger'; ?>">
                                <?php echo number_format($c['puntaje'], 1); ?>
                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <?php if ($c['puntaje'] >= 6): ?>
                                <span class="badge" style="background:#dcfce7; color:#166534; border-radius:30px; padding:6px 15px; font-size:10px;">
                                    <span class="material-symbols-outlined mr-1" style="font-size:14px; vertical-align:middle;">check_circle</span> APROBADO
                                </span>
                            <?php else: ?>
                                <span class="badge" style="background:#fee2e2; color:#991b1b; border-radius:30px; padding:6px 15px; font-size:10px;">
                                    <span class="material-symbols-outlined mr-1" style="font-size:14px; vertical-align:middle;">cancel</span> REPROBADO
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="small text-muted align-middle"><?php echo fmt_fecha($c['fecha_registro']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 p-4 border-0 shadow-sm" style="border-radius:12px; background: #f8fafc; border-left: 5px solid #10b981 !important;">
    <div class="d-flex">
        <span class="material-symbols-outlined text-success mr-3" style="font-size:24px;">info</span>
        <div>
            <h6 class="font-weight-bold text-dark mb-1">Información Importante</h6>
            <p class="small text-secondary mb-0">Esta consulta tiene un carácter informativo. Para trámites legales o académicos oficiales, solicita tu boleta física sellada en las oficinas administrativas del plantel.</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>