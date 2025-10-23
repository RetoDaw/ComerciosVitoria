<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ComerciosModel.php';
require_once __DIR__ . '/../models/UsuariosModel.php';

class UsuariosController extends BaseController {

    public function index() {
        $usuarios = UsuariosModel::getDatosMostrar();

        $this-> render('usuarios.view.php' ,[
            'usuarios' => $usuarios
        ]);
    }

    public function datosContacto() {
        $id = $_GET['id'];
        echo json_encode(UsuariosModel::getDatosContacto($id));
    }

    public function editar($id){
        session_start();
        $id = $_SESSION['id'];

        $usuario = UsuariosModel::getById($id);

        $this-> render('usuarios_edit_view.php',[
            'usuario' => $usuario
        ]);
    }      
    
    public function update($id){
        session_start();
        $id = $_SESSION['id'];

        $usuario = array(
            "id" => trim($_POST["id"]),
            "nombre" => trim($_POST["nombre"]),
            "apellidos" => trim($_POST["apellidos"]),
            "email" => trim($_POST["email"]),
            "fecha_nacimiento" => trim($_POST["fecha_nacimiento"]),
            "telefono" => trim($_POST["telefono"]),
        );

        $this->redirect('index.php?action=usuarios');
    }

    public function store($datos) {

    }
    
    public function destroy($id) {

    }
    
    public function destroyAll() {

    }
}