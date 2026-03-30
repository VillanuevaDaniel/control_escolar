<?php
// app/Controllers/UsuariosController.php

class UsuariosController extends Controller
{
    private $usuarioModel;

    public function __construct()
    {
        require_auth();
        // solo_director(); // O admin real
        $this->usuarioModel = new Usuario();
    }

    public function index()
    {
        $usuarios = $this->usuarioModel->getAll();
        $this->view('usuarios/index', ['usuarios' => $usuarios]);
    }

    public function search_edit()
    {
        $usuarios = $this->usuarioModel->getAll();
        $this->view('usuarios/search_edit', [
            'usuarios' => $usuarios
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre_usuario' => trim($_POST['nombre_usuario']),
                'estado' => isset($_POST['estado']) ? 1 : 0
            ];
            $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
            $this->usuarioModel->create($datos, $contrasena);
            header('Location: ' . BASE_URL . 'usuarios');
            exit;
        }
        $this->view('usuarios/create');
    }

    public function edit($id)
    {
        $usuario = $this->usuarioModel->getById($id);
        if (!$usuario) {
            header('Location: ' . BASE_URL . 'usuarios');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre_usuario' => trim($_POST['nombre_usuario']),
                'estado' => isset($_POST['estado']) ? 1 : 0
            ];
            $contrasena = !empty($_POST['contrasena']) ? password_hash($_POST['contrasena'], PASSWORD_DEFAULT) : null;
            $this->usuarioModel->update($id, $datos, $contrasena);
            header('Location: ' . BASE_URL . 'usuarios');
            exit;
        }
        $this->view('usuarios/edit', ['usuario' => $usuario]);
    }

    public function delete($id)
    {
        $this->usuarioModel->delete($id);
        header('Location: ' . BASE_URL . 'usuarios');
        exit;
    }
}
