<!-- layout/header.php -->

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
        <form action="../views/publicarAnuncio.php" method="get">
            <button function="crearPublicacion" id="publicar">
                <img src="img/publicar.png" alt="" width="20px" height="20px" class="img">
                Publicar
            </button>
        </form>   
        
        <button id="openPopupInicio" class="boton">
            <img src="img/iniciarSesion.png" alt="" width="20px" height="20px" class="img"> 
            Iniciar Sesión
        </button>
    </div>
</div>

<!-- Overlay para el popup de inicio de sesión -->
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

<!-- Overlay para el popup de registro -->
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

<!-- Controlar la apertura y cierre de los popups -->
<script>
    const openBtn = document.getElementById('openPopupInicio');
    const closeBtn = document.getElementById('closePopupInicio');
    const overlay = document.getElementById('overlayInicio');
    // Abrir y cerrar popup de inicip
    openBtn.addEventListener('click', () => overlay.style.display = 'flex');
    closeBtn.addEventListener('click', () => overlay.style.display = 'none');
    overlay.addEventListener('click', e => {
        if (e.target === overlay) overlay.style.display = 'none';
    });

    const openRegistro = document.getElementById('openPopupRegistro');
    const closeRegistro = document.getElementById('closePopupRegistro');
    const overlayRegistro = document.getElementById('overlayRegistro');

    // Abrir y cerrar popup de registro
    openRegistro.addEventListener('click', () => overlayRegistro.style.display = 'flex');
    closeRegistro.addEventListener('click', () => overlayRegistro.style.display = 'none');
    overlayRegistro.addEventListener('click', e => {
        if(e.target === overlayRegistro) overlayRegistro.style.display = 'none';
    });

    // Abrir registro desde el popup de inicio de sesión
    const abrirRegistroDesdeInicio = document.getElementById('openPopupRegistro');
    abrirRegistroDesdeInicio.addEventListener('click', () => {
        overlay.style.display = 'none';
        overlayRegistro.style.display = 'flex';
    });

    // Abrir inicio desde el popup de registro
    const abrirInicioDesdeRegistro = document.getElementById('abrirInicioDesdeRegistro');
    abrirInicioDesdeRegistro.addEventListener('click', () => {
        overlayRegistro.style.display = 'none';
        overlay.style.display = 'flex';
    });
</script>