<?php
    require_once __DIR__ . '/BaseController.php';
    require_once __DIR__ . '/../models/FavoritosModel';

    class FavoritosController  extends BaseController {

        public function añadir(){

            header('Content-Type: application/json');

            $data = json_decode(file_get_contents('php://input'), true);

            $id_anuncio = $data['id_anuncio'] ?? null;
            $id_usuario = $data['id_usuario'] ?? null;

            if (!$id_anuncio || !$id_usuario) {
                echo json_encode(['error' => 'Datos incompletos']);
                exit;
            }
            FavoritosModel::añadirFavorito($id_anuncio,$id_usuario);
            echo json_encode(['succes' => true]);
        }

        public function eliminar(){

            header('Content-Type: application/json');

            $data = json_decode(file_get_contents('php://input'), true);

            $id_anuncio = $data['id_anuncio'] ?? null;
            $id_usuario = $data['id_usuario'] ?? null;

            if (!$id_anuncio || !$id_usuario) {
                echo json_encode(['error' => 'Datos incompletos']);
                exit;
            }

            FavoritosModel::eliminarFavorito($id_anuncio, $id_usuario);

            echo json_encode(['success' => true]);
        }

        public function getAll(){

            header('Content-Type: application/json');

            $data = json_decode(file_get_contents('php://input'), true);

            $id_usuario = $data['id_usuario'] ?? null;

            if (!$id_usuario) {
            echo json_encode(['error' => 'Datos incompletos']);
            exit;
            }

            $favoritos = FavoritosModel::getAll($id_usuario);
            echo json_encode(['favoritos' => $favoritos]);

        }
        
    }


?>