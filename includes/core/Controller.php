<?php
// core/Controller.php

class Controller
{
    public function view($view, $data = [])
    {
        // $view usually comes as 'modulo/nombre_vista' (e.g. 'alumnos/index')
        $parts = explode('/', $view);
        $modulo = isset($parts[0]) ? $parts[0] : '';

        // Inyectar modulo_activo automáticamente si no viene en $data
        if (!isset($data['modulo_activo'])) {
            $data['modulo_activo'] = $modulo;
        }

        // Extrae los datos para que estén disponibles como variables en la vista
        extract($data);

        if (count($parts) >= 2) {
            $nombre_vista = implode('_', array_slice($parts, 1));
            $viewFile = 'modulos/' . $modulo . '/vista_' . $nombre_vista . '.php';
        } else {
            // Fallback for simple names
            $viewFile = 'modulos/comun/vista_' . $view . '.php';
        }

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("Vista $view (buscada en $viewFile) no encontrada.");
        }
    }

    public function model($model)
    {
        // The file is automatically loaded by spl_autoload_register in index.php
        return new $model();
    }
}
