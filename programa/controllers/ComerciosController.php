<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ComerciosModel.php';

class ComerciosController extends BaseController {
    
    public function index() {
        //coger todos los anuncios
        $anuncios = ComerciosModel::getAll();

        //coger todas las imagenes que esten relacionadas a un anuncio
        $imagenes = ImagenesController::CogerImagenesDeAnuncios($anuncios);

        //coger todas las categorias que esten relacionadas a un anuncio
        $categorias = CategoriasController::CogerCategoriasDeAnuncios($anuncios);

        //coger todos los datos de usuario que esten relacionadas a un anuncio
        $usuarios = UsuariosController::CogerDatosUsuarioDeAnuncios($anuncios);

        $this->render('index.view.php', [
            'anuncios' => $anuncios,
            'imagenes' => $imagenes,
            'categorias' => $categorias,
            'datosUsuario' => $usuarios
        ]);
    }
    
    public function show() {

    }
    
    public function store($datos) {
        $anuncio = array(
            "titulo" => $_GET["titulo"],
            "descripcion" => $_GET["descripcion"],
            "direccion" => $_GET["direccion"],
            "precio" => $_GET["precio"],
            "id_usuario" => $_SESSION["user_name"],
            "id_categoria" => $_GET["id_categoria"]
        );
        if (isset($_FILES)):
            foreach($_FILES as $img):
                array_push($anuncio,$img);
            endforeach;
        endif;
        ComerciosModel::create($anuncio,$img);
        $this->redirect('index.php');
    }
    
    public function destroy($id) {
        $id = $_GET["id"];
        ComerciosModel::deleteById($id);
        $this->redirect('index.php');
    }
    
    /*public function destroyAll() {
        ComerciosModel::deleteAll();
        $this->redirect('index.php');
    }*/
}