<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/MensajesModel.php';

class MensajesController extends BaseController {
    
    public function index(){
        session_start();
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $id_usuario = $data['id_usuario'];
        $id_emisor = $_SESSION['id'];
        MensajesModel::sendMensajes($id_emisor,$id_usuario,'Hola');

        echo json_encode(['redirect' => 'index.php?controller=MensajesController&accion=mostrar']);
    }
    
    public function mostrar(){
        $this->render('vista.mensajes.php');
    }

    public static function getConversaciones(){
        session_start();
        header('Content-Type: application/json');
        $id_emisor = $_SESSION['id'] ?? null;
        echo json_encode(MensajesModel::getConversaciones($id_emisor));
    }

    public static function getMensajes(){
        session_start();
        header('Content-Type: application/json');
        $id_emisor = $_SESSION['id'];
        $id_receptor = $_GET['id_receptor'] ?? null;
        if (!$id_emisor || !$id_receptor) {
            echo json_encode(['error' => 'Datos incompletos']);
            exit;
        }
        echo json_encode(MensajesModel::getMensajes($id_emisor,$id_receptor));
    }

    public static function sendMensajes(){
        session_start();
        header('Content-Type: application/json');

        //coger el JSON y transformarlo utilizando la funcion file_get_contents()
        $data = json_decode(file_get_contents('php://input'), true);

        $id_emisor = $_SESSION['id'];
        $id_receptor = $data['id_receptor'] ?? null;
        $mensaje = $data['mensaje'] ?? null;

        if (!$id_emisor || !$id_receptor || !$mensaje) {
            echo json_encode(['error' => 'Datos incompletos']);
            exit;
        }
        MensajesModel::sendMensajes($id_emisor,$id_receptor,$mensaje);
        echo json_encode(['succes' => true]);
    }
}