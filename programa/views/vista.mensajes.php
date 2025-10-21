<?php
session_start();

// Simulación: usuario logueado (ejemplo)
$_SESSION['id_usuario'] = 4;
$_SESSION['user_name'] = 'daniel';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajería</title>
    <script src="assets/mensajes.js" defer></script>
    <style>
        body { font-family: Arial; display: flex; height: 100vh; margin: 0; }
        #usuarios { width: 25%; border-right: 1px solid #ccc; padding: 10px; overflow-y: auto; }
        #chat { flex: 1; display: flex; flex-direction: column; }
        #mensajes { flex: 1; padding: 10px; overflow-y: auto; }
        #input-area { display: flex; border-top: 1px solid #ccc; }
        #input-area input { flex: 1; padding: 10px; border: none; }
        #input-area button { padding: 10px 20px; border: none; background: #007bff; color: white; cursor: pointer; }
        .mensaje { margin: 5px 0; }
        .yo { text-align: right; color: blue; }
        .otro { text-align: left; color: green; }
    </style>
</head>
<body>
    <div id="usuarios"></div>

    <div id="chat">
        <div id="mensajes"></div>
        <div id="input-area">
            <input type="text" id="mensaje-input" placeholder="Escribe un mensaje...">
            <button id="enviar-btn">Enviar</button>
        </div>
    </div>

    <script>
        const USER_ID = <?= $_SESSION['id_usuario'] ?>;
    </script>
</body>
</html>
