<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ComerciosModel.php';
require_once __DIR__ . '/../models/UsuariosModel.php';

class UsuariosController extends BaseController {

    public function index() {
        $usuarios = UsuariosModel::getDatosMostrar();

        $this-> render('index.view.php' ,[
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

        $this-> render('editarPerfil.php',[
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

        $this->redirect('index.php?controller=UsuariosController&accion=perfil');
    }

    public function perfil() {
        session_start();
        if(!isset($_SESSION['id'])){
            $this->redirect('index.php?controller=UsuariosController&accion=login');
            return;
        }

        $usuario = UsuariosModel::getById($_SESSION['id']);
        if(!$usuario){
            $this->redirect('index.php');
            return;
        }

        $this->render('perfilUsuario.php', ['usuario' => $usuario]);
    }

    public function store($datos) {

    }
    
    public function destroy($id) {

    }
    
    public function destroyAll() {

    }
}