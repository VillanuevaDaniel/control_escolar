<?php
// app/Models/Horario.php

class Horario
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getAll()
    {
        $st = $this->db->query(
            "SELECT m.*,
                    m.nombre AS materia,
                    p.nombre_completo AS profesor,
                    SUBSTRING_INDEX(p.nombre_completo, ' ', 1)  AS docente_n,
                    SUBSTRING_INDEX(p.nombre_completo, ' ', -2) AS docente_ap,
                    s.nombre AS salon,
                    CONCAT(g.grado, g.seccion) AS grupo
             FROM materias m
             LEFT JOIN profesores p ON m.id_profesor = p.id_profesor
             LEFT JOIN salones s ON m.id_salon = s.id_salon
             LEFT JOIN grupos g ON m.id_grupo = g.id_grupo
             ORDER BY m.ciclo_escolar DESC, m.dia, m.hora_inicio"
        );
        return $st->fetchAll();
    }

    public function getById($id)
    {
        $st = $this->db->prepare("SELECT * FROM materias WHERE id_materia = ?");
        $st->execute([$id]);
        return $st->fetch();
    }

    public function create($datos)
    {
        return false; // ahora se hace desde materias
    }

    public function update($id, $datos)
    {
        return false; // ahora se hace desde materias
    }

    public function delete($id)
    {
        return false; // ahora se hace desde materias
    }
}
