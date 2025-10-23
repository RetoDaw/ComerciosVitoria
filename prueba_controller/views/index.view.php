<head>
    <style>
        img{
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<?php if (isset($anuncios) && !empty($anuncios)): ?>
        <?php foreach ($anuncios as $anuncio): ?>
            <p><b>Título:</b> <?= htmlspecialchars($anuncio['titulo']) ?></p>
            <p><b>Descripción:</b> <?= htmlspecialchars($anuncio['descripcion']) ?></p>
            <p><b>Dirección:</b> <?= htmlspecialchars($anuncio['direccion']) ?></p>
            <p><b>Precio:</b> <?= htmlspecialchars($anuncio['precio']) ?> €</p>
            <p><b>ID Usuario:</b> <?= htmlspecialchars($anuncio['id_usuario']) ?></p>
            <p><b>Nombre Categoría:</b> <?= htmlspecialchars(CategoriasController::nombreCategoria($anuncio)) ?></p>
            <p><b>Estado:</b> <?= $anuncio['estado'] ? 'Activo' : 'Inactivo' ?></p>
        <?php
        $imagenes = ImagenesController::getByAnuncio($anuncio);
        if ($imagenes) {
            foreach ($imagenes as $img) {
                ?>
                    <img src="<?= $img['ruta']?>" alt="">
                <?php
            }
        } else {
            echo "<p><b>No hay imágenes disponibles.</b></p>";
        }
        ?>
        <form action="index.php?accion=editar" method="post">
            <input type="text" name="id" id="id" hidden value="<?= htmlspecialchars($anuncio['id']) ?>" required>
            <button type="submit">Editar</button>
        </form>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>No hay anuncios disponibles.</p>
<?php endif; 

require_once 'controllers/ComerciosController.php';
$comerciosController = new ComerciosController;
/*
$comerciosController->editar(13);
*/
//require_once 'publicarAnuncio.php'
//editar tambien funciona
//borrar funciona
?>