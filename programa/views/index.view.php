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
        <p><b>Título:</b> <?= $anuncio['titulo'] ?></p>
        <p><b>Descripción:</b> <?= $anuncio['descripcion'] ?></p>
        <p><b>Teléfono:</b> <?= $anuncio['telefono_contacto'] ?></p>
        <p><b>Email:</b> <?= $anuncio['email_contacto'] ?></p>
        <p><b>Dirección:</b> <?= $anuncio['direccion'] ?></p>
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
