<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item active">Reportes</li>
    </ol>
</nav>

<div class="page-header text-center mb-5">
    <h1><span class="material-symbols-outlined mr-2" style="font-size:36px; color:#197fe6; vertical-align:middle;">analytics</span>Reportes Escolares</h1>
    <p class="text-secondary">Generación de listas de asistencia y boletas oficiales de calificaciones</p>
</div>

<div class="row justify-content-center">
    <!-- Reporte por Grupo -->
    <div class="col-md-5 mb-4">
        <div class="card h-100 border-0 shadow-sm hover-card" style="border-radius:16px; overflow:hidden;">
            <div class="card-body text-center p-5">
                <div class="mb-4 d-inline-flex align-items-center justify-content-center" style="width:80px; height:80px; background:#eff6ff; border-radius:50%;">
                    <span class="material-symbols-outlined text-primary" style="font-size:40px;">groups</span>
                </div>
                <h4 class="font-weight-bold mb-3">Listas por Grupo</h4>
                <p class="text-secondary small mb-4">Genera la lista oficial de alumnos inscritos en un grupo para el ciclo escolar vigente.</p>

                <form action="<?php echo BASE_URL; ?>reportes/lista_grupo" method="get" target="_blank">
                    <div class="form-group mb-4">
                        <select name="id" class="form-control form-control-lg custom-select-lg" required style="border-radius:12px; font-size:16px;">
                            <option value="">Selecciona un grupo...</option>
                            <?php foreach ($grupos as $g): ?>
                                <option value="<?php echo $g['id']; ?>"><?php echo e($g['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg py-3" style="border-radius:12px; background:#197fe6; border:none; font-weight:600;">
                        <span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">print</span> Generar Lista
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Reporte de Calificaciones -->
    <div class="col-md-5 mb-4">
        <div class="card h-100 border-0 shadow-sm hover-card" style="border-radius:16px; overflow:hidden;">
            <div class="card-body text-center p-5">
                <div class="mb-4 d-inline-flex align-items-center justify-content-center" style="width:80px; height:80px; background:#f0fdf4; border-radius:50%;">
                    <span class="material-symbols-outlined text-success" style="font-size:40px;">history_edu</span>
                </div>
                <h4 class="font-weight-bold mb-3">Boleta de Calificaciones</h4>
                <p class="text-secondary small mb-4">Obtén el reporte detallado de calificaciones por alumno buscando por su número de matrícula.</p>

                <form action="<?php echo BASE_URL; ?>reportes/boleta" method="get" target="_blank">
                    <div class="form-group mb-4">
                        <input type="text" name="matricula" class="form-control form-control-lg" placeholder="Ingrese Matrícula..." required style="border-radius:12px; font-size:16px; text-align:center;">
                    </div>
                    <button type="submit" class="btn btn-success btn-block btn-lg py-3" style="border-radius:12px; border:none; font-weight:600;">
                        <span class="material-symbols-outlined mr-2" style="font-size:20px; vertical-align:middle;">description</span> Generar Boleta
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
        border: 1px solid transparent !important;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        border-color: #e2e8f0 !important;
    }

    .custom-select-lg {
        height: calc(1.5em + 1rem + 2px);
        padding: .5rem 1rem;
    }
</style>

<?php include 'includes/footer.php'; ?>