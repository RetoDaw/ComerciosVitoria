<?php
    session_start();
?>
<!--
    IMPORTANTE

        FALTA POR AÑADIR LA FOTO DE PERFIL DEPENDIENDO DEL USUARIO
        +
        MOSTRAR MIS FAVORITOS Y MIS ANUNCIOS
        +
        AÑADIR INSERT DELETE Y SELECT DE LAS CATEGORIAS
-->
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
  <div id="contenedor-principal">
    <div id="info">
      <div id="div-saludo">
        <p id="saludo">¡Hola <?php echo $_SESSION['nombre'];?>!</p>
      </div>   
      <div id="datos">
        <p id="tus-datos">Estos son tus datos:</p>
        <p id="nombre-apellidos">
            <!--Enseña los diferentes datos del usuario-->
          <?php 
            $usuario = UsuariosModel::getById($_SESSION['id']);
            echo $usuario['nombre'] . ' ' . $usuario['apellidos'];
          ?>
        </p>        
        <p id="email"><?php echo $usuario['email']; ?></p>
        <p id="usuario"><?php echo '@' . $usuario['user_name']; ?></p>
      </div>  
    </div>
            <!--Depende del tipo de usuario enseña unos botones u otros-->
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
    <a href="../views/editarPerfil.php" style="text-decoration: none;"><button id="editar" onclick>Editar Perfil</button></a>
  </div>

  <!-- POPUP CREAR -->
  <div id="modalCrear" class="modal">
    <div class="modal-contenido">
      <span class="cerrar" id="cerrarCrear">&times;</span>
      <h2>Crear categoría</h2>
      <input type="text" placeholder="Nombre">
      <button id="popups">Crear</button>
    </div>
  </div>

  <!-- POPUP BORRAR -->
  <div id="modalBorrar" class="modal">
    <div class="modal-contenido">
      <span class="cerrar" id="cerrarBorrar">&times;</span>
      <h2>Borrar categoría</h2>
      <select>
        <option>Selecciona</option>
      </select>
      <button id="popups">Borrar</button>
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
</body>

</html>