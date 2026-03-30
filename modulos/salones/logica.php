<?php
// app/Controllers/SalonesController.php

class SalonesController extends Controller
{
    private $salonModel;

    public function __construct()
    {
        require_auth();
        $this->salonModel = new Salon();
    }

    public function index()
    {
        $filtros = [
            'q' => isset($_GET['q']) ? trim($_GET['q']) : '',
        ];

        $salones = $this->salonModel->getAll();

        if ($filtros['q']) {
            $q = strtolower($filtros['q']);
            $salones = array_filter($salones, function ($s) use ($q) {
                return strpos(strtolower($s['nombre']),   $q) !== false
                    || strpos(strtolower($s['edificio']), $q) !== false
                    || strpos(strtolower($s['tipo']),     $q) !== false;
            });
        }

        $this->view('salones/index', [
            'salones' => $salones,
            'filtros' => $filtros,
        ]);
    }

    public function create()
    {
        $errors = [];
        $datos  = [
            'nombre' => '', 'edificio' => '', 'tipo' => 'Aula',
            'capacidad' => '', 'estado' => 'Activo', 'descripcion' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'      => trim($_POST['nombre']      ?? ''),
                'edificio'    => trim($_POST['edificio']    ?? ''),
                'tipo'        => $_POST['tipo']             ?? 'Aula',
                'capacidad'   => (int) ($_POST['capacidad'] ?? 0),
                'estado'      => $_POST['estado']           ?? 'Activo',
                'descripcion' => trim($_POST['descripcion'] ?? ''),
            ];

            if ($datos['nombre'] === '') {
                $errors[] = 'El nombre del salón es obligatorio.';
            }

            if (empty($errors)) {
                $this->salonModel->create($datos);
                header('Location: ' . BASE_URL . 'salones');
                exit;
            }
        }

        $this->view('salones/create', [
            'errors' => $errors,
            'datos'  => $datos,
        ]);
    }

    public function edit($id)
    {
        $salon = $this->salonModel->getById($id);
        if (!$salon) {
            header('Location: ' . BASE_URL . 'salones');
            exit;
        }

        $errors = [];
        $datos  = $salon;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = array_merge($salon, [
                'nombre'      => trim($_POST['nombre']      ?? ''),
                'edificio'    => trim($_POST['edificio']    ?? ''),
                'tipo'        => $_POST['tipo']             ?? 'Aula',
                'capacidad'   => (int) ($_POST['capacidad'] ?? 0),
                'estado'      => $_POST['estado']           ?? 'Activo',
                'descripcion' => trim($_POST['descripcion'] ?? ''),
            ]);

            if ($datos['nombre'] === '') {
                $errors[] = 'El nombre del salón es obligatorio.';
            }

            if (empty($errors)) {
                $this->salonModel->update($id, $datos);
                header('Location: ' . BASE_URL . 'salones');
                exit;
            }
        }

        $this->view('salones/edit', [
            'errors' => $errors,
            'datos'  => $datos,
        ]);
    }

    public function delete($id)
    {
        $this->salonModel->delete($id);
        header('Location: ' . BASE_URL . 'salones');
        exit;
    }
}
