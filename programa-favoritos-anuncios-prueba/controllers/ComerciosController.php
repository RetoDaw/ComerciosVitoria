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
        $anuncios = ComerciosModel::getAll();

        $this->render('index.view.php', [
            'anuncios' => $anuncios
        ]);
    }
    
    public function editar() {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;

        if (!$id) {
            $this->redirect('index.php');
            return;
        }

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

        ComerciosModel::edit($anuncio);

        $imagenesNuevas = $_FILES['imagenes'] ?? [];
        $imagenesBorrar = json_decode($_POST['imagenesBorradas'] ?? '[]', true);
        if (!empty($imagenesNuevas) || !empty($imagenesBorrar)) {
            ImagenesModel::edit($id, $imagenesNuevas, $imagenesBorrar);
        }

        $this->redirect('index.php?controller=UsuariosController&accion=perfil');
    }

    public function desactivar(){
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        $id = $data['id_anuncio'] ?? null;
        $desactivar = $data['desactivar'] ?? null;

        if (!$id) {
            echo json_encode(['error' => 'Datos incompletos']);
            exit;
        }

        ComerciosModel::desactivar($id,$desactivar);
        echo json_encode(['success' => true]);
    }

    public function misAnuncios() {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $id_usuario = $data['id_usuario'] ?? null;

        if (!$id_usuario) {
            echo json_encode(['error' => 'Datos incompletos']);
            exit;
        }

        $anuncios = ComerciosModel::getByUsuario($id_usuario);
        
        // Obtener información completa de cada anuncio
        $anunciosCompletos = [];
        foreach ($anuncios as $anuncio) {
            // Obtener imágenes
            $imagenes = ImagenesModel::getByAnuncio($anuncio['id']);
            $anuncio['imagenes'] = $imagenes;
            
            // Obtener categoría
            $categoria = CategoriasModel::getById($anuncio['id_categoria']);
            $anuncio['categoria'] = $categoria['nombre'] ?? 'Sin categoría';
            
            $anunciosCompletos[] = $anuncio;
        }

        echo json_encode(['anuncios' => $anunciosCompletos]);
    }

    
    public function destroy() {
        $id = $_POST["id"];
        ImagenesModel::deleteById($id);
        ComerciosModel::deleteById($id);
        $this->redirect('index.php');
    }
}