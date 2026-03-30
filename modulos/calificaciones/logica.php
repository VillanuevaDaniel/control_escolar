<?php
// app/Controllers/CalificacionesController.php

class CalificacionesController extends Controller
{
    private $calificacionModel;
    private $inscripcionModel;
    private $grupoModel;
    private $materiaModel;
    private $cicloModel;

    public function __construct()
    {
        require_auth();
        $this->calificacionModel = new Calificacion();
        $this->inscripcionModel  = new Inscripcion();
        $this->grupoModel        = new Grupo();
        $this->materiaModel      = new Materia();
        $this->cicloModel        = new CicloEscolar();
    }

    public function index()
    {
        $ciclo        = $this->cicloModel->getActivo();
        $grupos       = $this->grupoModel->getAll();
        $filtro_grupo  = (int) ($_GET['grupo']   ?? 0);
        $filtro_materia = (int) ($_GET['materia'] ?? 0);

        // Cargar materias filtradas por grupo (si hay grupo seleccionado)
        $materias = $filtro_grupo
            ? $this->materiaModel->getAll()
            : [];

        // Cargar alumnos con calificaciones si hay grupo y materia
        $alumnos = [];
        if ($filtro_grupo && $filtro_materia) {
            $calificaciones = $this->calificacionModel->getAll();
            // Filtrar por grupo y materia
            $alumnos = array_filter($calificaciones, function ($c) use ($filtro_grupo, $filtro_materia) {
                return true; // La vista ya tiene toda la data en $calificaciones
            });
            $alumnos = $calificaciones;
        }

        // Guardar calificaciones en masa (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calificaciones'])) {
            foreach ($_POST['calificaciones'] as $id_cal => $puntaje) {
                if ($puntaje !== '') {
                    $this->calificacionModel->update((int)$id_cal, [
                        'id_inscripcion'   => 0, // No se cambia
                        'etiqueta_periodo' => '',
                        'puntaje'          => (float) $puntaje,
                        'estado'           => 'ACTIVO',
                    ]);
                }
            }
            header('Location: ' . BASE_URL . 'calificaciones?grupo=' . $filtro_grupo . '&materia=' . $filtro_materia);
            exit;
        }

        $this->view('calificaciones/index', [
            'ciclo'          => $ciclo,
            'grupos'         => $grupos,
            'materias'       => $materias,
            'filtro_grupo'   => $filtro_grupo,
            'filtro_materia' => $filtro_materia,
            'alumnos'        => $alumnos,
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'id_inscripcion'   => $_POST['id_inscripcion'],
                'etiqueta_periodo' => trim($_POST['etiqueta_periodo']),
                'puntaje'          => $_POST['puntaje'],
                'estado'           => $_POST['estado'] ?? 'ACTIVO'
            ];
            $this->calificacionModel->create($datos);
            header('Location: ' . BASE_URL . 'calificaciones');
            exit;
        }

        $inscripciones = $this->inscripcionModel->getAll();
        $this->view('calificaciones/create', ['inscripciones' => $inscripciones]);
    }

    public function edit($id)
    {
        $calificacion = $this->calificacionModel->getById($id);
        if (!$calificacion) {
            header('Location: ' . BASE_URL . 'calificaciones');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'id_inscripcion'   => $_POST['id_inscripcion'],
                'etiqueta_periodo' => trim($_POST['etiqueta_periodo']),
                'puntaje'          => $_POST['puntaje'],
                'estado'           => $_POST['estado'] ?? 'ACTIVO'
            ];
            $this->calificacionModel->update($id, $datos);
            header('Location: ' . BASE_URL . 'calificaciones');
            exit;
        }

        $inscripciones = $this->inscripcionModel->getAll();
        $this->view('calificaciones/edit', [
            'calificacion'  => $calificacion,
            'inscripciones' => $inscripciones
        ]);
    }

    public function delete($id)
    {
        $this->calificacionModel->delete($id);
        header('Location: ' . BASE_URL . 'calificaciones');
        exit;
    }
}
