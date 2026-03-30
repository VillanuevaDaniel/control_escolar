<?php
// app/Models/AlumnoPortal.php

class AlumnoPortal
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getGrupoId($alumno_id, $ciclo_id)
    {
        $st = $this->db->prepare(
            "SELECT g.id_grupo 
             FROM alumno_grupo ag 
             JOIN grupos g ON ag.id_grupo = g.id_grupo
             WHERE ag.id_alumno = ? 
             LIMIT 1"
        );
        $st->execute([$alumno_id]);
        $rel = $st->fetch();
        return $rel ? $rel['id_grupo'] : null;
    }

    public function getHorario($grupo_id, $ciclo_id)
    {
        $st = $this->db->prepare(
            "SELECT m.*, m.nombre AS materia, p.nombre_completo AS docente, s.nombre AS salon
               FROM materias m
               LEFT JOIN profesores p ON p.id_profesor = m.id_profesor
               LEFT JOIN salones s ON s.id_salon = m.id_salon
              WHERE m.id_grupo = ? OR m.ciclo_escolar = ?
              ORDER BY FIELD(m.dia, 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES'), m.hora_inicio"
        );
        $st->execute([$grupo_id, $ciclo_id]);
        return $st->fetchAll();
    }

    public function getCalificaciones($alumno_id, $ciclo_id)
    {
        $st = $this->db->prepare(
            "SELECT m.nombre AS materia, i.id_inscripcion, c.puntaje AS calificacion, c.fecha_registro
               FROM inscripciones i
               JOIN materias m ON m.id_materia = i.id_materia
               LEFT JOIN calificaciones c ON c.id_inscripcion = i.id_inscripcion
              WHERE i.id_alumno = ?
              ORDER BY m.nombre"
        );
        $st->execute([$alumno_id]);
        return $st->fetchAll();
    }
}
