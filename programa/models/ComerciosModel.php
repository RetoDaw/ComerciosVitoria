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
    
    public static function create($datos) {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("INSERT INTO anuncios(titulo,descripcion,telefono_contacto,email_contacto,direccion)
                        values (:titulo,:descripcion,:telefono_contacto,:email_contacto,:direccion)"
        );
        $data = array(
            "titulo" => $datos[0],
            "descripcion" => $datos[1],
            "telefono_contacto" => $datos[2],
            "email_contacto" => $datos[3],
            "direccion" => $datos[4]
        );
        $stmt->execute($data) ? 
        ComerciosModel::addDirectory($dbh,$datos[0]) 
        : 
        throw new Exception("No se pudo añadir el anuncio a la base de datos");
    }

    private static function addDirectory($dbh,$datos){
        $id = $dbh->lastInsertId();

        // Crea la carpeta para las imágenes
        $carpeta = "uploads/anuncios/{$id}";

        //Comprobar la existencia de la carpeta
         if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
            
        //Actualiza la carpeta de imagenes a la bbdd
        if(!ComerciosModel::addDirectoryDb($dbh, $id, $carpeta)):
            throw new Exception("No se pudo actualizar la carpeta de imagenes en la base de datos");
        endif;

        for ($i = 5; $i < count($datos); $i++) {
            if(!ComerciosModel::uploadImage($datos[$i], $carpeta)):
                throw new Exception("No se pudo guardar la imagen correctamente");
            endif;
        }
    }

    private static function addDirectoryDb($dbh, $id, $carpeta){
        $stmt = $dbh->prepare("
            UPDATE anuncios
            SET carpeta_imagen = :carpeta_imagen
            WHERE id = :id
        ");
        $data = array(
            "carpeta_imagen" => $carpeta,
            "id" => $id
        );
        return $stmt->execute($data);
    }

    private static function uploadImage($imagen, $carpeta){
        /*
        tmp_name es un valor de $_FILES, que es una varialbe que guarda información de los archivos
        que se envian como type=file.
        tmp_name es la ruta temporal en la que php ha guardado esta imagen, asi que en el if
        comprobbamos que realmente se ha guardado.
        */
        if (isset($imagen['tmp_name']) && is_uploaded_file($imagen['tmp_name'])) {

            //Aqui usamos basename para coger solo el nombre de la imagen, sin la ruta tmp_name
            $nombreArchivo = basename($imagen['name']);

            $destino = $carpeta . '/' . $nombreArchivo;

            return move_uploaded_file($imagen['tmp_name'], $destino);
        }
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
    
    public static function deleteAll() {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("DELETE FROM anuncios");
        if(!$stmt->execute()):
            throw new Exception("No se pudo borrar ningún anuncio de la base de datos");
        endif;
    }
}