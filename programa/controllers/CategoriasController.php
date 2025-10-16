<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ComerciosModel.php';

class CategoriasController extends BaseController {
    
    public static function CogerCategoriasDeAnuncios($anuncios) {
        //Por cada anuncio que me ha llegado, cojo la categoria que esté relacionada
        foreach ($anuncios as $anuncio){
            array_push($categorias,CategoriasModel::getById($anuncio)['id_categoria']);
        }
        return $categorias;
    }

    public function show() {

    }
    
    public function store($datos) {
        
    }
    
    public function destroy($id) {
        
    }
    
    public function destroyAll() {
        
    }
}