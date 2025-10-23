<?php
$anuncios = [
  [
    'imagen' => 'image.png',
    'titulo' => 'Portátil HP 15"',
    'precio' => 599.99,
    'categoria' => 'Tecnología',
    'descripcion' => 'Portátil HP con procesador Ryzen 5, 16GB RAM y SSD de 512GB. Ideal para estudiantes y profesionales. Incluye Windows 11, teclado retroiluminado y batería de larga duración.',
    'imagenes' => ['image.png', 'image.png', 'image.png'],
    'contacto' => [
      'telefono' => '+34 666 11 11 11',
      'email' => 'ventas.portatil@ejemplo.com'
    ]
  ],
  [
    'imagen' => 'image.png',
    'titulo' => 'iPhone 13 Pro',
    'precio' => 899.99,
    'categoria' => 'Móviles',
    'descripcion' => 'Teléfono Apple iPhone 13 Pro de 128GB en excelente estado, con funda incluida y batería al 90%. Color azul pacífico, sin arañazos, factura original y garantía Apple.',
    'imagenes' => ['image.png', 'image.png', 'image.png'],
    'contacto' => [
      'telefono' => '+34 666 22 22 22',
      'email' => 'iphone13pro@ejemplo.com'
    ]
  ],
  [
    'imagen' => 'image.png',
    'titulo' => 'Silla gaming DXRacer',
    'precio' => 179.50,
    'categoria' => 'Gaming',
    'descripcion' => 'Silla ergonómica para gamers con ajuste lumbar, reposabrazos 4D y tapizado transpirable de alta calidad. Reclinable hasta 180 grados, ruedas de nylon resistentes.',
    'imagenes' => ['image.png', 'image.png', 'image.png'],
    'contacto' => [
      'telefono' => '+34 666 33 33 33',
      'email' => 'silla.gaming@ejemplo.com'
    ]
  ],
  [
    'imagen' => 'image.png',
    'titulo' => 'Monitor Samsung 27"',
    'precio' => 220.00,
    'categoria' => 'Monitores',
    'descripcion' => 'Monitor curvo de 27 pulgadas con resolución Full HD, ideal para oficina o entretenimiento en casa. Frecuencia de 75Hz, tiempo de respuesta 4ms, conexiones HDMI y DisplayPort.',
    'imagenes' => ['image.png', 'image.png', 'image.png'],
    'contacto' => [
      'telefono' => '+34 666 44 44 44',
      'email' => 'monitor.samsung@ejemplo.com'
    ]
  ],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Anuncios</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/tarjetas.css">
  <link rel="stylesheet" href="../css/popup.css">
</head>
<body>

<div class="contenedor-general">
  <div class="tarjetas-container">
    <?php foreach ($anuncios as $index => $anuncio): ?>
      <div class="tarjeta">
        <img src="<?= $anuncio['imagen'] ?>" alt="<?= htmlspecialchars($anuncio['titulo']) ?>">
        <h3><?= htmlspecialchars($anuncio['titulo']) ?></h3>
        <p class="precio"><?= number_format($anuncio['precio'], 2) ?> €</p>
        <p class="descripcion">
          <?= substr($anuncio['descripcion'], 0, 45) ?><?= strlen($anuncio['descripcion']) > 45 ? '...' : '' ?>
        </p>
        <div class="botones">
          <button class="leer-mas" data-id="<?= $index ?>">Leer más</button>
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
  // Datos de anuncios desde PHP
  const anuncios = <?= json_encode($anuncios) ?>;
</script>
<script src="../assets/favorito.js"></script>
<script src="../assets/popup.js"></script>

</body>
</html>