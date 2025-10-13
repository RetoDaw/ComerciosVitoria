<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ComerciosModel.php';

class ComerciosController extends BaseController {
    
    public function index() {
        $anuncios = ComerciosModel::getAll();
        $this->render('index.view.php', ['anuncios' => $anuncios]);
    }
    
    public function show() {

    }
    
    public function store($datos) {
        $anuncio = array(
            "titulo" => $_GET["titulo"],
            "descripcion" => $_GET["descripcion"],
            "telefono_contacto" => $_GET["telefono_contacto"],
            "email_contacto" => $_GET["email_contacto"],
            "direccion" => intval($_GET["direccion"]),
        );
        if (isset($_FILES)):
            foreach($_FILES as $img):
                array_push($anuncio,$img);
            endforeach;
        endif;
        ComerciosModel::create($anuncio);
        $this->redirect('index.php');
    }
    
    public function destroy($id) {
        $id = $_GET["id"];
        ComerciosModel::deleteById($id);
        $this->redirect('index.php');
    }
    
    public function destroyAll() {
        ComerciosModel::deleteAll();
        $this->redirect('index.php');
    }
}