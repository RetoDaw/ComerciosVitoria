<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ComerciosModel.php';

class ImagenesController extends BaseController {
    
    public static function CogerImagenesDeAnuncios($anuncios) {
        //Por cada anuncio que me ha llegado, cojo las imagenes que estén relacionadas
        $imagenes = [];
        foreach ($anuncios as $anuncio){
            array_push($imagenes,ImagenesModel::getAll($anuncio['id']));
        }
        return $imagenes;
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