<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item active">Horarios</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">calendar_month</span>Horarios</h1>
        <p>Semana de clases<?php if ($ciclo): ?> &mdash; Ciclo <strong><?php echo e($ciclo['nombre']); ?></strong><?php endif; ?></p>
    </div>
</div>

<!-- Filtros -->
<div class="filter-bar">
    <form method="get" action="<?php echo BASE_URL; ?>horarios" class="form-row align-items-end">
        <div class="col-12 col-md-3 mb-2 mb-md-0">
            <label class="small font-weight-bold text-secondary">Grupo</label>
            <select name="grupo" class="form-control" style="border-radius:8px;">
                <option value="0">Todos los grupos</option>
                <?php foreach ($grupos as $g): ?>
                    <option value="<?php echo $g['id_grupo']; ?>" <?php if ($filtros['grupo_id'] == $g['id_grupo']) echo 'selected'; ?>><?php echo e($g['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php if ($u['rol'] !== 'profesor'): ?>
            <div class="col-12 col-md-3 mb-2 mb-md-0">
                <label class="small font-weight-bold text-secondary">Docente</label>
                <select name="docente" class="form-control" style="border-radius:8px;">
                    <option value="0">Todos los docentes</option>
                    <?php foreach ($docentes as $d): ?>
                        <option value="<?php echo $d['id_profesor']; ?>" <?php if ($filtros['docente_id'] == $d['id_profesor']) echo 'selected'; ?>><?php echo e($d['nombre_completo']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>
        <div class="col-12 col-md-3 mb-2 mb-md-0">
            <label class="small font-weight-bold text-secondary">Salón</label>
            <select name="salon" class="form-control" style="border-radius:8px;">
                <option value="0">Todos los salones</option>
                <?php foreach ($salones as $s): ?>
                    <option value="<?php echo $s['id_salon']; ?>" <?php if ($filtros['salon_id'] == $s['id_salon']) echo 'selected'; ?>><?php echo e($s['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 col-md-3 d-flex">
            <button type="submit" class="btn btn-primary flex-fill mr-2" style="background:#197fe6; border:none; border-radius:8px;">
                Filtrar
            </button>
            <a href="<?php echo BASE_URL; ?>horarios" class="btn btn-outline-secondary" style="border-radius:8px;">
                <span class="material-symbols-outlined" style="font-size:20px;">restart_alt</span>
            </a>
        </div>
    </form>
</div>

<!-- Grid de horario por día -->
<div class="row">
    <?php foreach ($dias as $dia): ?>
        <div class="col-12 col-md-6 col-xl mb-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
                <div class="card-header text-white font-weight-bold border-0 text-center py-3" style="background:#1e293b; letter-spacing:1px;">
                    <?php echo strtoupper($dia); ?>
                </div>
                <div class="card-body p-3 bg-light">
                    <?php if (!$grid[$dia]): ?>
                        <div class="text-center py-4 text-muted" style="opacity:0.5;">
                            <span class="material-symbols-outlined" style="font-size:32px;">event_busy</span>
                            <p class="small mt-2 mb-0">Sin clases</p>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($grid[$dia] as $h): ?>
                        <div class="card border-0 mb-3 shadow-sm hover-shadow transition-all" style="border-radius:10px; border-left:4px solid #197fe6 !important; background:white;">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="font-weight-bold mb-0 text-primary" style="font-size:14px;"><?php echo e($h['materia']); ?></h6>
                                </div>

                                <div class="mb-1 d-flex align-items-center text-dark">
                                    <span class="material-symbols-outlined mr-2" style="font-size:16px; color:#64748b;">schedule</span>
                                    <span class="small font-weight-bold"><?php echo substr($h['hora_inicio'], 0, 5) . ' – ' . substr($h['hora_fin'], 0, 5); ?></span>
                                </div>

                                <div class="small text-secondary mb-1">
                                    <span class="material-symbols-outlined mr-2" style="font-size:16px; vertical-align:middle;">groups</span>
                                    Grupo: <strong class="text-dark"><?php echo e($h['grupo']); ?></strong>
                                </div>

                                <div class="small text-secondary mb-1">
                                    <span class="material-symbols-outlined mr-2" style="font-size:16px; vertical-align:middle;">meeting_room</span>
                                    Salón: <strong class="text-dark"><?php echo e($h['salon']); ?></strong>
                                </div>

                                <div class="small text-secondary">
                                    <span class="material-symbols-outlined mr-2" style="font-size:16px; vertical-align:middle;">person</span>
                                    <?php echo e($h['docente_n'] . ' ' . $h['docente_ap']); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
    }

    .transition-all {
        transition: all 0.2s ease-in-out;
    }
</style>

<?php include 'includes/footer.php'; ?>