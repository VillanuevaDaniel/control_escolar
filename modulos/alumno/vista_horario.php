<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item active">Mi Horario</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px; color: #4338ca;">calendar_today</span>Mi Horario Escolar</h1>
        <p>Clases programadas para el ciclo: <strong><?php echo e($ciclo['nombre']); ?></strong></p>
    </div>
    <button onclick="window.print()" class="btn btn-outline-primary d-none d-md-flex align-items-center" style="border-radius:8px;">
        <span class="material-symbols-outlined mr-1" style="font-size:20px;">print</span> Imprimir Horario
    </button>
</div>

<?php if (!$grupo_id): ?>
    <div class="card border-0 shadow-sm text-center py-5" style="border-radius:12px; background: #fffbeb;">
        <span class="material-symbols-outlined text-warning mb-3" style="font-size:64px;">warning</span>
        <h5 class="text-dark font-weight-bold">Aún no tienes grupo asignado</h5>
        <p class="text-secondary">Contacta con servicios escolares para regularizar tu inscripción al ciclo actual.</p>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($dias as $dia): ?>
            <div class="col-md-6 col-lg mb-4">
                <div class="card h-100 border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
                    <div class="card-header text-white font-weight-bold text-center py-3" style="background: #4338ca; border:none; letter-spacing:1px;">
                        <?php echo strtoupper($dia); ?>
                    </div>
                    <div class="card-body p-3 bg-light">
                        <?php if (!$grid[$dia]): ?>
                            <div class="text-center py-4 text-muted" style="opacity:0.5;">
                                <span class="material-symbols-outlined" style="font-size:32px;">event_busy</span>
                                <p class="small mt-2 mb-0">Sin clases</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($grid[$dia] as $clase): ?>
                                <div class="card border-0 mb-3 shadow-sm hover-grow" style="border-radius:10px; border-left:4px solid #4338ca !important; background:white;">
                                    <div class="card-body p-3">
                                        <h6 class="font-weight-bold mb-2 text-indigo" style="font-size:14px;"><?php echo e($clase['materia']); ?></h6>

                                        <div class="mb-1 d-flex align-items-center text-dark">
                                            <span class="material-symbols-outlined mr-2" style="font-size:16px; color:#64748b;">schedule</span>
                                            <span class="small font-weight-bold"><?php echo substr($clase['hora_inicio'], 0, 5) . ' – ' . substr($clase['hora_fin'], 0, 5); ?></span>
                                        </div>

                                        <div class="small text-secondary mb-1">
                                            <span class="material-symbols-outlined mr-2" style="font-size:16px; vertical-align:middle;">meeting_room</span>
                                            Aula: <strong class="text-dark"><?php echo e($clase['salon']); ?></strong>
                                        </div>

                                        <div class="small text-secondary">
                                            <span class="material-symbols-outlined mr-2" style="font-size:16px; vertical-align:middle;">person</span>
                                            <?php echo e($clase['docente']); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
    .hover-grow {
        transition: transform 0.2s ease-in-out;
    }

    .hover-grow:hover {
        transform: scale(1.02);
    }

    @media print {

        .breadcrumb,
        .page-header button,
        .main-sidebar,
        .main-header {
            display: none !important;
        }

        .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>

<?php include 'includes/footer.php'; ?>