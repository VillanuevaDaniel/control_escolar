<?php
session_start();

// Requiere sesión activa; si no, redirige al login
function require_auth()
{
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }

    // Prevenir caché de la página para que no se pueda regresar tras cerrar sesión
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
}

// Retorna los datos del usuario en sesión
function session_user()
{
    if (!isset($_SESSION['usuario_id'])) {
        return null;
    }
    return array(
        'id'      => $_SESSION['usuario_id'],
        'nombre'  => $_SESSION['usuario_nombre'],
        'rol'     => $_SESSION['usuario_rol'],
        'loginId' => $_SESSION['usuario_login'],
        'permisos' => isset($_SESSION['usuario_permisos']) ? $_SESSION['usuario_permisos'] : array(),
        'tipo'    => $_SESSION['usuario_tipo'] ?? $_SESSION['usuario_rol'],
        'foto'    => $_SESSION['usuario_foto'] ?? null,
    );
}

// ¿El usuario tiene acceso a un módulo?
function puede_ver($modulo)
{
    $u = session_user();
    if (!$u) return false;
    // Director y Admin ven todo por defecto en esta versión
    if ($u['rol'] === 'director' || $u['rol'] === 'admin') return true;

    // Mapeo por rol
    $mapa = array(
        'profesor' => array('calificaciones', 'horarios', 'materias', 'grupos', 'reportes'),
        'alumno'   => array('mi_horario', 'mis_calificaciones'),
    );
    $permitidos = isset($mapa[$u['rol']]) ? $mapa[$u['rol']] : array();
    return in_array($modulo, $permitidos);
}

// Sólo director
function solo_director()
{
    $u = session_user();
    if (!$u || $u['rol'] !== 'director') {
        header('Location: ' . BASE_URL . 'dashboard.php');
        exit;
    }
}
