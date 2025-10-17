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

    public static function getIdByName($nombre) {
        $dbh = Database::getConnection();
        $stmt = $dbh->prepare("SELECT id
                                FROM categorias
                                WHERE nombre = :nombre");
        $stmt->execute([
            'nombre' => $nombre
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
        $stmt= $dbh->prepare("DELETE FROM categorias
                                WHERE id = :id"
        );
        $data = array('id' => $id);
        if (!$stmt->execute($data)):
            throw new Exception("No se pudo borrar la categoria a la base de datos");
        endif;
    }
    
    public static function deleteAll() {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("DELETE FROM categorias");
        if(!$stmt->execute()):
            throw new Exception("No se pudo borrar ningún anuncio de la base de datos");
        endif;
    }
}