<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajería</title>
    <script src="/assets/mensajes.js" defer></script>
    <link rel="stylesheet" href="/css/vistaMensaje.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <?php 
        require_once 'layout/header.php'
    ?>
    <div id="contenedor-chat">
        <div id="usuarios"></div>

        <div id="chat">
            <div id="mensajes"></div>
            <div id="input-area">
                <input type="text" id="mensaje-input" placeholder="Escribe un mensaje...">
                <button id="enviar-btn">Enviar</button>
            </div>
        </div>
    </div>

    <script>
        const USER_ID = <?= $_SESSION['id'] ?>;
    </script>
</body>
</html>
