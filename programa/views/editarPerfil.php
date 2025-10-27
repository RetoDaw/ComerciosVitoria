<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- CSS del header -->
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/registrarse.css">
    <link rel="stylesheet" href="css/iniciarSesion.css">

    <!-- CSS del footer -->
    <link rel="stylesheet" href="css/footerStyle.css">

    <!-- CSS del formulario de anuncio/edición -->
    <link rel="stylesheet" href="css/editarPerfil.css">
</head>
<body>
    <?php require_once 'layout/header.php'; ?>
    <div id="anuncio-contenedor">
        <div id="anuncio-formulario-wrapper">
            <div id="anuncio-formulario" name="editarPerfil">
                <p class="anuncio-titulo">Editar Perfil</p>
                <form id="formEditar" action="index.php?controller=UsuariosController&accion=update" method="post">
                    <input type="text" name="nombre" id="nombre" class="anuncio-input" placeholder="Nombre" value="<?= $usuario['nombre']?>"> 
                    <input type="text" name="apellidos" id="apellidos" class="anuncio-input" placeholder="Apellidos" value="<?= $usuario['apellidos']?>">
                    <input type="text" name="fecha_nacimiento" id="fecha_nacimiento" class="anuncio-input" placeholder="DD/MM/YYYY" value="<?= $usuario['fecha_nacimiento']?>">
                    <input type="text" name="telefono" id="telefono" class="anuncio-input" placeholder="Teléfono" value="<?=$usuario['telefono']?>">
                    <input type="email" name="email" id="email" class="anuncio-input" placeholder="Email" value="<?=$usuario['email']?>">

                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="btn-anuncio">Editar</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="anuncio-imagen-wrapper">
            <img src="../img/VITORIA-GASTEIZ.jpg" alt="">
        </div>
    </div>
</body>
</html>