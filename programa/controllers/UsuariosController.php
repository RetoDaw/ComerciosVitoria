<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ComerciosModel.php';

class UsuariosController extends BaseController {
    
    public static function CogerDatosUsuarioDeAnuncios($anuncios) {
        //Por cada anuncio que me ha llegado, cojo los datos de usuario que estén relacionados
        $datoscontacto = [];
        foreach ($anuncios as $anuncio){
            array_push($datosContacto,UsuariosModel::getDatosContacto($anuncio['id_usuario']));
        }
        return $datoscontacto;
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