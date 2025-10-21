<!doctype html>
<html lang="es">
<head>
<meta charset="UTF-8">
  <link rel="stylesheet" href="css/registrarse.css"/>
  <link rel="stylesheet" href="css/iniciarSesion.css"/>
  <link rel="stylesheet" href="css/header.css"/>

</head>

<body>
    <div id="header">
        <div id="logo-titulo">
            <img src="img/logo.png" id="logo" height="60" width="100">
            <p id="titulo">PURPOR</p>
        </div>

        <div id="busqueda">
            <img src="img/lupa2.png" alt="" id="lupa" height="30" width="30">
            <input type="text" name="buscador" id="buscador" placeholder="Buscar anuncios" >
        </div>

        <div id="botones">
            <button function="crearPublicacion" id="publicar">
            <img src="img/publicar.png" alt="" width="20px" height="20px" class="img">Publicar
            </button>
            <button id="openPopupInicio" class="boton">
            <img src="img/iniciarSesion.png" alt="" width="20px" height="20px" class="img"> Iniciar Sesión
            </button>
        </div>
    </div>

    <!-- Popup Iniciar Sesión -->
    <div id="overlayInicio">
        <div class="popupinicio">
            <button class="cerrar" id="closePopupInicio">x</button>
            <h2>Iniciar Sesión</h2>
            <form>
                <input type="text" placeholder="Usuario" required />
                <input type="password" placeholder="Contraseña" required />
                <button type="submit" class="botoninicio" id="continuar">Continuar</button>
            </form>
            <p>¿No tienes cuenta? <a id="openPopupRegistro">Regístrate</a></p>
        </div>
    </div>

    <!-- Popup Registrarse -->
    <div id="overlayRegistro">
        <div class="popupregistro">
            <button class="cerrar" id="closePopupRegistro">×</button>
            <h2>Registrarme</h2>
            <form>
                <input type="text" placeholder="Nombre" required />
                <input type="text" placeholder="Apellidos" required />
                <input type="date" placeholder="Fecha de nacimiento" required />
                <input type="email" placeholder="Email" required />
                <input type="tel" placeholder="Teléfono (opcional)" />
                <input type="text" placeholder="Usuario" required />
                <input type="password" placeholder="Contraseña" required />
                <input type="password" placeholder="Repite la contraseña" required />
                <button type="submit" class="boton">Registrarme</button>
            </form>
            <p>¿Ya tienes cuenta? <a id="abrirInicioDesdeRegistro">Inicia Sesión</a></p>
        </div>
    </div>

    <script>
        // Popup Inicio Sesión
        const openBtn = document.getElementById('openPopupInicio');
        const closeBtn = document.getElementById('closePopupInicio');
        const overlay = document.getElementById('overlayInicio');

        openBtn.addEventListener('click', () => overlay.style.display = 'flex');
        closeBtn.addEventListener('click', () => overlay.style.display = 'none');
        overlay.addEventListener('click', e => {
                                if (e.target === overlay) overlay.style.display = 'none';
                               });

        // Popup Registrarse
        const openRegistro = document.getElementById('openPopupRegistro');
        const closeRegistro = document.getElementById('closePopupRegistro');
        const overlayRegistro = document.getElementById('overlayRegistro');

        openRegistro.addEventListener('click', () => overlayRegistro.style.display = 'flex');
        closeRegistro.addEventListener('click', () => overlayRegistro.style.display = 'none');
        overlayRegistro.addEventListener('click', e => {
                                        if(e.target === overlayRegistro) overlayRegistro.style.display = 'none';
                                         });

        // Abrir registro desde inicio
        const abrirRegistroDesdeInicio = document.getElementById('openPopupRegistro');
        abrirRegistroDesdeInicio.addEventListener('click', () => {
                                                    overlay.style.display = 'none';
                                                    overlayRegistro.style.display = 'flex';
                                                });

        // Abrir inicio desde registro
        const abrirInicioDesdeRegistro = document.getElementById('abrirInicioDesdeRegistro');
        abrirInicioDesdeRegistro.addEventListener('click', () => {
                                                     overlayRegistro.style.display = 'none';
                                                     overlay.style.display = 'flex';
                                                     });
    </script>
</body>
</html>
