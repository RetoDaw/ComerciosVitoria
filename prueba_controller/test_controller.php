<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// =======================
// 1️⃣ Config y conexión
// =======================
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/Database.php';

// =======================
// 2️⃣ Models
// =======================
require_once __DIR__ . '/ComerciosModel.php';
require_once __DIR__ . '/UsuariosModel.php';
require_once __DIR__ . '/CategoriasModel.php';
require_once __DIR__ . '/ImagenesModel.php';

// =======================
// 3️⃣ Controllers
// =======================
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/UsuariosController.php';
require_once __DIR__ . '/CategoriasController.php';
require_once __DIR__ . '/ImagenesController.php';
require_once __DIR__ . '/ComerciosController.php';

// =======================================================
// 4️⃣ Simular entorno (como si fuera una petición real)
// =======================================================
session_start();
$_SESSION['user_name'] = 'usuario_prueba';

// Simular parámetros GET
$_GET['id'] = 1;
$_GET['titulo'] = 'Tienda de prueba';
$_GET['descripcion'] = 'Descripción del comercio de prueba';
$_GET['direccion'] = 'Calle Ejemplo 123';
$_GET['precio'] = 50;
$_GET['categoria'] = 'Servicios';

// =======================================================
// 5️⃣ Crear instancia del controller y probar métodos
// =======================================================
echo "<h2>Probando ComerciosController</h2>";

try {
    $controller = new ComerciosController();

    echo "<h3>1️⃣ Prueba: index()</h3>";
    $controller->index();

    echo "<h3>2️⃣ Prueba: editar()</h3>";
    $controller->editar(1);

    echo "<h3>3️⃣ Prueba: store()</h3>";
    $_FILES = []; // sin imágenes

    $controller->store([
        "titulo" => $_GET["titulo"],
        "descripcion" => $_GET["descripcion"],
        "direccion" => $_GET["direccion"],
        "precio" => $_GET["precio"],
        "id_usuario" => 1, // o el id de prueba
        "id_categoria" => 1 // id de la categoría de prueba
    ]);

    echo "<h3 style='color:green;'>✅ Pruebas ejecutadas correctamente.</h3>";

} catch (Throwable $e) {
    echo "<h3 style='color:red;'>❌ Error detectado:</h3>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
