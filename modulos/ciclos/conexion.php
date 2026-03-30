<?php
// modulos/ciclos/conexion.php — Modelo CicloEscolar

class CicloEscolar
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getAll()
    {
        $st = $this->db->query(
            "SELECT * FROM ciclos_escolares ORDER BY fecha_inicio DESC"
        );
        return $st->fetchAll();
    }

    public function getById($id)
    {
        $st = $this->db->prepare(
            "SELECT * FROM ciclos_escolares WHERE id = ?"
        );
        $st->execute([$id]);
        return $st->fetch();
    }

    public function getActivo()
    {
        $st = $this->db->query(
            "SELECT * FROM ciclos_escolares WHERE estado = 'Activo' LIMIT 1"
        );
        return $st->fetch();
    }

    public function create($datos)
    {
        $st = $this->db->prepare(
            "INSERT INTO ciclos_escolares (nombre, fecha_inicio, fecha_fin, estado)
             VALUES (?, ?, ?, ?)"
        );
        $st->execute([
            $datos['nombre'],
            $datos['fecha_inicio'],
            $datos['fecha_fin'],
            $datos['estado'],
        ]);
        return $this->db->lastInsertId();
    }

    public function activar($id)
    {
        // Cerrar el ciclo activo actual
        $this->db->exec(
            "UPDATE ciclos_escolares SET estado = 'Cerrado' WHERE estado = 'Activo'"
        );
        // Activar el ciclo seleccionado
        $st = $this->db->prepare(
            "UPDATE ciclos_escolares SET estado = 'Activo' WHERE id = ?"
        );
        return $st->execute([$id]);
    }
}
