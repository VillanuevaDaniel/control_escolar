<?php
// app/Controllers/GruposController.php

class GruposController extends Controller
{
    private $grupoModel;
    private $cicloModel;

    public function __construct()
    {
        require_auth();
        $this->grupoModel = new Grupo();
        $this->cicloModel = new CicloEscolar();
    }

    public function index()
    {
        $grupos = $this->grupoModel->getAll();
        $this->view('grupos/index', ['grupos' => $grupos]);
    }

    public function create()
    {
        $errors = [];
        $datos  = [
            'nombre' => '', 'grado' => '', 'seccion' => '',
            'ciclo_escolar' => '', 'capacidad' => '', 'turno' => 'Matutino'
        ];
        $ciclos = $this->cicloModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'       => trim($_POST['nombre']       ?? ''),
                'grado'        => trim($_POST['grado']        ?? ''),
                'seccion'      => trim($_POST['seccion']      ?? ''),
                'ciclo_escolar'=> trim($_POST['ciclo_id']     ?? ''),
                'capacidad'    => (int) ($_POST['capacidad_max'] ?? 0),
                'turno'        => $_POST['turno']             ?? 'Matutino',
            ];

            if ($datos['nombre'] === '') {
                $errors[] = 'El nombre del grupo es obligatorio.';
            }
            if ($datos['grado'] === '') {
                $errors[] = 'El grado es obligatorio.';
            }

            if (empty($errors)) {
                $this->grupoModel->create($datos);
                header('Location: ' . BASE_URL . 'grupos');
                exit;
            }
        }

        $this->view('grupos/create', [
            'errors' => $errors,
            'datos'  => $datos,
            'ciclos' => $ciclos,
        ]);
    }

    public function edit($id)
    {
        $grupo = $this->grupoModel->getById($id);
        if (!$grupo) {
            header('Location: ' . BASE_URL . 'grupos');
            exit;
        }

        $errors = [];
        $datos  = $grupo;
        $ciclos = $this->cicloModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = array_merge($grupo, [
                'nombre'       => trim($_POST['nombre']       ?? ''),
                'grado'        => trim($_POST['grado']        ?? ''),
                'seccion'      => trim($_POST['seccion']      ?? ''),
                'ciclo_escolar'=> trim($_POST['ciclo_id']     ?? ''),
                'capacidad'    => (int) ($_POST['capacidad_max'] ?? 0),
                'turno'        => $_POST['turno']             ?? 'Matutino',
            ]);

            if ($datos['nombre'] === '') {
                $errors[] = 'El nombre del grupo es obligatorio.';
            }

            if (empty($errors)) {
                $this->grupoModel->update($id, $datos);
                header('Location: ' . BASE_URL . 'grupos');
                exit;
            }
        }

        $this->view('grupos/edit', [
            'errors' => $errors,
            'datos'  => $datos,
            'ciclos' => $ciclos,
        ]);
    }

    public function delete($id)
    {
        $this->grupoModel->delete($id);
        header('Location: ' . BASE_URL . 'grupos');
        exit;
    }
}
