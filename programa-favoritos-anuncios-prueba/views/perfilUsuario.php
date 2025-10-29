<?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if(!isset($_SESSION['id'])){
      header('Location: index.php?controller=UsuariosController&accion=login');
      exit;
    }

    require_once __DIR__ . '/../models/UsuariosModel.php';

    $usuario = UsuariosModel::getById($_SESSION['id']);

    if(!$usuario){
      header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="css/perfilUsuario.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/registrarse.css">
        <link rel="stylesheet" href="css/iniciarSesion.css">
        <link rel="stylesheet" href="css/footerStyle.css">
        <link rel="stylesheet" href="css/tarjetas.css">
        <link rel="stylesheet" href="css/popup.css">
    </head>
    <body>
      <?php require_once 'layout/header.php'; ?>
        <div id="contenedor-principal">
          <div id="info">
              <div id="div-saludo">
                  <p id="saludo">¡Hola <?php echo htmlspecialchars($usuario['nombre']); ?>!</p>
              </div>   
              <div id="datos">
                  <p id="tus-datos">Estos son tus datos:</p>
                  <p id="nombre-apellidos">
                      <?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']); ?>
                  </p>        
                  <p id="email"><?php echo htmlspecialchars($usuario['email']); ?></p>
                  <p id="usuario"><?php echo htmlspecialchars($usuario['user_name']); ?></p>
              </div>  
          </div>
          <div id="imagen-botones">
            <img src="img/iniciarSesion.png" alt="">
            <?php if($usuario['tipo_usuario'] !== 'admin'): ?>
              <button class="btn-perfil" id="favoritos">Mis favoritos</button>
              <button class="btn-perfil" id="anuncios">Mis anuncios</button>
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

  <!-- POPUP FAVORITOS -->
  <div id="modalFavoritos" class="modal-anuncios">
    <div class="modal-anuncios__contenido">
      <span class="cerrar-modal" id="cerrarFavoritos">&times;</span>
      <h2>Mis Favoritos</h2>
      <div class="tarjetas-container" id="favoritosContainer">
        <p class="loading">Cargando...</p>
      </div>
    </div>
  </div>

  <!-- POPUP MIS ANUNCIOS -->
  <div id="modalMisAnuncios" class="modal-anuncios">
    <div class="modal-anuncios__contenido">
      <span class="cerrar-modal" id="cerrarMisAnuncios">&times;</span>
      <h2>Mis Anuncios</h2>
      <div class="tarjetas-container" id="misAnunciosContainer">
        <p class="loading">Cargando...</p>
      </div>
    </div>
  </div>

  <!-- POPUP DETALLE ANUNCIO (igual que index.view) -->
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
        <div class="icono-fav">
          <img src="https://cdn-icons-png.flaticon.com/512/1077/1077035.png" 
               width="30px" 
               height="30px" 
               id="popup-favorito">
        </div>
      </div>

      <div id="popup-precio"></div>
      <div id="popup-descripcion"></div>

      <div id="popup-contacto-titulo">Datos de contacto</div>
      <div class="contacto-info">
        <p id="popup-telefono"></p>
        <p id="popup-email"></p>
      </div>

      <button class="enviar">Enviar mensaje</button>
    </div>
  </div>

  <!-- POPUP CREAR CATEGORÍA -->
  <div id="modalCrear" class="modal-categoria">
    <div class="modal-categoria__contenido">
      <span class="cerrar-modal" id="cerrarCrear">&times;</span>
      <h2>Crear categoría</h2>
      <input type="text" placeholder="Nombre">
      <button class="btn-modal">Crear</button>
    </div>
  </div>

  <!-- POPUP BORRAR CATEGORÍA -->
  <div id="modalBorrar" class="modal-categoria">
    <div class="modal-categoria__contenido">
      <span class="cerrar-modal" id="cerrarBorrar">&times;</span>
      <h2>Borrar categoría</h2>
      <select>
        <option>Selecciona</option>
      </select>
      <button class="btn-modal">Borrar</button>
    </div>
  </div>

<script>
const usuarioId = <?php echo $_SESSION['id']; ?>;
let anunciosData = {};

// Modales categorías (admin)
const modalCrear = document.getElementById('modalCrear');
const modalBorrar = document.getElementById('modalBorrar');
const abrirCrear = document.getElementById('abrirCrear');
const abrirBorrar = document.getElementById('abrirBorrar');
const cerrarCrear = document.getElementById('cerrarCrear');
const cerrarBorrar = document.getElementById('cerrarBorrar');

abrirCrear && abrirCrear.addEventListener('click', () => modalCrear.style.display = 'flex');
abrirBorrar && abrirBorrar.addEventListener('click', () => modalBorrar.style.display = 'flex');
cerrarCrear && cerrarCrear.addEventListener('click', () => modalCrear.style.display = 'none');
cerrarBorrar && cerrarBorrar.addEventListener('click', () => modalBorrar.style.display = 'none');

// Modales anuncios
const modalFavoritos = document.getElementById('modalFavoritos');
const modalMisAnuncios = document.getElementById('modalMisAnuncios');
const btnFavoritos = document.getElementById('favoritos');
const btnAnuncios = document.getElementById('anuncios');
const cerrarFavoritos = document.getElementById('cerrarFavoritos');
const cerrarMisAnuncios = document.getElementById('cerrarMisAnuncios');

// Abrir favoritos
btnFavoritos && btnFavoritos.addEventListener('click', async () => {
  modalFavoritos.style.display = 'flex';
  await cargarFavoritos();
});

// Abrir mis anuncios
btnAnuncios && btnAnuncios.addEventListener('click', async () => {
  modalMisAnuncios.style.display = 'flex';
  await cargarMisAnuncios();
});

// Cerrar modales
cerrarFavoritos && cerrarFavoritos.addEventListener('click', () => modalFavoritos.style.display = 'none');
cerrarMisAnuncios && cerrarMisAnuncios.addEventListener('click', () => modalMisAnuncios.style.display = 'none');

// Cerrar al hacer click fuera
window.addEventListener('click', (e) => {
  if (e.target === modalCrear) modalCrear.style.display = 'none';
  if (e.target === modalBorrar) modalBorrar.style.display = 'none';
  if (e.target === modalFavoritos) modalFavoritos.style.display = 'none';
  if (e.target === modalMisAnuncios) modalMisAnuncios.style.display = 'none';
});

// CARGAR FAVORITOS
async function cargarFavoritos() {
  const container = document.getElementById('favoritosContainer');
  container.innerHTML = '<p class="loading">Cargando...</p>';
  
  try {
    const response = await fetch('index.php?controller=FavoritosController&accion=getAll', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id_usuario: usuarioId })
    });
    
    const data = await response.json();
    
    if (data.error) {
      container.innerHTML = '<p class="error">Error al cargar favoritos</p>';
      return;
    }
    
    if (data.favoritos.length === 0) {
      container.innerHTML = '<p class="empty">No tienes anuncios favoritos</p>';
      return;
    }
    
    mostrarAnuncios(data.favoritos, container, true);
  } catch (error) {
    console.error('Error:', error);
    container.innerHTML = '<p class="error">Error al cargar favoritos</p>';
  }
}

// CARGAR MIS ANUNCIOS
async function cargarMisAnuncios() {
  const container = document.getElementById('misAnunciosContainer');
  container.innerHTML = '<p class="loading">Cargando...</p>';
  
  try {
    const response = await fetch('index.php?controller=ComerciosController&accion=misAnuncios', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id_usuario: usuarioId })
    });
    
    const data = await response.json();
    
    if (data.error) {
      container.innerHTML = '<p class="error">Error al cargar anuncios</p>';
      return;
    }
    
    if (data.anuncios.length === 0) {
      container.innerHTML = '<p class="empty">No tienes anuncios publicados</p>';
      return;
    }
    
    mostrarAnuncios(data.anuncios, container, false);
  } catch (error) {
    console.error('Error:', error);
    container.innerHTML = '<p class="error">Error al cargar anuncios</p>';
  }
}

// MOSTRAR ANUNCIOS EN TARJETAS
function mostrarAnuncios(anuncios, container, esFavoritos) {
  container.innerHTML = '';
  anunciosData = {};
  
  anuncios.forEach(anuncio => {
    anunciosData[anuncio.id] = anuncio;
    
    const primeraImagen = anuncio.imagenes && anuncio.imagenes.length > 0 
      ? anuncio.imagenes[0].ruta 
      : 'image.png';
    
    const tarjeta = document.createElement('div');
    tarjeta.className = 'tarjeta';
    tarjeta.innerHTML = `
      <img src="${primeraImagen}" alt="${anuncio.titulo}">
      <h3>${anuncio.titulo}</h3>
      <p class="precio">${parseFloat(anuncio.precio).toFixed(2)} €</p>
      <p class="descripcion">
        ${anuncio.descripcion.substring(0, 45)}${anuncio.descripcion.length > 45 ? '...' : ''}
      </p>
      <p class="categoria"><b>Categoría:</b> ${anuncio.categoria}</p>
      <div class="botones">
        <button class="leer-mas" data-id="${anuncio.id}">Leer más</button>
        ${esFavoritos 
          ? `<div class="icono-fav">
               <img src="https://cdn-icons-png.flaticon.com/512/1077/1077035.png" class="favorito" width="30">
             </div>`
          : `<button class="btn-editar-anuncio" data-id="${anuncio.id}">
               <img src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png" width="25" title="Editar">
             </button>`
        }
      </div>
    `;
    
    container.appendChild(tarjeta);
    
    // Event listener para "Leer más"
    tarjeta.querySelector('.leer-mas').addEventListener('click', () => {
      abrirPopupDetalle(anuncio.id);
    });
    
    // Event listener para "Editar" (solo en mis anuncios)
    if (!esFavoritos) {
      tarjeta.querySelector('.btn-editar-anuncio').addEventListener('click', () => {
        window.location.href = `index.php?controller=ComerciosController&accion=editar&id=${anuncio.id}`;
      });
    }
  });
}

// ABRIR POPUP DETALLE
function abrirPopupDetalle(idAnuncio) {
  const anuncio = anunciosData[idAnuncio];
  if (!anuncio) return;
  
  // Llenar datos del popup
  document.getElementById('popup-titulo').textContent = anuncio.titulo;
  document.getElementById('popup-categoria').textContent = `Categoría: ${anuncio.categoria}`;
  document.getElementById('popup-precio').textContent = `${parseFloat(anuncio.precio).toFixed(2)} €`;
  document.getElementById('popup-descripcion').textContent = anuncio.descripcion;
  
  // Cargar imágenes en el carrusel
  const carouselTrack = document.getElementById('carouselTrack');
  carouselTrack.innerHTML = '';
  
  if (anuncio.imagenes && anuncio.imagenes.length > 0) {
    anuncio.imagenes.forEach(img => {
      const imgElement = document.createElement('img');
      imgElement.src = img.ruta;
      imgElement.alt = anuncio.titulo;
      carouselTrack.appendChild(imgElement);
    });
  } else {
    const imgElement = document.createElement('img');
    imgElement.src = 'image.png';
    imgElement.alt = anuncio.titulo;
    carouselTrack.appendChild(imgElement);
  }
  
  currentSlide = 0;
  updateCarousel();
  
  // Cargar datos de contacto
  cargarDatosContacto(anuncio.id_usuario);
  
  document.getElementById('overlay').style.display = 'flex';
}

async function cargarDatosContacto(idUsuario) {
  try {
    const response = await fetch(`index.php?controller=UsuariosController&accion=datosContacto&id=${idUsuario}`);
    const data = await response.json();
    
    document.getElementById('popup-telefono').textContent = `📞 ${data.telefono || 'No disponible'}`;
    document.getElementById('popup-email').textContent = `📧 ${data.email || 'No disponible'}`;
  } catch (error) {
    console.error('Error al cargar datos de contacto:', error);
  }
}

function closePopup() {
  document.getElementById('overlay').style.display = 'none';
}

// CARRUSEL
let currentSlide = 0;

function moveSlide(direction) {
  const track = document.getElementById('carouselTrack');
  const slides = track.children;
  if (slides.length === 0) return;
  
  currentSlide += direction;
  if (currentSlide < 0) currentSlide = slides.length - 1;
  if (currentSlide >= slides.length) currentSlide = 0;
  
  updateCarousel();
}

function updateCarousel() {
  const track = document.getElementById('carouselTrack');
  const slideWidth = track.offsetWidth;
  track.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
}
</script>

<?php require_once 'layout/footer.php'; ?>
</body>
</html>