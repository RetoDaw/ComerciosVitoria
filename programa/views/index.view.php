<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Anuncios</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/tarjetas.css">
  <link rel="stylesheet" href="css/popup.css">
</head>
<body>

<div class="contenedor-general">
  <div class="tarjetas-container">
    <?php foreach ($anuncios as $index => $anuncio): ?>
      <?php
        // Obtener imágenes del anuncio usando el controlador
        $imagenes = ImagenesController::getByAnuncio($anuncio);
        $primeraImagen = 'image.png'; // Imagen por defecto
        if ($imagenes && !empty($imagenes)) {
          $primeraImagen = $imagenes[0]['ruta'] ?? 'image.png';
        }

        // Obtener la categoría del anuncio usando el controlador
        $nombreCategoria = htmlspecialchars(CategoriasController::nombreCategoria($anuncio));
      ?>
      
      <div class="tarjeta">
        <img src="<?= $primeraImagen ?>" alt="<?= htmlspecialchars($anuncio['titulo']) ?>">
        <h3><?= htmlspecialchars($anuncio['titulo']) ?></h3>
        <p class="precio"><?= number_format($anuncio['precio'], 2) ?> €</p>
        <p class="descripcion">
          <?= substr($anuncio['descripcion'], 0, 45) ?><?= strlen($anuncio['descripcion']) > 45 ? '...' : '' ?>
        </p>
        <p class="categoria"><b>Categoría:</b> <?= $nombreCategoria ?></p>
        <div class="botones">
          <button class="leer-mas" data-id="<?= $anuncio['id'] ?>">Leer más</button>
          <div class="icono-fav"> 
            <img src="https://cdn-icons-png.flaticon.com/512/1077/1077035.png" class="favorito" width="30">
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- POPUP COMPLETO -->
<div id="overlay">
  <div id="popup">
    <button class="close-btn" onclick="closePopup()">✖</button>

    <!-- CARRUSEL DE IMÁGENES -->
    <div class="carousel-container">
      <button class="carousel-button left" onclick="moveSlide(-1)">⬅</button>
      <div class="carousel-track" id="carouselTrack"></div>
      <button class="carousel-button right" onclick="moveSlide(1)">➡</button>
    </div>
    
    <!-- TÍTULO, CATEGORÍA Y FAVORITO -->
    <div id="titulo-categoria-favorito">
      <div id="titulo-categoria">
        <div id="popup-titulo"></div>
        <div id="popup-categoria"></div>
      </div>
      <div class="icono-fav">
        <img src="https://cdn-icons-png.flaticon.com/512/1077/1077035.png" 
             width="30px" 
             height="30px" 
             id="popup-favorito">
      </div>
    </div>

    <!-- PRECIO -->
    <div id="popup-precio"></div>
    
    <!-- DESCRIPCIÓN -->
    <div id="popup-descripcion"></div>

    <!-- CONTACTO -->
    <div id="popup-contacto-titulo">Datos de contacto</div>
    <div class="contacto-info">
      <p id="popup-telefono"></p>
      <p id="popup-email"></p>
    </div>

    <button class="enviar">Enviar mensaje</button>
  </div>
</div>

<script>
  // Preparar datos de anuncios para JavaScript
  const anuncios = {};
  
  <?php foreach ($anuncios as $anuncio): ?>
    <?php
      // Recuperar datos nuevamente aquí también para el popup
      $imagenes = ImagenesController::getByAnuncio($anuncio);
      $nombreCategoria = htmlspecialchars(CategoriasController::nombreCategoria($anuncio));
    ?>
    anuncios[<?= $anuncio['id'] ?>] = {
      id: <?= $anuncio['id'] ?>,
      titulo: <?= json_encode($anuncio['titulo']) ?>,
      precio: <?= $anuncio['precio'] ?>,
      descripcion: <?= json_encode($anuncio['descripcion']) ?>,
      categoria: <?= json_encode($nombreCategoria) ?>,
      imagenes: [
        <?php 
        if ($imagenes && !empty($imagenes)) {
          foreach ($imagenes as $img) {
            echo json_encode($img['ruta']) . ',';
          }
        } else {
          echo "'image.png'";
        }
        ?>
      ],
      contacto: {
        telefono: <?= json_encode($datosUsuario[$anuncio['id']]['telefono'] ?? 'No disponible') ?>,
        email: <?= json_encode($datosUsuario[$anuncio['id']]['email'] ?? 'No disponible') ?>
      }
    };
  <?php endforeach; ?>
</script>
<script src="assets/favorito.js"></script>
<script src="assets/popup.js"></script>

</body>
</html>
