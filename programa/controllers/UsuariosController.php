<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/ComerciosModel.php';
require_once __DIR__ . '/../models/UsuariosModel.php';

class UsuariosController extends BaseController {

    public function index() {
    }

    public function datosContacto() {
        $id = $_GET['id'];
        echo json_encode(UsuariosModel::getDatosContacto($id));
    }

    public function editar(){
        session_start();
        $id = $_SESSION['id'];

        $usuario = UsuariosModel::getById($id);

        $this-> render('editarPerfil.php',[
            'usuario' => $usuario
        ]);
    }      
    
    public function update(){
        session_start();
        $id = $_SESSION['id'];

        $usuario = array(
            "id" => $id,
            "nombre" => $_POST["nombre"],
            "apellidos" => $_POST["apellidos"],
            "email" => $_POST["email"],
            "fecha_nacimiento" => $_POST["fecha_nacimiento"],
            "telefono" => $_POST["telefono"],
        );
        UsuariosModel::edit($usuario);

        $this->redirect('index.php?controller=UsuariosController&accion=perfil');
    }

    public function perfil() {
        session_start();
        if(!isset($_SESSION['id'])){
            $this->redirect('index.php?controller=UsuariosController&accion=login');
            return;
        }

        $usuario = UsuariosModel::getById($_SESSION['id']);
        if(!$usuario){
            $this->redirect('index.php');
            return;
        }

        $this->render('perfilUsuario.php', ['usuario' => $usuario]);
    }

    public function verificarUsuario() {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $user_name = $data['user_name'];
        $password = $data['password'];

        try{
            UsuariosModel::verificarUsuario($user_name,$password);
        }catch(Exception $e){
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }

        $redireccionar = $_SESSION['redireccionar'];
        unset($_SESSION['redireccionar']); //limpiar después de usarla
        echo json_encode(['success' => true,
                            'redirect' => $redireccionar
        ]);
    }

    public function registrarUsuario() {
        header('Content-Type: application/json');

        // Obtener datos del request
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validar que lleguen todos los datos necesarios
        if (!isset($data['nombre']) || !isset($data['apellidos']) || 
            !isset($data['email']) || !isset($data['user_name']) || 
            !isset($data['password']) || !isset($data['fecha_nacimiento'])) {
            echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
            exit;
        }

        // Extraer y sanitizar datos
        $nombre = trim($data['nombre']);
        $apellidos = trim($data['apellidos']);
        $email = trim($data['email']);
        $user_name = trim($data['user_name']);
        $password = $data['password'];
        $fecha_nacimiento = $data['fecha_nacimiento'];
        $telefono = isset($data['telefono']) && !empty($data['telefono']) ? trim($data['telefono']) : null;

        // Validaciones del lado del servidor
        if (empty($nombre) || empty($apellidos) || empty($email) || empty($user_name) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios deben estar completos']);
            exit;
        }

        // Validar longitud de campos
        if (strlen($nombre) > 255 || strlen($apellidos) > 255 || strlen($email) > 255 || strlen($user_name) > 255) {
            echo json_encode(['success' => false, 'message' => 'Algún campo excede la longitud máxima permitida']);
            exit;
        }

        // Validar formato de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'El formato del email no es válido']);
            exit;
        }

        // Validar longitud de contraseña
        if (strlen($password) < 6) {
            echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres']);
            exit;
        }

        // Validar longitud máxima de contraseña (importante para password_hash)
        if (strlen($password) > 500) {
            echo json_encode(['success' => false, 'message' => 'La contraseña es demasiado larga']);
            exit;
        }

        // Validar formato de fecha
        $fecha = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
        if (!$fecha || $fecha->format('Y-m-d') !== $fecha_nacimiento) {
            echo json_encode(['success' => false, 'message' => 'El formato de fecha no es válido']);
            exit;
        }

        // Validar que sea mayor de 18 años
        $hoy = new DateTime();
        $edad = $hoy->diff($fecha)->y;
        if ($edad < 18) {
            echo json_encode(['success' => false, 'message' => 'Debes ser mayor de 18 años para registrarte']);
            exit;
        }

        // Validar teléfono si existe
        if ($telefono !== null && strlen($telefono) > 20) {
            echo json_encode(['success' => false, 'message' => 'El teléfono excede la longitud máxima']);
            exit;
        }

        try {
            // Verificar si el usuario ya existe
            $usuarioExiste = UsuariosModel::getIdByUsername($user_name);
            if ($usuarioExiste) {
                echo json_encode(['success' => false, 'message' => 'El nombre de usuario ya está en uso']);
                exit;
            }

            // Verificar si el email ya existe
            $emailExiste = UsuariosModel::getByEmail($email);
            if ($emailExiste) {
                echo json_encode(['success' => false, 'message' => 'El email ya está registrado']);
                exit;
            }

            // Hashear la contraseña
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Crear array de datos para el modelo
            $datosUsuario = [
                $user_name,      // 0: user_name
                $nombre,         // 1: nombre
                $apellidos,      // 2: apellidos
                $email,          // 3: email
                $passwordHash,   // 4: password (hasheada)
                $fecha_nacimiento, // 5: fecha_nacimiento
                $telefono        // 6: telefono
            ];

            // Crear usuario
            UsuariosModel::create($datosUsuario);

            echo json_encode(['success' => true, 'message' => 'Usuario registrado exitosamente']);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error al registrar usuario: ' . $e->getMessage()]);
        }
    }

    public function cerrarSesion() {
        session_start();
        $redireccionar = $_SESSION['redireccionar'];
        
        session_unset();
        session_destroy();

        echo json_encode(['success' => true,
                            'redirect' => $redireccionar
        ]);
    }

    public function store($datos) {

    }
    
    public function destroy($id) {

    }
    
    public function destroyAll() {

    }
}