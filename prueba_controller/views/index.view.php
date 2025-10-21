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
            <p><b>ID Categoría:</b> <?= htmlspecialchars($anuncio['id_categoria']) ?></p>
            <p><b>Estado:</b> <?= $anuncio['estado'] ? 'Activo' : 'Inactivo' ?></p>
        <?php
        $ruta = "imagenes/" . $anuncio["id"] . "/";
        echo $ruta;
        // Buscar todas las imágenes dentro de esa carpeta
        $imagenes = glob($ruta . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

        // Mostrar las imágenes si existen
        if ($imagenes) {
            foreach ($imagenes as $img) {
                echo "<img src='$img'>";
            }
        } else {
            echo "<p><b>No hay imágenes disponibles.</b></p>";
        }
        ?>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>No hay anuncios disponibles.</p>
<?php endif; ?>
