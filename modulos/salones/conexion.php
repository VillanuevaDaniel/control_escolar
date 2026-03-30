<?php
// app/Models/Salon.php

class Salon
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getAll()
    {
        $st = $this->db->query("SELECT * FROM salones ORDER BY nombre");
        $rows = $st->fetchAll();
        return array_map([$this, '_defaults'], $rows);
    }

    public function getById($id)
    {
        $st = $this->db->prepare("SELECT * FROM salones WHERE id_salon = ?");
        $st->execute([$id]);
        $row = $st->fetch();
        return $row ? $this->_defaults($row) : false;
    }

    /** Rellena campos extra que la vista usa pero no están en el schema */
    private function _defaults($row)
    {
        return array_merge([
            'edificio'    => '',
            'tipo'        => 'Aula',
            'estado'      => 'Activo',
            'descripcion' => '',
        ], $row);
    }

    public function create($datos)
    {
        $st = $this->db->prepare(
            "INSERT INTO salones (nombre, capacidad)
             VALUES (?,?)"
        );
        return $st->execute(array(
            $datos['nombre'],
            $datos['capacidad']
        ));
    }

    public function update($id, $datos)
    {
        $st = $this->db->prepare(
            "UPDATE salones SET nombre=?, capacidad=?
             WHERE id_salon=?"
        );
        return $st->execute(array(
            $datos['nombre'],
            $datos['capacidad'],
            $id
        ));
    }

    public function delete($id)
    {
        $st = $this->db->prepare("DELETE FROM salones WHERE id_salon = ?");
        return $st->execute([$id]);
    }
}
