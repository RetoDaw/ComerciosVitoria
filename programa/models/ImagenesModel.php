<?php
require_once __DIR__ . '/Database.php';

class ImagenesModel {
    
    public static function getAll($id_anuncio) {
        $dbh = Database::getConnection();
        $stmt = $dbh->prepare("SELECT id,ruta
                                FROM imagenes
                                WHERE id_anuncio = :id_anuncio");
        $stmt->execute([
            'id_anuncio' => $id_anuncio
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($dbh,$imagenes){
        self::addDirectory($dbh,$imagenes);
    }
    
    private static function addDirectory($dbh,$imagenes){
        $id = $dbh->lastInsertId();

        // Crea la carpeta para las imágenes
        $carpeta = "uploads/anuncios/{$id}";

        //Comprobar la existencia de la carpeta
         if (!file_exists($carpeta)) mkdir($carpeta, 0777, true);
            
        if (self::uploadImage($dbh,$carpeta, $imagenes,$id)):
            return true;
        else:
            throw new Exception("No se pudieron añadir las imagenes a la base de datos.");
        endif;
    }

    private static function uploadImage($dbh,$carpeta, $imagenes,$id_anuncio){
        /*
        tmp_name es un valor de $_FILES, que es una varialbe que guarda información de los archivos
        que se envian como type=file.
        tmp_name es la ruta temporal en la que php ha guardado esta imagen, asi que en el if
        comprobbamos que realmente se ha guardado.
        */
        foreach ($imagenes['tmp_name'] as $index => $carpetaTemporal)
        if (is_uploaded_file($carpetaTemporal)) {

            //Aqui usamos basename para coger solo el nombre de la imagen, sin la ruta tmp_name
            $nombreArchivo = basename($imagenes['name'][$index]);

            $destino = $carpeta . '/' . $nombreArchivo;

            if (move_uploaded_file($carpetaTemporal, $destino)):
                $stmt = $dbh->prepare("
                    INSERT INTO imagenes (id_anuncio, ruta)
                    VALUES (:id_anuncio, :ruta)
                ");

                return $stmt->execute([
                    'id_anuncio' => $id_anuncio,
                    'ruta' => $destino
                ]);

            endif;
        }
        return false;
    }
    
    public static function deleteById($id) {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("DELETE FROM imagenes
                                WHERE id = :id"
        );
        $data = array('id' => $id);
        if (!$stmt->execute($data)):
            throw new Exception("No se pudo borrar la imagen a la base de datos");
        endif;
    }
    
    public static function deleteAll($id_anuncio) {
        $dbh = Database::getConnection();
        $stmt= $dbh->prepare("DELETE FROM imagenes
                                WHERE id_anuncio = :id_anuncio");
        if(!$stmt->execute([
            'id_anuncio' => $id_anuncio
        ])):
            throw new Exception("No se pudo borrar ninguna imagen de la base de datos");
        endif;
    }
}