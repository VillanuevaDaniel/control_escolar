<?php
// app/Controllers/DashboardController.php

class DashboardController extends Controller
{

    public function index()
    {
        require_once 'config/init.php';
        require_auth();

        $u   = session_user();
        $pdo = db_connect();

        $mis_horarios_hoy = array();
        if ($u['tipo'] === 'docente' || $u['rol'] === 'profesor') {
            $dias_es = array(
                'Monday'    => 'LUNES',
                'Tuesday'   => 'MARTES',
                'Wednesday' => 'MIERCOLES',
                'Thursday'  => 'JUEVES',
                'Friday'    => 'VIERNES',
            );
            $hoy = $dias_es[date('l')] ?? '';
            // Get id_profesor based on user id_usuario
            $stProf = $pdo->prepare("SELECT id_profesor FROM profesores WHERE id_usuario = ?");
            $stProf->execute([$u['id']]);
            $profesor = $stProf->fetchColumn();

            if ($hoy && $profesor) {
                $st = $pdo->prepare(
                    "SELECT m.hora_inicio, m.hora_fin, m.nombre AS materia, g.grado, g.seccion, s.nombre AS salon
                           FROM materias m
                           LEFT JOIN grupos g ON g.id_grupo = m.id_grupo
                           LEFT JOIN salones  s ON s.id_salon = m.id_salon
                          WHERE m.id_profesor = ? AND m.dia = ? 
                          ORDER BY m.hora_inicio"
                );
                $st->execute(array($profesor, $hoy));
                $mis_horarios_hoy = $st->fetchAll();
            }
        }

        $this->view('dashboard/index', [
            'u' => $u,
            'mis_horarios_hoy' => $mis_horarios_hoy
        ]);
    }
}
