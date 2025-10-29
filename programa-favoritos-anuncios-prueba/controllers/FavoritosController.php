<?php
    require_once __DIR__ . '/BaseController.php';
    require_once __DIR__ . '/../models/FavoritosModel.php';
    require_once __DIR__ . '/../models/ComerciosModel.php';
    require_once __DIR__ . '/../models/ImagenesModel.php';
    require_once __DIR__ . '/../models/CategoriasModel.php';

    class FavoritosController extends BaseController {

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
            echo json_encode(['success' => true]);
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
            
            // Obtener información completa de cada anuncio favorito
            $anunciosCompletos = [];
            foreach ($favoritos as $favorito) {
                $anuncio = ComerciosModel::getById($favorito['id_anuncio']);
                if ($anuncio) {
                    // Obtener imágenes
                    $imagenes = ImagenesModel::getByAnuncio($anuncio['id']);
                    $anuncio['imagenes'] = $imagenes;
                    
                    // Obtener categoría
                    $categoria = CategoriasModel::getById($anuncio['id_categoria']);
                    $anuncio['categoria'] = $categoria['nombre'] ?? 'Sin categoría';
                    
                    $anunciosCompletos[] = $anuncio;
                }
            }

            echo json_encode(['favoritos' => $anunciosCompletos]);
        }
    }
?>