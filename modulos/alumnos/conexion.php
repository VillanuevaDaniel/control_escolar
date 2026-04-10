<?php
// app/Models/Alumno.php

class Alumno
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getAll()
    {
        $st = $this->db->query("SELECT * FROM alumnos ORDER BY nombre");
        return $st->fetchAll();
    }

    public function getById($id)
    {
        $st = $this->db->prepare("SELECT * FROM alumnos WHERE id_alumno = ?");
        $st->execute([$id]);
        return $st->fetch();
    }

    public function create($datos, $id_usuario = null)
    {
        $st = $this->db->prepare(
            "INSERT INTO alumnos (id_usuario, matricula, nombre, apellido_paterno, apellido_materno, curp, genero, fecha_nac, domicilio, escuela_procedencia, ruta_foto, nombre_tutor, telefono_tutor, comentarios, estado)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
        );
        return $st->execute(array(
            $id_usuario,
            $datos['matricula'],
            $datos['nombre'],
            $datos['apellido_paterno'],
            $datos['apellido_materno'],
            $datos['curp'],
            $datos['genero'],
            $datos['fecha_nac'] ?? null,
            $datos['domicilio'],
            $datos['escuela_procedencia'],
            $datos['ruta_foto'] ?? null,
            $datos['nombre_tutor'],
            $datos['telefono_tutor'],
            $datos['comentarios'],
            $datos['estado'] ?? 1
        ));
    }

    public function update($id, $datos)
    {
        $st = $this->db->prepare(
            "UPDATE alumnos SET matricula=?, nombre=?, apellido_paterno=?, apellido_materno=?, curp=?, genero=?, fecha_nac=?, domicilio=?, escuela_procedencia=?, ruta_foto=?, nombre_tutor=?, telefono_tutor=?, comentarios=?, estado=?
             WHERE id_alumno=?"
        );
        return $st->execute(array(
            $datos['matricula'],
            $datos['nombre'],
            $datos['apellido_paterno'],
            $datos['apellido_materno'],
            $datos['curp'],
            $datos['genero'],
            $datos['fecha_nac'] ?? null,
            $datos['domicilio'],
            $datos['escuela_procedencia'],
            $datos['ruta_foto'] ?? null,
            $datos['nombre_tutor'],
            $datos['telefono_tutor'],
            $datos['comentarios'],
            $datos['estado'],
            $id
        ));
    }

    public function delete($id)
    {
        $st = $this->db->prepare("DELETE FROM alumnos WHERE id_alumno = ?");
        return $st->execute([$id]);
    }
}
