<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/FavoritosModel.php';

class FavoritosController extends BaseController {

    private function getSessionUserId() {
        // Asegurar que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['id'] ?? null;
    }

    private function checkAuthentication() {
        $id_usuario = $this->getSessionUserId();
        if (!$id_usuario) {
            http_response_code(401);
            echo json_encode(['error' => 'Usuario no autenticado']);
            exit;
        }
        return $id_usuario;
    }

    public function añadir(){
        header('Content-Type: application/json');
        
        $id_usuario = $this->checkAuthentication();
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $id_anuncio = $data['id_anuncio'] ?? null;

        if (!$id_anuncio) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de anuncio requerido']);
            exit;
        }

        try {
            $success = FavoritosModel::añadirFavorito($id_anuncio, $id_usuario);
            echo json_encode([
                'success' => (bool)$success, 
                'added' => (bool)$success,
                'message' => $success ? 'Favorito añadido' : 'Error al añadir favorito'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error del servidor: ' . $e->getMessage()]);
        }
    }

    public function eliminar(){
        header('Content-Type: application/json');
        
        $id_usuario = $this->checkAuthentication();
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $id_anuncio = $data['id_anuncio'] ?? null;

        if (!$id_anuncio) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de anuncio requerido']);
            exit;
        }

        try {
            $success = FavoritosModel::eliminarFavorito($id_anuncio, $id_usuario);
            echo json_encode([
                'success' => (bool)$success, 
                'removed' => (bool)$success,
                'message' => $success ? 'Favorito eliminado' : 'Error al eliminar favorito'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error del servidor: ' . $e->getMessage()]);
        }
    }

    public function getAll(){
        header('Content-Type: application/json');
        
        $id_usuario = $this->checkAuthentication();
        
        try {
            $favoritos = FavoritosModel::getAll($id_usuario);
            echo json_encode([
                'success' => true,
                'favoritos' => $favoritos
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error del servidor: ' . $e->getMessage()]);
        }
    }
}