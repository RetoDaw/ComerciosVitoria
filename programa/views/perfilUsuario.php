<?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if(!isset($_SESSION['id'])){
      header('Location: index.php?controller=UsuariosController&accion=login');
      exit;
    }

    require_once __DIR__ . '/../models/UsuariosModel.php';

    //Obtener datos de usuario
    $usuario = UsuariosModel::getById($_SESSION['id']);

    //si no existe usuario te redirige a index.php
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
        <!-- CSS del header -->
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/registrarse.css">
        <link rel="stylesheet" href="css/iniciarSesion.css">

        <!-- CSS del footer -->
        <link rel="stylesheet" href="css/footerStyle.css">
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
              <button class="btn-perfil" id="favoritos">Mis favoritos</button>
              <button class="btn-perfil" id="anuncios">Mis anuncios</button>
              <button class="btn-perfil" id="anuncios">Mis mensajes</button>
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

  <script>
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
<?php require_once 'layout/footer.php'; ?>
</body>

</html>