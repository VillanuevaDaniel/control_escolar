<?php
// app/Controllers/AlumnosController.php

class AlumnosController extends Controller
{
    private $alumnoModel;

    public function __construct()
    {
        require_auth();
        $this->alumnoModel = new Alumno();
    }

    public function index()
    {
        $filtros = [
            'q' => isset($_GET['q']) ? trim($_GET['q']) : '',
            'estado' => isset($_GET['estado']) ? trim($_GET['estado']) : ''
        ];

        $alumnos = $this->alumnoModel->getAll();

        if ($filtros['estado']) {
            $estado_val = ($filtros['estado'] === 'Activo') ? 1 : 0;
            $alumnos = array_filter($alumnos, function ($a) use ($estado_val) {
                return (int)$a['estado'] === $estado_val;
            });
        }
        if ($filtros['q']) {
            $q = strtolower($filtros['q']);
            $alumnos = array_filter($alumnos, function ($a) use ($q) {
                return strpos(strtolower($a['nombre']), $q) !== false ||
                    strpos(strtolower($a['apellido_paterno']), $q) !== false ||
                    strpos(strtolower($a['matricula']), $q) !== false;
            });
        }

        $modulo_activo = 'alumnos';
        $this->view('alumnos/index', [
            'alumnos' => $alumnos,
            'modulo_activo' => $modulo_activo,
            'filtros' => $filtros
        ]);
    }

    public function search_edit()
    {
        $alumnos = $this->alumnoModel->getAll();
        
        // Incluir login_id en la lista para el buscador si no está
        foreach ($alumnos as &$a) {
            $a['login_id'] = $a['id_usuario'] ? 'ID:'.$a['id_usuario'] : 'Sin usuario';
            // Mapear para que el autocompletado lo tenga listo (opcional ya que el JS lo hace, pero mejor ser consistentes)
        }

        $modulo_activo = 'alumnos';
        $grupos = []; // TODO: Cargar grupos reales
        
        $this->view('alumnos/search_edit', [
            'alumnos' => $alumnos,
            'grupos' => $grupos,
            'modulo_activo' => $modulo_activo
        ]);
    }

    public function create()
    {
        $datos = [
            'matricula' => '',
            'nombre' => '',
            'apellido_paterno' => '',
            'apellido_materno' => '',
            'curp' => '',
            'genero' => '',
            'fecha_nac' => '',
            'escuela_procedencia' => '',
            'direccion' => '',
            'grupo_id' => '',
            'tutor_nombre' => '',
            'tutor_telefono' => '',
            'comentarios_familia' => '',
            'login_id' => '',
            'estado' => 1
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'matricula' => trim($_POST['matricula']),
                'nombre' => trim($_POST['nombre']),
                'apellido_paterno' => trim($_POST['apellido_p'] ?? ''),
                'apellido_materno' => trim($_POST['apellido_m'] ?? ''),
                'curp' => trim($_POST['curp']),
                'genero' => $_POST['sexo'] ?? '',
                'fecha_nac' => $_POST['fecha_nac'] ?? null,
                'domicilio' => trim($_POST['direccion'] ?? ''),
                'escuela_procedencia' => trim($_POST['escuela_procedencia'] ?? ''),
                'nombre_tutor' => trim($_POST['tutor_nombre'] ?? ''),
                'telefono_tutor' => trim($_POST['tutor_telefono'] ?? ''),
                'comentarios' => trim($_POST['comentarios_familia'] ?? ''),
                'estado' => isset($_POST['estado']) && $_POST['estado'] !== 'Inactivo' && $_POST['estado'] !== 'Baja' ? 1 : 0
            ];

            // Subir foto si existe
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                // ... lógica de foto
            }

            $this->alumnoModel->create($datos);
            header('Location: ' . BASE_URL . 'alumnos');
            exit;
        }
        $modulo_activo = 'alumnos';
        $grupos = []; // TODO: Cargar grupos reales del modelo cuando exista
        $this->view('alumnos/create', ['modulo_activo' => $modulo_activo, 'datos' => $datos, 'grupos' => $grupos, 'errors' => []]);
    }

    public function edit($id)
    {
        $alumno = $this->alumnoModel->getById($id);
        if (!$alumno) {
            header('Location: ' . BASE_URL . 'alumnos');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'matricula' => trim($_POST['matricula']),
                'nombre' => trim($_POST['nombre']),
                'apellido_paterno' => trim($_POST['apellido_p'] ?? ''),
                'apellido_materno' => trim($_POST['apellido_m'] ?? ''),
                'curp' => trim($_POST['curp']),
                'genero' => $_POST['sexo'] ?? '',
                'fecha_nac' => $_POST['fecha_nac'] ?? null,
                'domicilio' => trim($_POST['direccion'] ?? ''),
                'escuela_procedencia' => trim($_POST['escuela_procedencia'] ?? ''),
                'nombre_tutor' => trim($_POST['tutor_nombre'] ?? ''),
                'telefono_tutor' => trim($_POST['tutor_telefono'] ?? ''),
                'comentarios' => trim($_POST['comentarios_familia'] ?? ''),
                'estado' => isset($_POST['estado']) && $_POST['estado'] !== 'Inactivo' && $_POST['estado'] !== 'Baja' ? 1 : 0
            ];
            $this->alumnoModel->update($id, $datos);
            header('Location: ' . BASE_URL . 'alumnos');
            exit;
        }
        if ($alumno) {
            $alumno['direccion'] = $alumno['domicilio'];
            $alumno['tutor_nombre'] = $alumno['nombre_tutor'];
            $alumno['tutor_telefono'] = $alumno['telefono_tutor'];
            $alumno['comentarios_familia'] = $alumno['comentarios'];
            $alumno['estado'] = $alumno['estado'] ? 'Activo' : 'Inactivo';
            // Mapear género de M/F a Masculino/Femenino
            if ($alumno['genero'] == 'M') $alumno['genero'] = 'Masculino';
            if ($alumno['genero'] == 'F') $alumno['genero'] = 'Femenino';
        }
        $modulo_activo = 'alumnos';
        $this->view('alumnos/edit', ['datos' => $alumno, 'grupos' => [], 'modulo_activo' => $modulo_activo, 'errors' => []]);
    }

    public function delete($id)
    {
        $this->alumnoModel->delete($id);
        header('Location: ' . BASE_URL . 'alumnos');
        exit;
    }
}
