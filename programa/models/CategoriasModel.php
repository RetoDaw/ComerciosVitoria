<?php
require_once __DIR__ . '/Database.php';

class CategoriasModel {
    
    public static function getAll() {
        $dbh = Database::getConnection();
        $stmt = $dbh->prepare("SELECT *
                                FROM categorias");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $dbh = Database::getConnection();
        $stmt = $dbh->prepare("SELECT nombre
                                FROM categorias
                                WHERE id = :id");
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function create($nombre) {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("INSERT INTO categorias(nombre)
                            values (:nombre)"
        );
        $data = array(
            'nombre' => $nombre
        );
        if (!$stmt->execute($data)) throw new Exception("No se pudo añadir la categoria a la base de datos");
    }
    
    public static function deleteById($id) {
        $dbh = Database::getConnection();
        if(ComerciosModel::deleteCategoria($id)):
            $stmt= $dbh->prepare("DELETE FROM categorias
                                    WHERE id = :id"
            );
            $data = array('id' => $id);
            if (!$stmt->execute($data)):
                throw new Exception("No se pudo borrar la categoria a la base de datos");
            endif;
        else:
            throw new Exception("No se pudo borrar la categoria de los anuncios requeridos para continuar con la elminiacion");
        endif;
    }
    
    public static function deleteAll() {
        $dbh = Database::getConnection();
        foreach (self::getAll() as $categoria):
            if(!ComerciosModel::deleteCategoria($categoria['id'])):
                throw new Exception("No se pudieron borrar las categorias de los anuncios requeridos para continuar con la elminiacion");
            endif;
        endforeach;
        $stmt= $dbh->prepare("DELETE FROM categorias");
        if(!$stmt->execute()):
            throw new Exception("No se pudo borrar ningún anuncio de la base de datos");
        endif;
    }
}