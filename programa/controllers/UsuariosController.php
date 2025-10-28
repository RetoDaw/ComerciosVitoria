<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ComerciosModel.php';
require_once __DIR__ . '/../models/UsuariosModel.php';

class UsuariosController extends BaseController {

    public function index() {
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

    public function verificarUsuario() {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $user_name = $data['user_name'];
        $password = $data['password'];

        try{
            UsuariosModel::verificarUsuario($user_name,$password);
        }catch(Exception $e){
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }

        $redireccionar = $_SESSION['redireccionar'];
        unset($_SESSION['redireccionar']); //limpiar después de usarla
        echo json_encode(['success' => true,
                            'redirect' => $redireccionar
        ]);
    }

    public function cerrarSesion() {
        session_start();
        $redireccionar = $_SESSION['redireccionar'];
        
        session_unset();
        session_destroy();

        echo json_encode(['success' => true,
                            'redirect' => $redireccionar
        ]);
    }

    public function store($datos) {

    }
    
    public function destroy($id) {

    }
    
    public function destroyAll() {

    }
}