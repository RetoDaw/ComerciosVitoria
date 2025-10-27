<!-- layout/header.php -->

<div id="header">
    <div id="header-logo-titulo">
        <img src="img/logo.png" id="logo" height="60" width="100">
        <h4 id="header-titulo">PURPOR</h4>
    </div>

    <div class="header-buscador">
        <img src="img/lupa2.png" alt="Buscar" class="header-icono-buscar">
        <input type="text" class="header-input-buscar" placeholder="Buscar anuncios...">
    </div>

    <div id="botones">
        <?php if(isset($_SESSION['id']) && !empty($_SESSION['id'])):?>
            <a href="index.php?controller=ComerciosController&accion=crear">
                <button id="publicar">
                    <img src="img/publicar.png" alt="" width="20px" height="20px" class="img">
                    Publicar
                </button>
            </a>   
            
            <a href="index.php?controller=UsuariosController">
                <button id="perfil">
                    <img src="img/iniciarSesion.png" alt="" width="20px" height="20px" class="img"> 
                    Perfil
                </button>
            </a>  

            <?php /*
            <button id="openPopupCerrar" class="boton">
                <img src="img/iniciarSesion.png" alt="" width="20px" height="20px" class="img"> 
                Cerrar Sesión
            </button>

            <script>
                let cerrar = document.getElementById('openPopupCerrar');
                cerrar.addEventListener('click', cerrarSesion);
                console.log(btn)
                async function cerrarSesion(){       
                    const res = await fetch('http://programa.test/?controller=UsuariosController&accion=cerrarSesion');

                    const data = await res.json();

                    window.location.href = data.redirect ?? 'index.php';
                }
            </script>
            */?>

        <?php else:?>
            <button id="openPopupInicio" class="boton">
                <img src="img/iniciarSesion.png" alt="" width="20px" height="20px" class="img"> 
                Iniciar Sesión
            </button>
        <?php endif;?>
    </div>
</div>

<!-- Overlay para el popup de inicio de sesión -->
<div id="overlay-login">
    <div class="popup-login">
        <button class="cerrar-login" id="closePopupInicio">✖</button>
        <h2>Iniciar Sesión</h2>
        <form>
            <input type="text" id="usuario" name="user_name" placeholder="Usuario" required />
            <input type="password" id="password" name="password" placeholder="Contraseña" required />
            <button type="button" class="botoninicio" id="continuar">Continuar</button>
        </form>
        <p>¿No tienes cuenta? <a id="openPopupRegistro">Regístrate</a></p>
        <script>
            let btn = document.getElementById('continuar');
            btn.addEventListener('click', enviar);
            console.log(btn)
            async function enviar(){
                const user_name =  document.querySelector('input[name="user_name"]').value.trim();
                const password =  document.querySelector('input[name="password"]').value.trim();
                
                const res = await fetch('http://programa.test/?controller=UsuariosController&accion=verificarUsuario', {
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        user_name: user_name,
                        password: password
                    })
                });

                const data = await res.json();
                if (!data.success) {
                    alert(data.message);
                    let usuario = document.getElementById('usuario');
                    usuario.value = '';
                    let password = document.getElementById('password');
                    password.value = '';
                    return;
                }

                window.location.href = data.redirect ?? 'index.php';
            }
        </script>
    </div>
</div>

<!-- Overlay para el popup de registro -->
<div id="overlay-registro">
    <div class="popup-registro">
        <button class="cerrar-registro" id="closePopupRegistro">✖</button>
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
            <button type="submit" class="boton-registro">Registrarme</button>
        </form>
        <p>¿Ya tienes cuenta? <a id="abrirInicioDesdeRegistro">Inicia Sesión</a></p>
    </div>
</div>

<!-- Controlar la apertura y cierre de los popups -->
<script>
    const openBtn = document.getElementById('openPopupInicio');
    const closeBtn = document.getElementById('closePopupInicio');
    const overlayLogin = document.getElementById('overlay-login');
    
    // Abrir y cerrar popup de inicio
    openBtn.addEventListener('click', () => overlayLogin.style.display = 'flex');
    closeBtn.addEventListener('click', () => overlayLogin.style.display = 'none');
    overlayLogin.addEventListener('click', e => {
        if (e.target === overlayLogin) overlayLogin.style.display = 'none';
    });

    const openRegistro = document.getElementById('openPopupRegistro');
    const closeRegistro = document.getElementById('closePopupRegistro');
    const overlayRegistro = document.getElementById('overlay-registro');

    // Abrir y cerrar popup de registro
    openRegistro.addEventListener('click', () => overlayRegistro.style.display = 'flex');
    closeRegistro.addEventListener('click', () => overlayRegistro.style.display = 'none');
    overlayRegistro.addEventListener('click', e => {
        if(e.target === overlayRegistro) overlayRegistro.style.display = 'none';
    });

    // Abrir registro desde el popup de inicio de sesión
    const abrirRegistroDesdeInicio = document.getElementById('openPopupRegistro');
    abrirRegistroDesdeInicio.addEventListener('click', () => {
        overlayLogin.style.display = 'none';
        overlayRegistro.style.display = 'flex';
    });

    // Abrir inicio desde el popup de registro
    const abrirInicioDesdeRegistro = document.getElementById('abrirInicioDesdeRegistro');
    abrirInicioDesdeRegistro.addEventListener('click', () => {
        overlayRegistro.style.display = 'none';
        overlayLogin.style.display = 'flex';
    });
</script>