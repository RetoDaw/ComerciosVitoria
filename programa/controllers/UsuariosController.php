<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ComerciosModel.php';

class UsuariosController extends BaseController {
    
    public static function CogerDatosUsuarioDeAnuncios($anuncios) {
        //Por cada anuncio que me ha llegado, cojo los datos de usuario que estén relacionados
        $datoscontacto = [];
        foreach ($anuncios as $anuncio){
            array_push($datosContacto,UsuariosModel::getDatosContacto($anuncio['id_usuario']));
        }
        return $datoscontacto;
    }

    public function index() {
        $usuarios = UsuariosModel::getDatosMostrar();

        $this-> render('usuarios.view.php' ,[
            'usuarios' => $usuarios
        ]);
    }

    public function editar($id){
        session_start():
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