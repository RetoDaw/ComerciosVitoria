<head>
    <style>
        img{
            width: 100px;
            height: 100px;
        }
    </style>
</head>
    <?php 
    require = '../views/layout/header.php'
    require = '../views/layout/footer.php'
    ?>
    
    <div id="popup">
        <div id="popupContent">
            <span id="closePopup">X</span>
            <div id="popupBody">
                
            </div>
        </div>
    </div>
<?php if (isset($anuncios) && !empty($anuncios)): ?>

    <?php foreach ($anuncios as $anuncio): ?>
        <div class="anuncio" onlcick="mostrarPopup(<?= $anuncio['id']?>)">
        <p><b>Título:</b> <?= $anuncio['titulo'] ?></p>
        <p><b>Descripción:</b> <?= $anuncio['descripcion'] ?></p>
        <p><b>Teléfono:</b> <?= $anuncio['telefono_contacto'] ?></p>
        <p><b>Email:</b> <?= $anuncio['email_contacto'] ?></p>
        <p><b>Dirección:</b> <?= $anuncio['direccion'] ?></p>
        </div>
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
<script>
    const popup = document.getElementById('popup');
    const popupBody = document.getElementById('popupBody');
    const closePopup = document.getElementById('closePopup');

    function mostrarPopup(anuncioId){
        const anuncioDiv = document.querySelector(`.anuncio[onclick='mostrarPopup(${anuncioId})']`);
        popupBody.innerHTML = anuncioDiv.innerHTML;
        popup.style.display = "flex";
    }

    closePopup.addEventListener('click', () => {
        popup.style.display = "none";
    });

    // Cerrar al hacer click fuera del contenido
    popup.addEventListener('click', (e) => {
        if(e.target === popup) popup.style.display = "none";
    });
</script>
