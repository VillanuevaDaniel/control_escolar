<?php
// app/Models/Reporte.php

class Reporte
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getAlumnosByGrupo($id_grupo)
    {
        $st = $this->db->prepare(
            "SELECT a.matricula, a.nombre, a.apellido_paterno, a.apellido_materno, a.genero
               FROM alumnos a
               JOIN alumno_grupo ag ON ag.id_alumno = a.id_alumno
              WHERE ag.id_grupo = ? AND a.estado = 1
              ORDER BY a.apellido_paterno, a.apellido_materno, a.nombre"
        );
        $st->execute([$id_grupo]);
        return $st->fetchAll();
    }

    public function getAlumnoByMatricula($matricula)
    {
        $st = $this->db->prepare("SELECT * FROM alumnos WHERE matricula = ?");
        $st->execute([$matricula]);
        return $st->fetch();
    }

    public function getGrupoAlumno($id_alumno)
    {
        $st = $this->db->prepare(
            "SELECT g.grado, g.seccion, g.ciclo_escolar FROM grupos g 
               JOIN alumno_grupo ag ON ag.id_grupo = g.id_grupo
              WHERE ag.id_alumno = ? LIMIT 1"
        );
        $st->execute([$id_alumno]);
        return $st->fetch();
    }

    public function getCalificacionesBoleta($id_alumno, $ciclo_escolar = null)
    {
        $query = "SELECT m.nombre AS materia, c.puntaje, c.fecha_registro, c.etiqueta_periodo
               FROM calificaciones c
               JOIN inscripciones i ON c.id_inscripcion = i.id_inscripcion
               JOIN materias m ON i.id_materia = m.id_materia
              WHERE i.id_alumno = ? AND c.estado = 'ACTIVO'";

        $params = [$id_alumno];
        if ($ciclo_escolar) {
            $query .= " AND m.ciclo_escolar = ?";
            $params[] = $ciclo_escolar;
        }

        $query .= " ORDER BY m.ciclo_escolar DESC, m.nombre";

        $st = $this->db->prepare($query);
        $st->execute($params);
        return $st->fetchAll();
    }
}
