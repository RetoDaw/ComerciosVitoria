<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ComerciosModel.php';
require_once __DIR__ . '/../models/CategoriasModel.php';

class CategoriasController extends BaseController {
    
    public static function cogerCategoriasDeAnuncios($anuncios) {
        //Por cada anuncio que me ha llegado, cojo la categoria que esté relacionada
        $categorias = [];
        foreach ($anuncios as $anuncio){
            array_push($categorias,CategoriasModel::getById($anuncio['id_categoria']));
        }
        return $categorias;
    }

    public static function nombreCategoria($anuncio) {
        //Por cada anuncio que me ha llegado, cojo la categoria que esté relacionada
        $categoria = CategoriasModel::getById($anuncio['id_categoria']);
        return $categoria['nombre'] ?? null;
    }

    public function cogerCategorias() {
        return CategoriasModel::getAll();
    }

    public function show() {

    }
    
    public function store() {
        $nombre = $_POST['nombre'] ?? null;
        if($nombre != null){
            CategoriasModel::create($nombre);
        }
        $this->redirect('index.php?controller=UsuariosController&accion=perfil');
    }
    
    public function destroy() {
        $id = $_POST['id'] ?? null;
        if($id != null){
           CategoriasModel::deleteById($id);
        }
        $this->redirect('index.php?controller=UsuariosController&accion=perfil');
    }  
    public function destroyAll() {
        
    }
}