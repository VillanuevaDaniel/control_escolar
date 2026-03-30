<?php include 'includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard"><span class="material-symbols-outlined" style="font-size:16px; vertical-align:middle;">home</span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>usuarios">Usuarios</a></li>
        <li class="breadcrumb-item active">Nuevo</li>
    </ol>
</nav>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><span class="material-symbols-outlined mr-2" style="font-size:28px;">person_add</span>Nuevo Usuario</h1>
        <p>Registro de usuario</p>
    </div>
</div>

<form method="post" action="<?php echo BASE_URL; ?>usuarios/create" class="check-dirty">
    <div class="row">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
                <div class="card-header bg-white font-weight-bold pt-3 pb-2">
                    <span class="material-symbols-outlined mr-2 text-primary" style="font-size:20px; vertical-align:middle;">clinical_notes</span>
                    Información de la Cuenta
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="small font-weight-bold text-secondary">Nombre de Usuario (Login) <span class="text-danger">*</span></label>
                        <input type="text" name="nombre_usuario" class="form-control" required style="border-radius:8px;">
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold text-secondary">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" name="contrasena" class="form-control" required style="border-radius:8px;">
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="custom-control custom-switch mt-4">
                                <input type="checkbox" name="estado" class="custom-control-input" id="estado" checked>
                                <label class="custom-control-label font-weight-bold text-secondary" style="cursor:pointer;" for="estado">Usuario Activo</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-2 d-flex mb-5">
        <a href="<?php echo BASE_URL; ?>usuarios" class="btn btn-outline-secondary mr-2" style="border-radius:8px; padding:10px 25px;">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">arrow_back</span> Cancelar
        </a>
        <button type="submit" class="btn btn-primary" style="background:#197fe6; border:none; border-radius:8px; padding:10px 40px; font-weight:600; box-shadow: 0 4px 6px rgba(25, 127, 230, 0.2);">
            <span class="material-symbols-outlined mr-1" style="font-size:20px; vertical-align:middle;">save</span> Guardar Usuario
        </button>
    </div>
</form>

<?php include 'includes/footer.php'; ?>