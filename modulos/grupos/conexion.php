<?php
class Grupo
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getAll()
    {
        $st = $this->db->query("SELECT * FROM grupos ORDER BY ciclo_escolar DESC, grado, seccion");
        $rows = $st->fetchAll();
        return array_map([$this, '_defaults'], $rows);
    }

    public function getById($id)
    {
        $st = $this->db->prepare("SELECT * FROM grupos WHERE id_grupo = ?");
        $st->execute([$id]);
        $row = $st->fetch();
        return $row ? $this->_defaults($row) : false;
    }

    /** Rellena campos calculados/virtuales que la vista necesita */
    private function _defaults($row)
    {
        $nombre = ($row['grado'] ?? '') . ($row['seccion'] ?? '');
        return array_merge([
            'nombre'       => $nombre ?: 'Sin nombre',
            'total_alumnos'=> 0,
            'capacidad'    => 30,
            'ciclo_nombre' => $row['ciclo_escolar'] ?? 'Sin ciclo',
        ], $row);
    }

    public function create($datos)
    {
        $st = $this->db->prepare(
            "INSERT INTO grupos (grado, seccion, ciclo_escolar, turno)
             VALUES (?,?,?,?)"
        );
        $st->execute(array(
            $datos['grado'],
            $datos['seccion'],
            $datos['ciclo_escolar'],
            $datos['turno']
        ));
        return $this->db->lastInsertId();
    }

    public function update($id, $datos)
    {
        $st = $this->db->prepare(
            "UPDATE grupos SET grado=?, seccion=?, ciclo_escolar=?, turno=?
             WHERE id_grupo=?"
        );
        return $st->execute(array(
            $datos['grado'],
            $datos['seccion'],
            $datos['ciclo_escolar'],
            $datos['turno'],
            $id
        ));
    }

    public function delete($id)
    {
        $st = $this->db->prepare("DELETE FROM grupos WHERE id_grupo = ?");
        return $st->execute([$id]);
    }
}
