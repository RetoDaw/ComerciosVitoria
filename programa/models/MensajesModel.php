<?php
require_once __DIR__ . '/Database.php';

class MensajesModel {
    
    public static function getMensajes($id_emisor,$id_receptor) {
        $dbh = Database::getConnection();
        $stmt = $dbh->prepare("SELECT mensaje, fecha_envio, id_emisor, id_receptor
                                FROM mensaje
                                WHERE (id_emisor = :id_emisor AND id_receptor = :id_receptor)
                                OR (id_emisor = :id_receptor AND id_receptor = :id_emisor)
                                ORDER BY fecha_envio ASC");
        $stmt->execute([
            'id_emisor' => $id_emisor,
            'id_receptor' => $id_receptor
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getConversaciones($id_emisor) {
        $dbh = Database::getConnection();
        /*
        Selecciona el receptor y el nombre del usuario.
        En caso de que el usuario sea el emisor devuelve el receptor,
        en caso contrario devuelve el emisor. Esto sirve pare detectar
        La persona con la que se está comunicando el usuario
        */
        $stmt = $dbh->prepare("SELECT u.id as id, u.user_name as user_name 
                                FROM usuarios u
                                WHERE u.id IN (
                                    SELECT CASE 
                                        WHEN m.id_emisor = :id_emisor THEN m.id_receptor
                                        ELSE m.id_emisor
                                    END AS id
                                        FROM mensaje m
                                        WHERE m.id_emisor = :id_emisor OR m.id_receptor = :id_emisor
                                        ORDER BY fecha_envio ASC
                                )");
        $stmt->execute([
            'id_emisor' => $id_emisor
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function sendMensajes($id_emisor, $id_receptor, $mensaje){
        $dbh = Database::getConnection();
        $stmt = $dbh->prepare("
            INSERT INTO mensaje (id_emisor, id_receptor, mensaje)
            VALUES (:emisor, :receptor, :mensaje)
        ");
        $stmt->execute([
            ':emisor' => $id_emisor,
            ':receptor' => $id_receptor,
            ':mensaje' => $mensaje
        ]);
        return true;
    }
}