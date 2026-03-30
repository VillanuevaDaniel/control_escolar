<?php
// app/Controllers/HorariosController.php
// (Maneja las Ofertas de Horario)

class HorariosController extends Controller
{
    private $horarioModel;
    private $materiaModel;
    private $docenteModel;
    private $salonModel;
    private $grupoModel;
    private $cicloModel;

    public function __construct()
    {
        require_auth();
        $this->horarioModel = new Horario();
        $this->materiaModel = new Materia();
        $this->docenteModel = new Docente();
        $this->salonModel   = new Salon();
        $this->grupoModel   = new Grupo();
        $this->cicloModel   = new CicloEscolar();
    }

    public function index()
    {
        $u     = session_user();
        $ciclo = $this->cicloModel->getActivo();

        $filtros = [
            'grupo_id'   => (int) ($_GET['grupo']   ?? 0),
            'docente_id' => (int) ($_GET['docente'] ?? 0),
            'salon_id'   => (int) ($_GET['salon']   ?? 0),
        ];

        $grupos   = $this->grupoModel->getAll();
        $docentes = $this->docenteModel->getAll();
        $salones  = $this->salonModel->getAll();
        $ofertas  = $this->horarioModel->getAll();

        // Organizar por día para el grid
        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes'];
        $grid = [];
        foreach ($dias as $d) {
            $grid[$d] = [];
        }
        foreach ($ofertas as $o) {
            $dia = ucfirst(strtolower($o['dia'] ?? ''));
            if (isset($grid[$dia])) {
                $grid[$dia][] = $o;
            }
        }

        $this->view('horarios/index', [
            'u'        => $u,
            'ciclo'    => $ciclo,
            'filtros'  => $filtros,
            'grupos'   => $grupos,
            'docentes' => $docentes,
            'salones'  => $salones,
            'dias'     => $dias,
            'grid'     => $grid,
        ]);
    }

    public function create()
    {
        $errors   = [];
        $warnings = [];
        $datos    = [
            'materia_id'  => '', 'docente_id' => '', 'salon_id'   => '',
            'grupo_id'    => '', 'dia'        => '', 'hora_inicio' => '',
            'hora_fin'    => '', 'ciclo_id'   => '',
        ];

        $materias = $this->materiaModel->getAll();
        $docentes = $this->docenteModel->getAll();
        $salones  = $this->salonModel->getAll();
        $grupos   = $this->grupoModel->getAll();
        $ciclos   = $this->cicloModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'materia_id'  => $_POST['materia_id']  ?? '',
                'docente_id'  => $_POST['docente_id']  ?? '',
                'salon_id'    => $_POST['salon_id']    ?? '',
                'grupo_id'    => $_POST['grupo_id']    ?? '',
                'dia'         => $_POST['dia']         ?? '',
                'hora_inicio' => $_POST['hora_inicio'] ?? '',
                'hora_fin'    => $_POST['hora_fin']    ?? '',
                'ciclo_id'    => $_POST['ciclo_id']    ?? '',
            ];

            if (empty($datos['materia_id'])) $errors[] = 'La materia es obligatoria.';
            if (empty($datos['docente_id'])) $errors[] = 'El docente es obligatorio.';
            if (empty($datos['dia']))        $errors[] = 'El día es obligatorio.';
            if (empty($datos['hora_inicio'])) $errors[] = 'La hora de inicio es obligatoria.';
            if (empty($datos['hora_fin']))   $errors[] = 'La hora de fin es obligatoria.';

            if (empty($errors)) {
                $guardado = [
                    'id_materia'   => $datos['materia_id'],
                    'id_profesor'  => $datos['docente_id'],
                    'id_salon'     => $datos['salon_id']   ?: null,
                    'id_grupo'     => $datos['grupo_id']   ?: null,
                    'dia'          => strtoupper($datos['dia']),
                    'hora_inicio'  => $datos['hora_inicio'],
                    'hora_fin'     => $datos['hora_fin'],
                    'ciclo_escolar'=> $datos['ciclo_id']   ?? '',
                    'estado'       => 1,
                ];
                $this->horarioModel->create($guardado);
                header('Location: ' . BASE_URL . 'horarios');
                exit;
            }
        }

        $this->view('horarios/create', [
            'errors'   => $errors,
            'warnings' => $warnings,
            'datos'    => $datos,
            'materias' => $materias,
            'docentes' => $docentes,
            'salones'  => $salones,
            'grupos'   => $grupos,
            'ciclos'   => $ciclos,
        ]);
    }

    public function edit($id)
    {
        $oferta = $this->horarioModel->getById($id);
        if (!$oferta) {
            header('Location: ' . BASE_URL . 'horarios');
            exit;
        }

        $errors   = [];
        $warnings = [];
        $datos    = [
            'materia_id'  => $oferta['id_materia']  ?? '',
            'docente_id'  => $oferta['id_profesor']  ?? '',
            'salon_id'    => $oferta['id_salon']     ?? '',
            'grupo_id'    => $oferta['id_grupo']     ?? '',
            'dia'         => $oferta['dia']          ?? '',
            'hora_inicio' => $oferta['hora_inicio']  ?? '',
            'hora_fin'    => $oferta['hora_fin']     ?? '',
            'ciclo_id'    => $oferta['ciclo_escolar'] ?? '',
        ];

        $materias = $this->materiaModel->getAll();
        $docentes = $this->docenteModel->getAll();
        $salones  = $this->salonModel->getAll();
        $grupos   = $this->grupoModel->getAll();
        $ciclos   = $this->cicloModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'materia_id'  => $_POST['materia_id']  ?? '',
                'docente_id'  => $_POST['docente_id']  ?? '',
                'salon_id'    => $_POST['salon_id']    ?? '',
                'grupo_id'    => $_POST['grupo_id']    ?? '',
                'dia'         => $_POST['dia']         ?? '',
                'hora_inicio' => $_POST['hora_inicio'] ?? '',
                'hora_fin'    => $_POST['hora_fin']    ?? '',
                'ciclo_id'    => $_POST['ciclo_id']    ?? '',
            ];

            if (empty($datos['materia_id'])) $errors[] = 'La materia es obligatoria.';

            if (empty($errors)) {
                $guardado = [
                    'id_materia'   => $datos['materia_id'],
                    'id_profesor'  => $datos['docente_id'],
                    'id_salon'     => $datos['salon_id']   ?: null,
                    'id_grupo'     => $datos['grupo_id']   ?: null,
                    'dia'          => strtoupper($datos['dia']),
                    'hora_inicio'  => $datos['hora_inicio'],
                    'hora_fin'     => $datos['hora_fin'],
                    'ciclo_escolar'=> $datos['ciclo_id'] ?? '',
                    'estado'       => isset($_POST['estado']) ? 1 : 0,
                ];
                $this->horarioModel->update($id, $guardado);
                header('Location: ' . BASE_URL . 'horarios');
                exit;
            }
        }

        $this->view('horarios/edit', [
            'oferta'   => $oferta,
            'errors'   => $errors,
            'warnings' => $warnings,
            'datos'    => $datos,
            'materias' => $materias,
            'docentes' => $docentes,
            'salones'  => $salones,
            'grupos'   => $grupos,
            'ciclos'   => $ciclos,
        ]);
    }

    public function delete($id)
    {
        $this->horarioModel->delete($id);
        header('Location: ' . BASE_URL . 'horarios');
        exit;
    }
}
