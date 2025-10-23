<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ComerciosModel.php';

require_once __DIR__ . '/ImagenesController.php';
require_once __DIR__ . '/CategoriasController.php';
require_once __DIR__ . '/UsuariosController.php';

require_once __DIR__ . '/../models/ImagenesModel.php';
require_once __DIR__ . '/../models/CategoriasModel.php';
require_once __DIR__ . '/../models/UsuariosModel.php';


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
        $categorias = CategoriasModel::getAll();

        $this->render('edit.view.php', [
            'anuncio' => $anuncio,
            'imagenes' => $imagenes,
            'categorias' => $categorias
        ]);
    }

    
    public function store() {
        session_start();
        $anuncio = array(
            "titulo" => $_POST["titulo"],
            "descripcion" => $_POST["descripcion"],
            "direccion" => $_POST["direccion"],
            "precio" => $_POST["precio"],
            "id_usuario" => $_SESSION['id'],
            "id_categoria" => $_POST["id_categoria"]
        );
        var_dump($_FILES['imagenes']);
        $imagenes = $_FILES['imagenes'] ?? null;
        if (!empty($imagenes))
            ComerciosModel::create($anuncio,$imagenes);
        $this->redirect('index.php');
    }

    public function update(){
        $id = $_POST['id'];
        
        // Array indexado correcto para ComerciosModel::edit()
        $anuncio = [
            $id,
            $_POST['titulo'],
            $_POST['descripcion'],
            $_POST['direccion'],
            $_POST['precio'],
            $_POST['id_categoria'] ?? CategoriasModel::getIdByName($_POST['id_categoria'])
        ];

        var_dump($anuncio);

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
        $id = $_POST["id"];
        ImagenesModel::deleteById($id);
        ComerciosModel::deleteById($id);
        $this->redirect('index.php');
    }
    
    /*public function destroyAll() {
        ComerciosModel::deleteAll();
        $this->redirect('index.php');
    }*/
}