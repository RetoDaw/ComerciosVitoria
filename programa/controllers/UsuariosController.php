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

    public function editar(){
        session_start();
        $id = $_SESSION['id'];

        $usuario = UsuariosModel::getById($id);

        $this-> render('usuarios_edit_view.php',[
            'usuario' => $usuario
        ]);
    }      
    
    public function update(){
        session_start();
        $id = $_SESSION['id'];

        $usuario = array(
            "id" => $id,
            "nombre" => $_POST["nombre"],
            "apellidos" => $_POST["apellidos"],
            "email" => $_POST["email"],
            "fecha_nacimiento" => $_POST["fecha_nacimiento"],
            "telefono" => $_POST["telefono"],
        );
        UsuariosModel::edit($usuario);

        $this->redirect('index.php?controller=UsuariosController');
    }

    public function store($datos) {

    }
    
    public function destroy($id) {

    }
    
    public function destroyAll() {

    }
}