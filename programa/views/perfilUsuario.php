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
        <!-- CSS del header -->
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/registrarse.css">
        <link rel="stylesheet" href="css/iniciarSesion.css">

        <!-- CSS del footer -->
        <link rel="stylesheet" href="css/footerStyle.css">
        
        <!-- CSS de las tarjetas y popup -->
        <link rel="stylesheet" href="css/tarjetas.css">
        <link rel="stylesheet" href="css/popup.css">

        <link rel="stylesheet" href="css/editarAnuncio.css">
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
          
          <!--Depende del tipo de usuario enseña unos botones u otros-->
          <div id="imagen-botones">
            <img src="img/iniciarSesion.png" alt="">
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
          <div class="modal-categoria__contenido" style="width: 90%; max-width: 1200px; height: auto; max-height: 90vh;">
            <span class="cerrar-modal" id="cerrarAnuncios">&times;</span>
            <h2 style="margin-bottom: 20px;">Mis Anuncios</h2>

            <div id="contenido-anuncios" style="width: 100%;">
              <div class="cargando">
                <p>Cargando tus anuncios...</p>
              </div>
            </div>
          </div>
        </div>


        <!-- POPUP CREAR -->
        <div id="modalCrear" class="modal-categoria">
          <div class="modal-categoria__contenido">
            <span class="cerrar-modal" id="cerrarCrear">&times;</span>
            <h2>Crear categoría</h2>
            <input type="text" placeholder="Nombre">
            <button class="btn-modal">Crear</button>
          </div>
        </div>

        <!-- POPUP BORRAR -->
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
            <button id="enviarMensaje" class="enviar">Enviar mensaje</button>
          </div>
        </div>
        
        <?php require_once 'layout/footer.php'; ?>
        
        <script>
          // Control de la sección de favoritos
          const btnFavoritos = document.getElementById('btn-favoritos');
          const modalFavoritos = document.getElementById('modalFavoritos');
          const cerrarFavoritos = document.getElementById('cerrarFavoritos');
          const contenidoFavoritos = document.getElementById('contenido-favoritos');

          // Función para cargar favoritos via AJAX
          async function cargarFavoritos() {
            try {
              contenidoFavoritos.innerHTML = '<div class="cargando"><p>Cargando tus favoritos...</p></div>';
              
              const response = await fetch('?controller=FavoritosController&accion=getAll', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({})
              });
              
              const data = await response.json();
              
              if (data.success && data.favoritos && data.favoritos.length > 0) {
                contenidoFavoritos.innerHTML = `
                  <div class="tarjetas-container" style="padding: 20px; display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; max-height: 70vh; overflow-y: auto;">
                    ${data.favoritos.map(anuncio => `
                      <div class="tarjeta">
                        <img src="${anuncio.imagen || 'image.png'}" alt="${anuncio.titulo}">
                        <h3>${anuncio.titulo}</h3>
                        <p class="precio">${parseFloat(anuncio.precio).toFixed(2)} €</p>
                        <p class="descripcion">
                          ${anuncio.descripcion.substring(0, 45)}${anuncio.descripcion.length > 45 ? '...' : ''}
                        </p>
                        <p class="categoria"><b>Categoría:</b> ${anuncio.categoria || 'Sin categoría'}</p>
                        <div class="botones">
                          <button class="leer-mas" data-id="${anuncio.id}">Leer más</button>
                          <div class="icono-fav">
                            <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png" 
                                 class="favorito" 
                                 width="30"
                                 data-favorito="true"
                                 data-id="${anuncio.id}">
                          </div>
                        </div>
                      </div>
                    `).join('')}
                  </div>
                `;
                
                // Inicializar funcionalidad de favoritos después de cargar
                setTimeout(() => {
                  if (typeof initFavoritos === 'function') {
                    initFavoritos();
                  }
                }, 100);
                
              } else {
                contenidoFavoritos.innerHTML = `
                  <div class="sin-contenido" style="padding: 40px; text-align: center; color: #666;">
                    <p>No tienes anuncios favoritos todavía.</p>
                    <p>¡Explora los anuncios y añade tus favoritos!</p>
                  </div>
                `;
              }
            } catch (error) {
              console.error('Error cargando favoritos:', error);
              contenidoFavoritos.innerHTML = `
                <div class="sin-contenido" style="padding: 40px; text-align: center; color: #666;">
                  <p>Error al cargar los favoritos.</p>
                  <p>Inténtalo de nuevo más tarde.</p>
                </div>
              `;
            }
          }

          if (btnFavoritos && modalFavoritos) {
            btnFavoritos.addEventListener('click', () => {
              cargarFavoritos();
              modalFavoritos.style.display = 'flex';
            });

            cerrarFavoritos.addEventListener('click', () => {
              modalFavoritos.style.display = 'none';
            });

            // Cerrar al hacer click fuera del contenido
            modalFavoritos.addEventListener('click', (e) => {
              if (e.target === modalFavoritos) {
                modalFavoritos.style.display = 'none';
              }
            });
          }

          // Modales existentes
          const modalCrear = document.getElementById('modalCrear');
          const modalBorrar = document.getElementById('modalBorrar');
          const abrirCrear = document.getElementById('abrirCrear');
          const abrirBorrar = document.getElementById('abrirBorrar');
          const cerrarCrear = document.getElementById('cerrarCrear');
          const cerrarBorrar = document.getElementById('cerrarBorrar');

          // Abrir
          abrirCrear && abrirCrear.addEventListener('click', () => modalCrear.style.display = 'flex');
          abrirBorrar && abrirBorrar.addEventListener('click', () => modalBorrar.style.display = 'flex');

          // Cerrar
          cerrarCrear && cerrarCrear.addEventListener('click', () => modalCrear.style.display = 'none');
          cerrarBorrar && cerrarBorrar.addEventListener('click', () => modalBorrar.style.display = 'none');

          // Cerrar al hacer click fuera
          window.addEventListener('click', (e) => {
            if (e.target === modalCrear) modalCrear.style.display = 'none';
            if (e.target === modalBorrar) modalBorrar.style.display = 'none';
          });
        </script>

        <script>
          // MIS ANUNCIOS
            const btnAnuncios = document.getElementById('btn-anuncios');
            const modalAnuncios = document.getElementById('modalAnuncios');
            const cerrarAnuncios = document.getElementById('cerrarAnuncios');
            const contenidoAnuncios = document.getElementById('contenido-anuncios');

            async function cargarMisAnuncios() {
              try {
                contenidoAnuncios.innerHTML = '<div class="cargando"><p>Cargando tus anuncios...</p></div>';

                const response = await fetch('?controller=ComerciosController&accion=getByUser', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify({})
                });

                const data = await response.json();

                if (data.success && data.anuncios && data.anuncios.length > 0) {
                  contenidoAnuncios.innerHTML = `
                    <div class="tarjetas-container"
                        style="padding: 20px; display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; max-height: 70vh; overflow-y: auto;">
                      ${data.anuncios.map(a => `
                        <div class="tarjeta">
                          <img src="${a.imagen || 'image.png'}" alt="${a.titulo}">
                          <h3>${a.titulo}</h3>
                          <p class="precio">${parseFloat(a.precio).toFixed(2)} €</p>
                          <p class="descripcion">
                            ${a.descripcion.substring(0, 45)}${a.descripcion.length > 45 ? '...' : ''}
                          </p>
                          <p class="categoria"><b>Categoría:</b> ${a.categoria || 'Sin categoría'}</p>

                          <div class="botones">
                            <button class="leer-mas" data-id="${a.id}">Leer más</button>
                            <a href="?controller=ComerciosController&accion=editar&id=${a.id}">
                              <button class="editar-anuncio">Editar</button>
                            </a>
                          </div>
                        </div>
                      `).join('')}
                    </div>
                  `;
                } else {
                  contenidoAnuncios.innerHTML = `
                    <div class="sin-contenido" style="padding: 40px; text-align: center; color: #666;">
                      <p>No has publicado ningún anuncio todavía.</p>
                    </div>
                  `;
                }

              } catch (e) {
                console.error(e);
                contenidoAnuncios.innerHTML = `
                  <p style="text-align:center;color:red;">Error cargando tus anuncios.</p>
                `;
              }
            }

            // Eventos modal anuncios
            btnAnuncios.addEventListener('click', () => {
              cargarMisAnuncios();
              modalAnuncios.style.display = 'flex';
            });
            cerrarAnuncios.addEventListener('click', () => modalAnuncios.style.display = 'none');
            modalAnuncios.addEventListener('click', (e) => {
              if (e.target === modalAnuncios) modalAnuncios.style.display = 'none';
            });

        </script>

        <script src="assets/favorito.js"></script>
        <script src="assets/popup.js"></script>

    </body>
</html>