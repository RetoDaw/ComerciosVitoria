<?php
require_once __DIR__ . '/Database.php';

class ComerciosModel {
    
    public static function getAll() {
        $dbh = Database::getConnection();
        $stmt = $dbh->prepare("SELECT *
                                FROM anuncios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function create($datos,$imagenes) {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("INSERT INTO anuncios(titulo,descripcion,direccion,precio,id_usuario,id_categoria,estado)
                            values (:titulo,:descripcion,:direccion,:precio,:id_usuario,:id_categoria,true)"
        );
        $data = array(
            "titulo" => $datos[0],
            "descripcion" => $datos[1],
            "direccion" => $datos[2],
            "precio" => $datos[3],
            "id_usuario" => $datos[4],
            "id_categoria" => $datos[5]
        );
        $stmt->execute($data) ? 
            ImagenesModel::create($dbh,$imagenes) 
        : 
            throw new Exception("No se pudo añadir el anuncio a la base de datos");
    }
    
    public static function deleteById($id) {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("DELETE FROM anuncios
                                WHERE id = :id"
        );
        $data = array('id' => $id);
        if (!$stmt->execute($data)):
            throw new Exception("No se pudo borrar el anuncio a la base de datos");
        endif;
    }
    
    public static function deleteAll($id_usuario) {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("DELETE FROM anuncios
                                WHERE id_usuario = :id_usuario");
        if(!$stmt->execute([
            'id_usuario' => $id_usuario
        ])):
            throw new Exception("No se pudo borrar ningún anuncio de la base de datos");
        endif;
    }
    
    public static function deleteCategoria($id_categoria) {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("DELETE FROM anuncios
                                WHERE id_categoria = :id_categoria");
        return $stmt->execute([
            'id_categoria' => $id_categoria
        ]);
    }

    public static function edit($datos) {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("UPDATE anuncios
                            SET titulo = :titulo, precio = :precio, descripcion = :descripcion, direccion = :direccion, id_categoria = :id_categoria
                            WHERE id = :id"
        );
        $data = array(
            "id" => $datos[0],
            "titulo" => $datos[1],
            "precio" => $datos[2],
            "descripcion" => $datos[3],
            "direccion" => $datos[4],
            "id_categoria" => $datos[5]
        );
        if($stmt->execute($data)) throw new Exception("No se pudo editar el anuncio");
    }
}