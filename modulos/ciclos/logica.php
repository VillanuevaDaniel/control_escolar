<?php
// modulos/ciclos/logica.php — Controlador CiclosController

class CiclosController extends Controller
{
    private $cicloModel;

    public function __construct()
    {
        require_auth();
        $this->cicloModel = new CicloEscolar();
    }

    public function index()
    {
        $ciclos = $this->cicloModel->getAll();

        $this->view('ciclos/index', [
            'ciclos' => $ciclos
        ]);
    }

    public function create()
    {
        $errors = [];
        $datos  = ['nombre' => '', 'fecha_inicio' => '', 'fecha_fin' => '', 'estado' => 'Proximo'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'       => trim($_POST['nombre'] ?? ''),
                'fecha_inicio' => $_POST['fecha_inicio'] ?? '',
                'fecha_fin'    => $_POST['fecha_fin']    ?? '',
                'estado'       => $_POST['estado']       ?? 'Proximo',
            ];

            if ($datos['nombre'] === '') {
                $errors[] = 'El nombre del ciclo es obligatorio.';
            }
            if ($datos['fecha_inicio'] === '') {
                $errors[] = 'La fecha de inicio es obligatoria.';
            }
            if ($datos['fecha_fin'] === '') {
                $errors[] = 'La fecha de término es obligatoria.';
            }
            if ($datos['fecha_inicio'] && $datos['fecha_fin'] && $datos['fecha_fin'] < $datos['fecha_inicio']) {
                $errors[] = 'La fecha de término debe ser posterior a la de inicio.';
            }

            if (empty($errors)) {
                $this->cicloModel->create($datos);
                header('Location: ' . BASE_URL . 'ciclos');
                exit;
            }
        }

        $this->view('ciclos/create', [
            'errors' => $errors,
            'datos'  => $datos,
        ]);
    }

    public function activar($id)
    {
        if ($id) {
            $this->cicloModel->activar($id);
        }
        header('Location: ' . BASE_URL . 'ciclos');
        exit;
    }

    public function search_edit()
    {
        $ciclos = $this->cicloModel->getAll();

        $this->view('ciclos/search_edit', [
            'ciclos' => $ciclos,
            'errors' => [],
        ]);
    }

    public function edit($id)
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'       => trim($_POST['nombre'] ?? ''),
                'fecha_inicio' => $_POST['fecha_inicio'] ?? '',
                'fecha_fin'    => $_POST['fecha_fin']    ?? '',
                'estado'       => $_POST['estado']       ?? 'Proximo',
            ];

            if ($datos['nombre'] === '') {
                $errors[] = 'El nombre del ciclo es obligatorio.';
            }
            if ($datos['fecha_inicio'] === '') {
                $errors[] = 'La fecha de inicio es obligatoria.';
            }
            if ($datos['fecha_fin'] === '') {
                $errors[] = 'La fecha de término es obligatoria.';
            }
            if ($datos['fecha_inicio'] && $datos['fecha_fin'] && $datos['fecha_fin'] < $datos['fecha_inicio']) {
                $errors[] = 'La fecha de término debe ser posterior a la de inicio.';
            }

            if (empty($errors)) {
                $this->cicloModel->update($id, $datos);
                header('Location: ' . BASE_URL . 'ciclos');
                exit;
            }
        }

        $ciclos = $this->cicloModel->getAll();

        $this->view('ciclos/search_edit', [
            'ciclos' => $ciclos,
            'errors' => $errors,
        ]);
    }
}
