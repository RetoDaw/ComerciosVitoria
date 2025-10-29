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
        $categoria = '';
        if(isset($_POST['id_categoria']))
            $categoria = $_POST['id_categoria'];
        //coger todos los anuncios
        if($categoria == ''):
            $anuncios = ComerciosModel::getAll();
        else:
            $anuncios = ComerciosModel::getByCategoria($categoria);
        endif;

        $this->render('index.view.php', [
            'anuncios' => $anuncios
        ]);
    }

    public function buscar() {
        $nombre = '';
        if (isset($_POST['nombre']))
            $nombre = $_POST['nombre'];
        $anuncios = ComerciosModel::getByName($nombre);

        $this->render('index.view.php', [
            'anuncios' => $anuncios
        ]);
    }
    
    public function editar() {
        $id = $_GET['id'];

        $anuncio = ComerciosModel::getById($id);
        $imagenes = ImagenesModel::getByAnuncio($id);
        $categorias = CategoriasModel::getAll();

        $this->render('editarAnuncio.php', [
            'anuncio' => $anuncio,
            'imagenes' => $imagenes,
            'categorias' => $categorias
        ]);
    }

    public function crear(){
        $this->render('publicarAnuncio.php');
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
        $anuncio = [
            $id,
            $_POST['titulo'],
            $_POST['descripcion'],
            $_POST['direccion'],
            $_POST['precio'],
            $_POST['categoria']
        ];

        // Actualizar anuncio
        ComerciosModel::edit($anuncio);

        // Actualizar imágenes si se envían
        $imagenesNuevas = $_FILES['imagenes'] ?? [];
        $imagenesBorrar = json_decode($_POST['imagenesBorradas'] ?? '[]', true);
        if (!empty($imagenesNuevas) || !empty($imagenesBorrar)) {
            ImagenesModel::edit($id, $imagenesNuevas, $imagenesBorrar);
        }

        // Redirigir al listado de sus anuncios
        $this->redirect('index.php?controller=UsuariosController&accion=perfil');
    }

    public function desactivar(){
        header('Content-Type: application/json');

        //coger el JSON y transformarlo utilizando la funcion file_get_contents()
        $data = json_decode(file_get_contents('php://input'), true);

        $id = $data['id_anuncio'] ?? null;
        $desactivar = $data['desactivar'] ?? null;

        if (!$id) {
            echo json_encode(['error' => 'Datos incompletos']);
            exit;
        }

        ComerciosModel::desactivar($id,$desactivar);
        echo json_encode(['succes' => true]);
    }

    
    public function destroy() {
        $id = $_POST["id"];
        ImagenesModel::deleteById($id);
        ComerciosModel::deleteById($id);
        $this->redirect('index.php');
    }

    public static function getByUser() {
    header('Content-Type: application/json; charset=utf-8');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id'])) {
        echo json_encode([
            "success" => false,
            "msg" => "Usuario no autenticado"
        ]);
        exit;
    }

    try {
        $anuncios = ComerciosModel::getByUser($_SESSION['id']);

        // Añadir imágenes y categoría
        foreach($anuncios as &$anuncio){
            $imagenes = ImagenesModel::getByAnuncio($anuncio['id']);
            $anuncio['imagenes'] = array_map(fn($i)=> $i['ruta'], $imagenes);
            $anuncio['categoria'] = CategoriasModel::getById($anuncio['id_categoria'])['nombre'] ?? 'Sin categoría';
        }

        echo json_encode([
            "success" => true,
            "anuncios" => $anuncios
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "msg" => $e->getMessage()
        ]);
    }
    exit;
}


    
    /*public function destroyAll() {
        ComerciosModel::deleteAll();
        $this->redirect('index.php');
    }*/
}