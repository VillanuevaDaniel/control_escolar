<?php
// app/Models/Calificacion.php

class Calificacion
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getAll()
    {
        $st = $this->db->query(
            "SELECT c.*, i.id_alumno, a.matricula, a.nombre, a.apellido_paterno, m.id_materia, m.nombre AS materia
             FROM calificaciones c
             JOIN inscripciones i ON c.id_inscripcion = i.id_inscripcion
             JOIN alumnos a ON i.id_alumno = a.id_alumno
             JOIN materias m ON i.id_materia = m.id_materia
             ORDER BY c.fecha_registro DESC"
        );
        return $st->fetchAll();
    }

    public function getById($id)
    {
        $st = $this->db->prepare("SELECT * FROM calificaciones WHERE id_calificacion = ?");
        $st->execute([$id]);
        return $st->fetch();
    }

    public function create($datos)
    {
        $st = $this->db->prepare(
            "INSERT INTO calificaciones (id_inscripcion, etiqueta_periodo, puntaje, estado)
             VALUES (?,?,?,?)"
        );
        return $st->execute(array(
            $datos['id_inscripcion'],
            $datos['etiqueta_periodo'],
            $datos['puntaje'],
            $datos['estado'] ?? 'ACTIVO'
        ));
    }

    public function update($id, $datos)
    {
        $st = $this->db->prepare(
            "UPDATE calificaciones SET id_inscripcion=?, etiqueta_periodo=?, puntaje=?, estado=?
             WHERE id_calificacion=?"
        );
        return $st->execute(array(
            $datos['id_inscripcion'],
            $datos['etiqueta_periodo'],
            $datos['puntaje'],
            $datos['estado'],
            $id
        ));
    }

    public function delete($id)
    {
        $st = $this->db->prepare("DELETE FROM calificaciones WHERE id_calificacion = ?");
        return $st->execute([$id]);
    }

    public function getByInscripcion($id_inscripcion)
    {
        $st = $this->db->prepare("SELECT * FROM calificaciones WHERE id_inscripcion = ? ORDER BY fecha_registro ASC");
        $st->execute([$id_inscripcion]);
        return $st->fetchAll();
    }
}
