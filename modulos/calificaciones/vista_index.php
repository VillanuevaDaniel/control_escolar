<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item active">Calificaciones</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">check_circle</span>Captura de Calificaciones</h1>
        <p><?php if ($ciclo): ?>Ciclo Escolar: <strong><?php echo e($ciclo['nombre']); ?></strong><?php else: ?><span class="text-danger">Seleccione un ciclo activo en configuración</span><?php endif; ?></p>
    </div>
</div>

<!-- Filtros -->
<div class="filter-bar pr-3">
    <form method="get" action="<?php echo BASE_URL; ?>calificaciones" class="form-row align-items-end" id="filtro-form">
        <div class="col-12 col-md-5 mb-2 mb-md-0">
            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Grupo</label>
            <select name="grupo" id="sel-grupo" class="form-control" onchange="this.form.submit()" style="border-radius:8px;">
                <option value="0">Seleccionar grupo...</option>
                <?php foreach ($grupos as $g): ?>
                    <option value="<?php echo $g['id_calificacion']; ?>" <?php if ($filtro_grupo == $g['id_calificacion']) echo 'selected'; ?>><?php echo e($g['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 col-md-5 mb-2 mb-md-0">
            <label class="small font-weight-bold text-secondary text-uppercase" style="letter-spacing:1px;">Materia</label>
            <select name="materia" id="sel-materia" class="form-control" onchange="this.form.submit()" style="border-radius:8px;">
                <option value="0"><?php echo $filtro_grupo ? 'Seleccionar materia...' : 'Primero selecciona un grupo'; ?></option>
                <?php foreach ($materias as $m): ?>
                    <option value="<?php echo $m['id_calificacion']; ?>" <?php if ($filtro_materia == $m['id_calificacion']) echo 'selected'; ?>><?php echo e($m['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 col-md-2">
            <a href="<?php echo BASE_URL; ?>calificaciones" class="btn btn-outline-secondary btn-block" style="border-radius:8px;">
                <span class="material-symbols-outlined" style="font-size:20px; vertical-align:middle;">restart_alt</span>
            </a>
        </div>
    </form>
</div>

<?php if ($filtro_grupo && $filtro_materia && $alumnos): ?>
    <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
        <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="font-weight-bold mb-0">
                <span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle; color:#10b981;">edit_square</span>
                Lista de Alumnos <span class="badge badge-indigo ml-2" style="background:#eef2ff; color:#4338ca; border:none;"><?php echo count($alumnos); ?></span>
            </h5>
            <div class="text-secondary small font-weight-bold">
                Promedio Grupal: <span id="promedio-badge" class="badge badge-info p-2" style="border-radius:6px; font-size:14px;">—</span>
            </div>
        </div>
        <div class="card-body p-0">
            <form method="post" action="<?php echo BASE_URL; ?>calificaciones">
                <input type="hidden" name="grupo_id" value="<?php echo $filtro_grupo; ?>">
                <input type="hidden" name="materia_id" value="<?php echo $filtro_materia; ?>">

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="text-uppercase" style="font-size:11px; letter-spacing:1px; background:#f8fafc;">
                                <th class="pl-4" style="width:60px;">#</th>
                                <th>Alumno</th>
                                <th style="width:180px;">Calificación (0–10)</th>
                                <th style="width:140px;">Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($alumnos as $al): ?>
                                <tr>
                                    <td class="pl-4 text-muted align-middle"><?php echo $i++; ?></td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold" style="color:#334155;"><?php echo e($al['nombre_completo']); ?></div>
                                        <small class="text-muted"><?php echo e($al['matricula']); ?></small>
                                    </td>
                                    <td class="align-middle">
                                        <input type="number"
                                            name="calificaciones[<?php echo $al['id_calificacion']; ?>]"
                                            class="form-control cal-input"
                                            value="<?php echo ($al['puntaje'] !== null ? number_format(floatval($al['puntaje']), 1) : ''); ?>"
                                            min="0" max="10" step="0.1"
                                            placeholder="—"
                                            style="border-radius:8px; font-weight:bold; color:#197fe6;">
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        $v = $al['puntaje'] !== null ? floatval($al['puntaje']) : null;
                                        if ($v === null) {
                                            echo '<span class="text-muted small italic">Pendiente</span>';
                                        } elseif ($v >= 9) {
                                            echo '<span class="status-pill status-excellent">Excelente</span>';
                                        } elseif ($v >= 8) {
                                            echo '<span class="status-pill status-good">Muy Bien</span>';
                                        } elseif ($v >= 6) {
                                            echo '<span class="status-pill status-pass">Aprobado</span>';
                                        } else {
                                            echo '<span class="status-pill status-fail">No Acreditado</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-top-0 p-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding:12px 35px; font-weight:600; box-shadow: 0 4px 6px rgba(25, 127, 230, 0.2);">
                        <span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">save</span> Guardar Calificaciones
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php elseif ($filtro_grupo && $filtro_materia && !$alumnos): ?>
    <div class="card border-0 shadow-sm text-center py-5" style="border-radius:12px;">
        <span class="material-symbols-outlined text-muted mb-3" style="font-size:64px; opacity:0.3;">person</span>
        <h5 class="text-secondary">No hay alumnos inscritos en este grupo</h5>
    </div>

<?php else: ?>
    <div class="card border-0 shadow-sm" style="border-radius:12px; background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);">
        <div class="card-body text-center py-5">
            <div class="d-inline-flex align-items-center justify-content-center mb-4" style="width:80px; height:80px; background:white; border-radius:50%; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
                <span class="material-symbols-outlined text-primary" style="font-size:40px;">ads_click</span>
            </div>
            <h4 class="font-weight-bold text-dark mb-2">Comenzar Captura</h4>
            <p class="text-secondary mx-auto" style="max-width:400px;">Seleccione el grupo y la materia arriba para cargar la lista de alumnos y registrar sus evaluaciones.</p>
        </div>
    </div>
<?php endif; ?>

<style>
    .cal-input:focus {
        border-color: #197fe6;
        box-shadow: 0 0 0 3px rgba(25, 127, 230, 0.15);
    }

    .status-pill {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-excellent {
        background: #dcfce7;
        color: #166534;
    }

    .status-good {
        background: #e0f2fe;
        color: #075985;
    }

    .status-pass {
        background: #fef9c3;
        color: #854d0e;
    }

    .status-fail {
        background: #fee2e2;
        color: #991b1b;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.cal-input');
        const promedioBadge = document.getElementById('promedio-badge');

        function updatePromedio() {
            let sum = 0;
            let count = 0;
            inputs.forEach(input => {
                if (input.value !== '') {
                    sum += parseFloat(input.value);
                    count++;
                }
            });
            if (count > 0) {
                promedioBadge.textContent = (sum / count).toFixed(2);
            } else {
                promedioBadge.textContent = '—';
            }
        }

        inputs.forEach(input => {
            input.addEventListener('input', updatePromedio);
        });

        if (inputs.length > 0) updatePromedio();
    });
</script>

<?php include 'includes/footer.php'; ?>