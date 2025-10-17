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
        $id = $_GET['id'];

        $usuario = UsuariosModel::getById($id);

        $this-> render('usuarios_edit_view.php',[
            'usuario' => $usuario
        ]);
    }      
    
    public function update($id){
        $id = $_GET['id'];

        $usuario = array(
            "id" => $_GET["id"],
            "nombre" => $_GET["nombre"],
            "apellidos" => $_GET["apellidos"],
            "email" => $_GET["email"],
            "fecha_nacimiento" => $_GET["fecha_nacimiento"],
            "telefono" => $_GET["telefono"],
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