<?php
    require_once __DIR__ . '/Database.php';

    class FavoritosModel {
        /* AÑADIR QUE $_SESSION['id'] = $id al llamar a la funcion*/ 
       
        public static function getAll($id){
            $dbh = Database::getConnection();
            $stmt = $dbh->prepare("SELECT *
                                    FROM favoritos
                                    WHERE id_usuario = :id");
            $stmt->execute(['id' => $id]);                        
            return $stmt->fetch(PDO::FETCH_ASSOC);    
        }
        
        public static function añadirFavorito($id_anuncio, $id_usuario){
            $dbh = Database::getConnection();
            $stmt = $dbh->prepare("INSERT INTO favoritos(id_usuario, id_anuncio)
                                        VALUES(:id_usuario, :id_anuncio)");
            $stmt->execute([
                'id_usuario' => $id_usuario,
                'id_anuncio' => $id_anuncio ]);
            return $stmt->fetch(PDO::FETCH_ASSOC)                                
        }

        public static function eliminarFavorito($id_anuncio, $id_usuario){
            $dbh == Database::getConnection();
            $stmt = $dbh->prepare("DELETE id_anuncio, id_usuario
                                    FROM favoritos
                                    WHERE id_anuncio = :id_anuncio
                                    AND   id_usuario = :id_usuario");
            $stmt->execute([
                'id_usuario' => $id_usuario,
                'id_anuncio' => $id_anuncio
            ]);                        
        }
    }
