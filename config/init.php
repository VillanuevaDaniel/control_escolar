<?php

define('BASE_URL', '/ControlEscolarPHP/');

date_default_timezone_set('America/Mexico_City');

// Reporte de errores (en producción cambiar a 0)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Helpers
require_once dirname(__FILE__) . '/db.php';
require_once dirname(__FILE__) . '/auth.php';

// Función utilitaria: escapar salida HTML
function e($str)
{
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

// Función utilitaria: redirección con mensaje flash
function redirect($url, $msg = '', $tipo = 'success')
{
    if ($msg) {
        $_SESSION['flash_msg']  = $msg;
        $_SESSION['flash_tipo'] = $tipo;
    }
    header('Location: ' . $url);
    exit;
}

// Recoger mensaje flash y limpiarlo
function get_flash()
{
    if (!empty($_SESSION['flash_msg'])) {
        $msg  = $_SESSION['flash_msg'];
        $tipo = isset($_SESSION['flash_tipo']) ? $_SESSION['flash_tipo'] : 'success';
        unset($_SESSION['flash_msg'], $_SESSION['flash_tipo']);
        return array('msg' => $msg, 'tipo' => $tipo);
    }
    return null;
}

// Formatear fecha MySQL → dd/mm/yyyy
function fmt_fecha($mysql_date)
{
    if (!$mysql_date) return '—';
    $parts = explode('-', $mysql_date);
    if (count($parts) < 3) return $mysql_date;
    return $parts[2] . '/' . $parts[1] . '/' . $parts[0];
}
