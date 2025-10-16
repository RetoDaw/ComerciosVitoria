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
    
    public function editar($id) {
        $id = $_GET['id'];

        $anuncio = ComerciosModel::getById($id);
        $imagenes = ImagenesController::CogerImagenesDeAnuncios($id);
        $categoria = CategoriasController::CogerCategoriasDeAnuncios($id);

        $this->render('edit.view.php', [
            'anuncio' => $anuncio,
            'imagenes' => $imagenes,
            'categoria' => $categoria
        ]);
    }
    
    public function store($datos) {
        $anuncio = array(
            "titulo" => $_GET["titulo"],
            "descripcion" => $_GET["descripcion"],
            "direccion" => $_GET["direccion"],
            "precio" => $_GET["precio"],
            "id_usuario" => UsuariosModel::getIdByUsername($_SESSION["user_name"]),
            "id_categoria" => CategoriasModel::getIdByName($_GET["categoria"])
        );
        $imagenes = [];
        if (isset($_FILES)):
            foreach($_FILES as $img):
                array_push($imagenes,$img);
            endforeach;
        endif;
        ComerciosModel::create($anuncio,$imagenes);
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