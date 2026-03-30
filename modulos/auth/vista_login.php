<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Acceso al Sistema — Control Escolar</title>

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/fonts.css">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/app.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css">
</head>

<body class="login-page">

    <div class="login-container">
        <div class="login-card fade-in">
            <div class="login-header-img">
                <div class="login-header-overlay"></div>
            </div>

            <div class="card-body px-4 pb-4 pt-0 text-center">
                <div class="brand-icon fade-in delay-1">
                    <span class="material-symbols-outlined" style="font-size:32px;">school</span>
                </div>

                <h3 class="login-title fade-in delay-1">Control Escolar</h3>
                <?php if (isset($error) && $error): ?>
                    <div class="alert alert-modern fade-in delay-1" role="alert">
                        <span class="material-symbols-outlined" style="font-size: 20px;">error</span>
                        <span class="small font-weight-medium"><?php echo e($error); ?></span>
                    </div>
                <?php endif; ?>

                <form method="post" action="" autocomplete="off" class="text-left mt-4">
                    <div class="form-group mb-3 fade-in delay-2">
                        <label>USUARIO</label>
                        <div class="input-icon-wrap position-relative">
                            <span class="material-symbols-outlined input-icon">person</span>
                            <input type="text" name="nombre_usuario" class="form-control" placeholder="Número de Control/Matrícula" required autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-4 fade-in delay-2">
                        <label>CONTRASEÑA</label>
                        <div class="input-icon-wrap position-relative">
                            <span class="material-symbols-outlined input-icon">lock</span>
                            <input type="password" name="contrasena" class="form-control" placeholder="Ingresa tu contraseña" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-login fade-in delay-3">
                        <span>Iniciar Sesión</span>
                        <span class="material-symbols-outlined" style="font-size: 18px;">login</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>