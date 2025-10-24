<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/publicarAnuncio.css">
</head>
<body>
    <div id="contenedor">
        <div id="crearAnuncio">
            <div id="crearAnuncioFormulario" name="editarPerfil">
                <p>Editar Perfil</p>
                <form id="formEditar" action="index.php?controller=UsuariosController&accion=update" method="post">
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre" value ="<?= $usuario['nombre']?>"> 
                    <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" value="<?= $usuario['apellidos']?>">
                    <input type="text" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="DD/MM/YYYY" value="<?= $usuario['fecha_nacimiento']?>">
                    <input type="text" name="telefono" id="telefono" placeholder="Teléfono" value="<?=$usuario['telefono']?>">
                    <input type="email" name="email" id="email" placeholder="Email" value="<?=$usuario['email']?>">

                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button type="submit" id="editar">Editar</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="imagen">
            <img src="../img/VITORIA-GASTEIZ.jpg" alt="">
        </div>
    </div>
</body>
</html>
