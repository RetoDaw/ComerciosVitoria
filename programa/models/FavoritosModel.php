<?php
require_once __DIR__ . '/Database.php';

class FavoritosModel {

    public static function getAll($id_usuario){
        $dbh = Database::getConnection();
        $stmt = $dbh->prepare("
            SELECT a.*
            FROM anuncios a
            INNER JOIN favoritos f ON a.id = f.id_anuncio
            WHERE f.id_usuario = :id_usuario
        ");
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function añadirFavorito($id_anuncio, $id_usuario){
        $dbh = Database::getConnection();
        
        try {
            $stmt = $dbh->prepare("
                INSERT INTO favoritos(id_usuario, id_anuncio)
                VALUES(:id_usuario, :id_anuncio)
            ");
            return $stmt->execute([
                'id_usuario' => $id_usuario,
                'id_anuncio' => $id_anuncio
            ]);
        } catch (PDOException $e) {
            // Si ya existe (violación de clave primaria), consideramos éxito
            if ($e->getCode() == 23000) { // Código para duplicados
                return true;
            }
            throw $e; // Relanzar otras excepciones
        }
    }

    public static function eliminarFavorito($id_anuncio, $id_usuario){
        $dbh = Database::getConnection();
        $stmt = $dbh->prepare("
            DELETE FROM favoritos
            WHERE id_anuncio = :id_anuncio
              AND id_usuario = :id_usuario
        ");
        return $stmt->execute([
            'id_usuario' => $id_usuario,
            'id_anuncio' => $id_anuncio
        ]);
    }

    // Nuevo método para verificar si un anuncio es favorito
    public static function esFavorito($id_anuncio, $id_usuario){
        $dbh = Database::getConnection();
        $stmt = $dbh->prepare("
            SELECT COUNT(*) as count 
            FROM favoritos 
            WHERE id_usuario = :id_usuario AND id_anuncio = :id_anuncio
        ");
        $stmt->execute([
            'id_usuario' => $id_usuario,
            'id_anuncio' => $id_anuncio
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}