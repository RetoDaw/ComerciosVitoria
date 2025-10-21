<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/ComerciosModel.php';

require_once __DIR__ . '/ImagenesController.php';
require_once __DIR__ . '/CategoriasController.php';
require_once __DIR__ . '/UsuariosController.php';

require_once __DIR__ . '/ImagenesModel.php';
require_once __DIR__ . '/CategoriasModel.php';
require_once __DIR__ . '/UsuariosModel.php';


class ComerciosController extends BaseController {
    
    public function index() {
        //coger todos los anuncios
        echo "comercios";
        $anuncios = ComerciosModel::getAll();

        echo "imagenes";
        //coger todas las imagenes que esten relacionadas a un anuncio
        $imagenes = ImagenesController::CogerImagenesDeAnuncios($anuncios);
        echo "categorias";
        //coger todas las categorias que esten relacionadas a un anuncio
        $categorias = CategoriasController::CogerCategoriasDeAnuncios($anuncios);
        echo "usuarios";
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

        $anuncio = ComerciosModel::getById($id);
        $imagenes = ImagenesModel::getByAnuncio($id);
        $categoria = CategoriasModel::getById($anuncio['id_categoria']);

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

    public function update(){
        $id = $_GET['id'];

        // Array indexado correcto para ComerciosModel::edit()
        $anuncio = [
            $id,
            $_GET['titulo'],
            $_GET['descripcion'],
            $_GET['direccion'],
            $_GET['precio'],
            $_GET['id_categoria'] ?? CategoriasModel::getIdByName($_GET['id_categoria'])
        ];

        // Actualizar anuncio
        ComerciosModel::edit($anuncio);

        // Actualizar imágenes si se envían
        $imagenesNuevas = $_FILES['imagenes_nuevas'] ?? [];
        $imagenesBorrar = $_FILES['imagenes_borrar'] ?? [];
        if (!empty($imagenesNuevas) || !empty($imagenesBorrar)) {
            ImagenesModel::edit($id, $imagenesNuevas, $imagenesBorrar);
        }

        // Redirigir al listado de anuncios
        $this->redirect('index.php');
    }

    
    public function destroy($id) {
        $id = $_GET["id"];
        ImagenesModel::deleteById($id);
        ComerciosModel::deleteById($id);
        $this->redirect('index.php');
    }
    
    /*public function destroyAll() {
        ComerciosModel::deleteAll();
        $this->redirect('index.php');
    }*/
}