<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if(!isset($_SESSION['id'])){
  header('Location: index.php?controller=UsuariosController&accion=login');
  exit;
}

require_once __DIR__ . '/../models/UsuariosModel.php';
require_once __DIR__ . '/../models/FavoritosModel.php';

// Obtener datos de usuario
$usuario = UsuariosModel::getById($_SESSION['id']);

// Si no existe usuario te redirige a index.php
if(!$usuario){
  header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/perfilUsuario.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/registrarse.css">
    <link rel="stylesheet" href="css/iniciarSesion.css">
    <link rel="stylesheet" href="css/footerStyle.css">
    <link rel="stylesheet" href="css/tarjetas.css">
    <link rel="stylesheet" href="css/popup.css">
    <link rel="stylesheet" href="css/editarAnuncio.css">
</head>
<body>
<?php require_once 'layout/header.php'; ?>
<script>
  window.usuarioLogueado = <?= isset($_SESSION['id']) ? 'true' : 'false' ?>;
</script>

<div id="contenedor-principal">
  <div id="info">
      <div id="div-saludo">
          <p id="saludo">¡Hola <?php echo htmlspecialchars($usuario['nombre']); ?>!</p>
      </div>   
      <div id="datos">
          <p id="nombre-apellidos">
              <p class="datos">Nombre Completo</p> <?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']); ?>
          </p>        
          <p id="email"><p class="datos">Correo Electrónico</p> <?php echo htmlspecialchars($usuario['email']); ?></p>
          <p id="usuario"><p class="datos">Usuario</p>   <?php echo htmlspecialchars($usuario['user_name']); ?></p>
      </div>  
  </div>
  
  <!--Depende del tipo de usuario enseña unos botones u otros-->
  <div id="imagen-botones">
    <img src="img/perfil.png" alt="">
    <?php if($usuario['tipo_usuario'] !== 'admin'): ?>
      <button class="btn-perfil" id="btn-favoritos">Mis favoritos</button>
      <button class="btn-perfil" id="btn-anuncios">Mis anuncios</button>
      <a href="index.php?controller=MensajesController&accion=mostrar"><button class="btn-perfil" id="anuncios">Mis mensajes</button></a>
    <?php else: ?>
      <button class="btn-perfil" id="abrirCrear">Crear categoría</button>
      <button class="btn-perfil" id="abrirBorrar">Borrar categoría</button>
    <?php endif; ?>
  </div>
</div>

<div id="editar-boton">
  <a href="index.php?controller=UsuariosController&accion=editar" class="btn-editar">
    <button class="btn-perfil" id="editar">Editar perfil</button>
  </a>
</div>

<!-- SECCIÓN DE FAVORITOS (OCULTA INICIALMENTE) -->
<div id="modalFavoritos" class="modal-categoria">
  <div class="modal-categoria__contenido" style="width: 90%; max-width: 1200px; height: auto; max-height: 90vh;">
    <span class="cerrar-modal" id="cerrarFavoritos">&times;</span>
    <h2 style="margin-bottom: 20px;">Mis Favoritos</h2>
    
    <div id="contenido-favoritos" style="width: 100%;">
      <div class="cargando">
        <p>Cargando tus favoritos...</p>
      </div>
    </div>
  </div>
</div>

<!-- SECCIÓN DE MIS ANUNCIOS -->
<div id="modalAnuncios" class="modal-categoria">
  <div class="modal-categoria__contenido" style="overflow-y: scroll; width: 90%; max-width: 1200px; height: auto; max-height: 90vh;">
    <span class="cerrar-modal" id="cerrarAnuncios">&times;</span>
    <h2 style="margin-bottom: 20px;">Mis Anuncios</h2>

    <div id="contenido-anuncios" style="width: 100%;">
      <div class="cargando">
        <p>Cargando tus anuncios...</p>
      </div>
    </div>
  </div>
</div>

<!-- POPUP CREAR CATEGORÍA -->
<div id="modalCrearCategoria" class="modal-categoria">
  <div class="modal-categoria__contenido" style="width:400px;">
    <span class="cerrar-modal" id="cerrarCrearCategoria">&times;</span>
    <h2 style="color:black; margin-bottom:15px;">Crear categoría</h2>
    <form action="index.php?controller=CategoriasController&accion=store" method="post">
      <input type="text" name="nombre" id="nombreCategoria" placeholder="Nombre de la categoría" style="width:100%;padding:10px;margin-bottom:15px;border-radius:8px;border:1px solid #BB6DA3; " >
      <button  id="btnCrearCategoria" class="btn-perfil" style="width:100%;">Crear</button>
    </form>
  </div>
</div>

<!-- POPUP BORRAR CATEGORÍA -->
<div id="modalBorrarCategoria" class="modal-categoria">
  <div class="modal-categoria__contenido" style="width:400px;">
    <span class="cerrar-modal" id="cerrarBorrarCategoria">&times;</span>
    <h2 style="color:black; margin-bottom:15px;">Borrar categoría</h2>
    <form action="index.php?controller=CategoriasController&accion=destroy" method="post">
      <select id="listaCategorias" name="id" style="width:100%;padding:10px;margin-bottom:15px;border-radius:8px;border:1px solid #BB6DA3;">
        <?php
              require_once 'controllers/CategoriasController.php';
              $categoriasController = new CategoriasController;
              $categorias = $categoriasController->cogerCategorias();
              foreach ($categorias as $categoria):
            ?>
              <option value="<?= $categoria['id'] ?>">
                <?= htmlspecialchars($categoria['nombre']) ?>
              </option>
            <?php endforeach; ?>
      </select>
      <button  class="btn-perfil" style="width:100%;">Borrar</button>
    </form>
  </div>
</div>

<!-- POPUP COMPLETO -->
<div id="overlay">
  <div id="popup">
    <button class="close-btn" onclick="closePopup()">✖</button>

    <div class="carousel-container">
      <button class="carousel-button left" onclick="moveSlide(-1)">⬅</button>
      <div class="carousel-track" id="carouselTrack"></div>
      <button class="carousel-button right" onclick="moveSlide(1)">➡</button>
    </div>

    <div id="titulo-categoria-favorito">
      <div id="titulo-categoria">
        <div id="popup-titulo"></div>
        <div id="popup-categoria"></div>
      </div>
    </div>

    <div id="popup-precio"></div>
    <div id="popup-descripcion"></div>
    <div id="popup-direccion"></div>
    <div id="popup-contacto-titulo">Datos de contacto</div>
    <div class="contacto-info">
      <p id="popup-telefono"></p>
      <p id="popup-email"></p>
    </div>
    <button id="enviarMensaje" class="enviar">Enviar mensaje</button>
  </div>
</div>

<?php require_once 'layout/footer.php'; ?>

<script>
/* =========================================
   VARIABLES GLOBALES Y FUNCIONES GENERALES
========================================= */
const anuncios = {}; // Objeto global para almacenar todos los anuncios

/* =========================================
   FUNCIONES DE POPUP Y CARRUSEL
========================================= */

function abrirPopup(anuncio) {
  if (!anuncio) return;

  const track = document.getElementById('carouselTrack');
  track.innerHTML = '';

  // Cargar imágenes - Asegúrate de que anuncio.imagenes existe
  if (anuncio.imagenes && anuncio.imagenes.length > 0) {
    anuncio.imagenes.forEach(img => {
      const item = document.createElement('div');
      item.className = 'carousel-item';
      item.innerHTML = `<img src="${img}" alt="${anuncio.titulo}">`;
      track.appendChild(item);
    });
  } else {
    const item = document.createElement('div');
    item.className = 'carousel-item';
    item.innerHTML = `<img src="image.png" alt="${anuncio.titulo}">`;
    track.appendChild(item);
  }

  // Llenar datos
  document.getElementById('popup-titulo').textContent = anuncio.titulo;
  document.getElementById('popup-categoria').textContent = anuncio.categoria || 'Sin categoría';
  document.getElementById('popup-precio').textContent = new Intl.NumberFormat('es-ES', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(anuncio.precio) + ' €';
  document.getElementById('popup-descripcion').textContent = anuncio.descripcion;
  document.getElementById('popup-direccion').textContent = '📍 ' + (anuncio.direccion || 'No disponible');

  // Datos de contacto
  fetch('index.php?id=' + anuncio.id_usuario + '&controller=UsuariosController&accion=datosContacto')
    .then(res => res.json())
    .then(datos => {
      document.getElementById('popup-telefono').innerHTML = '📞 ' + (datos.telefono || 'No disponible');
      document.getElementById('popup-email').innerHTML = '✉️ ' + (datos.email || 'No disponible');
    });

  // Configurar botón de mensaje
  const btnMensaje = document.getElementById('enviarMensaje');
  btnMensaje.onclick = function() {
    enviarMensaje(anuncio.id_usuario);
  };

  document.getElementById('overlay').classList.add('active');
  initializeCarousel();
}

function closePopup() {
  document.getElementById('overlay').classList.remove('active');
}

// Función para enviar mensaje
async function enviarMensaje(idUsuarioDestino) {
  if (!window.usuarioLogueado) {
    alert('Debes iniciar sesión para enviar mensajes.');
    return;
  }
  
  const res = await fetch('index.php?controller=MensajesController&accion=index', {
    method: 'POST', 
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        id_usuario: idUsuarioDestino
    })
  });

  const data = await res.json();
  window.location.href = data.redirect;
}

// CARRUSEL
let currentSlide = 0;
let totalSlides = 0;
let slideWidth = 0;

function initializeCarousel() {
  const track = document.getElementById('carouselTrack');
  const container = document.querySelector('.carousel-container');
  const items = document.querySelectorAll('.carousel-item');

  totalSlides = items.length;
  slideWidth = container.clientWidth;
  currentSlide = 0;

  track.style.transform = `translateX(0px)`;
}

function moveSlide(direction) {
  const track = document.getElementById('carouselTrack');
  const container = document.querySelector('.carousel-container');
  slideWidth = container.clientWidth;
  currentSlide += direction;

  if (currentSlide < 0) currentSlide = totalSlides - 1;
  else if (currentSlide >= totalSlides) currentSlide = 0;

  track.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
}

// ESC o click fuera para cerrar
document.addEventListener('keydown', e => { if(e.key==='Escape') closePopup(); });
document.getElementById('overlay').addEventListener('click', e => { if(e.target===e.currentTarget) closePopup(); });

/* =========================================
   DELEGACIÓN DE EVENTOS PARA BOTONES
========================================= */

// Delegación de eventos para los botones "Leer más"
document.addEventListener('click', (e) => {
  if (e.target.classList.contains('leer-mas') || e.target.closest('.leer-mas')) {
    const btn = e.target.classList.contains('leer-mas') ? e.target : e.target.closest('.leer-mas');
    const id = btn.dataset.id;
    
    // Buscar el anuncio en el objeto global
    const anuncio = anuncios[id];
    
    if (!anuncio) {
      console.error('Anuncio no encontrado con ID:', id);
      return;
    }
    
    abrirPopup(anuncio);
  }
});
</script>

<script src="assets/favorito.js"></script>

<script>
/* =========================================
   CARGA DINÁMICA DE FAVORITOS Y MIS ANUNCIOS
========================================= */
const btnFavoritos = document.getElementById('btn-favoritos');
const modalFavoritos = document.getElementById('modalFavoritos');
const cerrarFavoritos = document.getElementById('cerrarFavoritos');
const contenidoFavoritos = document.getElementById('contenido-favoritos');

async function cargarFavoritos() {
  contenidoFavoritos.innerHTML = '<p>Cargando tus favoritos...</p>';
  const res = await fetch('?controller=FavoritosController&accion=getAll', {method:'POST'});
  const data = await res.json();

  if(data.success && data.favoritos && data.favoritos.length>0){
    contenidoFavoritos.innerHTML = `<div class="tarjetas-container" style="display:grid;gap:20px;"></div>`;
    const cont = contenidoFavoritos.querySelector('.tarjetas-container');
    
    data.favoritos.forEach(anuncio => {
      // Guardar en el objeto global anuncios
      anuncios[anuncio.id] = anuncio;
      
      const div = document.createElement('div');
      div.className = 'tarjeta';
      div.innerHTML = `
        <img src="${anuncio.imagenes?.[0]||'image.png'}" alt="${anuncio.titulo}">
        <h3>${anuncio.titulo}</h3>
        <p class="precio">${parseFloat(anuncio.precio).toFixed(2)} €</p>
        <p class="descripcion">${anuncio.descripcion.substring(0,45)}${anuncio.descripcion.length>45?'...':''}</p>
        <p class="categoria"><b>Categoría:</b> ${anuncio.categoria||'Sin categoría'}</p>
        <div class="botones">
          <button class="leer-mas" data-id="${anuncio.id}">Leer más</button>
          <div class="icono-fav">
            <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png" class="favorito" width="30" data-id="${anuncio.id}">
          </div>
        </div>`;
      cont.appendChild(div);
    });
  } else {
    contenidoFavoritos.innerHTML = '<p>No tienes favoritos.</p>';
  }
}

btnFavoritos.addEventListener('click', () => {
  cargarFavoritos();
  modalFavoritos.style.display='flex';
});
cerrarFavoritos.addEventListener('click', ()=> modalFavoritos.style.display='none');
modalFavoritos.addEventListener('click', e=>{ if(e.target===modalFavoritos) modalFavoritos.style.display='none'; });

// Mis Anuncios
const btnAnuncios = document.getElementById('btn-anuncios');
const modalAnuncios = document.getElementById('modalAnuncios');
const cerrarAnuncios = document.getElementById('cerrarAnuncios');
const contenidoAnuncios = document.getElementById('contenido-anuncios');

async function cargarMisAnuncios() {
  contenidoAnuncios.innerHTML = '<p>Cargando tus anuncios...</p>';
  const res = await fetch('?controller=ComerciosController&accion=getByUser',{method:'POST'});
  const data = await res.json();

  if(data.success && data.anuncios && data.anuncios.length>0){
    contenidoAnuncios.innerHTML = `<div class="tarjetas-container" style="display:grid;gap:20px;"></div>`;
    const cont = contenidoAnuncios.querySelector('.tarjetas-container');
    
    data.anuncios.forEach(anuncio => {
      // Guardar en el objeto global anuncios
      anuncios[anuncio.id] = anuncio;
      
      const div = document.createElement('div');
      div.className = 'tarjeta';
      div.innerHTML = `
        <img src="${anuncio.imagenes?.[0]||'image.png'}" alt="${anuncio.titulo}">
        <h3>${anuncio.titulo}</h3>
        <p class="precio">${parseFloat(anuncio.precio).toFixed(2)} €</p>
        <p class="descripcion">${anuncio.descripcion.substring(0,45)}${anuncio.descripcion.length>45?'...':''}</p>
        <p class="categoria"><b>Categoría:</b> ${anuncio.categoria||'Sin categoría'}</p>
        <div class="botones">
          <button class="leer-mas" data-id="${anuncio.id}">Leer más</button>
          <a href="?controller=ComerciosController&accion=editar&id=${anuncio.id}">
            <button id="editar-anuncio">Editar</button>
          </a>
        </div>`;
      cont.appendChild(div);
    });
  } else {
    contenidoAnuncios.innerHTML = '<p>No has publicado anuncios.</p>';
  }
}

btnAnuncios.addEventListener('click', ()=>{
  cargarMisAnuncios();
  modalAnuncios.style.display='flex';
});
cerrarAnuncios.addEventListener('click',()=>modalAnuncios.style.display='none');
modalAnuncios.addEventListener('click',e=>{if(e.target===modalAnuncios) modalAnuncios.style.display='none';});
</script>
<script>
// ==================== POPUP CREAR CATEGORÍA ====================
const btnAbrirCrear = document.getElementById('abrirCrear');
const modalCrear = document.getElementById('modalCrearCategoria');
const cerrarCrear = document.getElementById('cerrarCrearCategoria');
const btnCrearCategoria = document.getElementById('btnCrearCategoria');

btnAbrirCrear.addEventListener('click', () => modalCrear.style.display = 'flex');
cerrarCrear.addEventListener('click', () => modalCrear.style.display = 'none');
modalCrear.addEventListener('click', e => { if (e.target === modalCrear) modalCrear.style.display = 'none'; });

btnCrearCategoria.addEventListener('click', async () => {
  const nombre = document.getElementById('nombreCategoria').value.trim();
  if (!nombre) return alert('Introduce un nombre de categoría.');

    const res = await fetch('index.php?controller=CategoriasController&accion=store', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ nombre })
    });
    const data = await res.json();

    if (data.success) {
      alert(' Categoría creada correctamente.');
      document.getElementById('nombreCategoria').value = '';
      modalCrear.style.display = 'none';
    }
});

// ==================== POPUP BORRAR CATEGORÍA ====================
const btnAbrirBorrar = document.getElementById('abrirBorrar');
const modalBorrar = document.getElementById('modalBorrarCategoria');
const cerrarBorrar = document.getElementById('cerrarBorrarCategoria');
const btnBorrarCategoria = document.getElementById('btnBorrarCategoria');

btnAbrirBorrar.addEventListener('click', () => {
  modalBorrar.style.display = 'flex';
});
cerrarBorrar.addEventListener('click', () => modalBorrar.style.display = 'none');
modalBorrar.addEventListener('click', e => { if (e.target === modalBorrar) modalBorrar.style.display = 'none'; });

// Cargar opciones en el select

</script>

</body>
</html>