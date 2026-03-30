<?php
// app/Controllers/MateriasController.php

class MateriasController extends Controller
{
    private $materiaModel;
    private $cicloModel;
    private $docenteModel;
    private $salonModel;
    private $grupoModel;

    public function __construct()
    {
        require_auth();
        $this->materiaModel = new Materia();
        $this->cicloModel   = new CicloEscolar();
        $this->docenteModel = new Docente();
        $this->salonModel   = new Salon();
        $this->grupoModel   = new Grupo();
    }

    public function index()
    {
        $filtros = [
            'q'      => isset($_GET['q'])      ? trim($_GET['q'])      : '',
            'estado' => isset($_GET['estado']) ? trim($_GET['estado']) : '',
        ];

        $materias = $this->materiaModel->getAll();

        if ($filtros['q']) {
            $q = strtolower($filtros['q']);
            $materias = array_filter($materias, function ($m) use ($q) {
                return strpos(strtolower($m['nombre']), $q) !== false
                    || strpos(strtolower($m['clave']),  $q) !== false
                    || strpos(strtolower($m['area']),   $q) !== false;
            });
        }
        if ($filtros['estado']) {
            $materias = array_filter($materias, function ($m) use ($filtros) {
                return $m['estado'] === $filtros['estado'];
            });
        }

        $this->view('materias/index', [
            'materias' => $materias,
            'filtros'  => $filtros,
        ]);
    }

    public function search_edit()
    {
        $materias = $this->materiaModel->getAll();
        $docentes = (new Docente())->getAll();
        $salones  = (new Salon())->getAll();
        $grupos   = (new Grupo())->getAll();
        $ciclos   = (new CicloEscolar())->getAll();

        $this->view('materias/search_edit', [
            'materias' => $materias,
            'docentes' => $docentes,
            'salones'  => $salones,
            'grupos'   => $grupos,
            'ciclos'   => $ciclos
        ]);
    }

    public function create()
    {
        $errors = [];
        $datos  = [
            'clave' => '', 'nombre' => '', 'area' => '',
            'horas' => 4, 'grado' => '', 'ciclo_id' => '',
            'estado' => 'Activo', 'descripcion' => '',
            'docente_id' => '', 'salon_id' => '', 'grupo_id' => '',
            'dia' => '', 'hora_inicio' => '', 'hora_fin' => ''
        ];
        $ciclos   = $this->cicloModel->getAll();
        $docentes = $this->docenteModel->getAll();
        $salones  = $this->salonModel->getAll();
        $grupos   = $this->grupoModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'clave'       => trim($_POST['clave']       ?? ''),
                'nombre'      => trim($_POST['nombre']      ?? ''),
                'area'        => trim($_POST['area']        ?? ''),
                'horas'       => (int) ($_POST['horas']     ?? 4),
                'grado'       => $_POST['grado']            ?? '',
                'ciclo_id'    => $_POST['ciclo_id']         ?? '',
                'estado'      => $_POST['estado']           ?? 'Activo',
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'docente_id'  => $_POST['docente_id']       ?? '',
                'salon_id'    => $_POST['salon_id']         ?? '',
                'grupo_id'    => $_POST['grupo_id']         ?? '',
                'dia'         => $_POST['dia']              ?? '',
                'hora_inicio' => $_POST['hora_inicio']      ?? '',
                'hora_fin'    => $_POST['hora_fin']         ?? '',
            ];

            if ($datos['nombre'] === '') {
                $errors[] = 'El nombre de la materia es obligatorio.';
            }

            if (empty($errors)) {
                $this->materiaModel->create($datos);
                header('Location: ' . BASE_URL . 'materias');
                exit;
            }
        }

        $this->view('materias/create', [
            'errors'   => $errors,
            'datos'    => $datos,
            'ciclos'   => $ciclos,
            'docentes' => $docentes,
            'salones'  => $salones,
            'grupos'   => $grupos,
        ]);
    }

    public function edit($id)
    {
        $materia = $this->materiaModel->getById($id);
        if (!$materia) {
            header('Location: ' . BASE_URL . 'materias');
            exit;
        }

        $errors = [];
        $datos  = $materia;
        $ciclos   = $this->cicloModel->getAll();
        $docentes = $this->docenteModel->getAll();
        $salones  = $this->salonModel->getAll();
        $grupos   = $this->grupoModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'id_materia'  => $id,
                'clave'       => trim($_POST['clave']       ?? ''),
                'nombre'      => trim($_POST['nombre']      ?? ''),
                'area'        => trim($_POST['area']        ?? ''),
                'horas'       => (int) ($_POST['horas']     ?? 4),
                'grado'       => $_POST['grado']            ?? '',
                'ciclo_id'    => $_POST['ciclo_id']         ?? '',
                'estado'      => $_POST['estado']           ?? 'Activo',
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'docente_id'  => $_POST['docente_id']       ?? '',
                'salon_id'    => $_POST['salon_id']         ?? '',
                'grupo_id'    => $_POST['grupo_id']         ?? '',
                'dia'         => $_POST['dia']              ?? '',
                'hora_inicio' => $_POST['hora_inicio']      ?? '',
                'hora_fin'    => $_POST['hora_fin']         ?? '',
            ];

            if ($datos['nombre'] === '') {
                $errors[] = 'El nombre de la materia es obligatorio.';
            }

            if (empty($errors)) {
                $this->materiaModel->update($id, $datos);
                header('Location: ' . BASE_URL . 'materias');
                exit;
            }
        }

        $this->view('materias/edit', [
            'errors'   => $errors,
            'datos'    => $datos,
            'ciclos'   => $ciclos,
            'docentes' => $docentes,
            'salones'  => $salones,
            'grupos'   => $grupos,
        ]);
    }

    public function delete($id)
    {
        $this->materiaModel->delete($id);
        header('Location: ' . BASE_URL . 'materias');
        exit;
    }
}
