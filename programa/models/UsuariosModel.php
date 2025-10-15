<?php
require_once __DIR__ . '/Database.php';

class UsuariosModel {
    
    public static function getAll() {
        $dbh = Database::getConnection();
        $stmt = $dbh->prepare("SELECT *
                                FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $dbh = Database::getConnection();
        $stmt = $dbh->prepare("SELECT *
                                FROM usuarios
                                WHERE id = :id");
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function create($datos) {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("INSERT INTO usuarios(user_name,nombre,apellidos,email,password,tipo_usuario,fecha_nacimiento,telefono)
                            values (:user_name,:nombre,:apellidos,:email,:password,:tipo_usuario,:fecha_nacimiento,:telefono)"
        );
        $data = array(
            "user_name" => $datos[0],
            "nombre" => $datos[1],
            "apellidos" => $datos[2],
            "email" => $datos[3],
            "password" => $datos[4],
            "tipo_usuario" => $datos[5],
            "fecha_nacimiento" => $datos[6],
            "telefono" => $datos[7] ?? null
        );
        if($stmt->execute($data)) throw new Exception("No se pudo añadir el usuario a la base de datos");
    }
    
    public static function deleteById($id) {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("DELETE FROM usuarios
                                WHERE id = :id"
        );
        $data = array('id' => $id);
        if (!$stmt->execute($data)):
            throw new Exception("No se pudo borrar el usuario a la base de datos");
        endif;
    }
    
    public static function deleteAll() {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("DELETE FROM usuarios");
        if(!$stmt->execute()) throw new Exception("No se pudo borrar ningún anuncio de la base de datos");
    }
    
}