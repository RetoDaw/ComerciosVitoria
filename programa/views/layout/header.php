<!-- layout/header.php -->

<div id="header">
    <div id="header-logo-titulo">
    <a href="index.php"> 
        <img src="img/logo.png" id="logo" height="60" width="100">
            <h4 id="header-titulo">PURPOR</h4>
    </a>   
    </div>

    <form action="index.php?accion=buscar" method="post">
        <div class="header-buscador">
            <img src="img/lupa2.png" alt="Buscar" class="header-icono-buscar">
                <input type="text" name="nombre" class="header-input-buscar" placeholder="Buscar anuncios...">
        </div>
    </form>

    <div id="header-botones">
        <?php if(isset($_SESSION['id']) && !empty($_SESSION['id'])):
                if($_SESSION['tipo_usuario'] !== 'admin'):
        ?>
            <a href="index.php?controller=ComerciosController&accion=crear">
                <button class="btn-header">
                    <img src="img/publicar.png" alt="" width="20px" height="20px" class="img">
                    Publicar
                </button>
            </a>   
        <?php endif;?>
            
            <a href="index.php?controller=UsuariosController&accion=perfil">
                <button class="btn-header">
                    <img src="img/iniciarSesion.png" alt="" width="20px" height="20px" class="img"> 
                    Perfil
                </button>
            </a>  

            <button id="cerrar" class="btn-header">
                <img src="img/cerrarSesion.png" alt="" width="20px" height="20px" class="img"> 
            </button>

            <script>
                let cerrar = document.getElementById('cerrar');
                cerrar.addEventListener('click', cerrarSesion);
                console.log(btn)
                async function cerrarSesion(){       
                    const res = await fetch('index.php?controller=UsuariosController&accion=cerrarSesion');

                    const data = await res.json();

                    window.location.href = data.redirect ?? 'index.php';
                }
            </script>

        <?php else:?>
            <button id="openPopupInicio" class="btn-header">
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
            <button type="button" id="continuar-login" class="boton-login">Continuar</button>
        </form>
        <p>¿No tienes cuenta? <a id="openPopupRegistro">Regístrate</a></p>
    </div>
    <script>
    let btn = document.getElementById('continuar-login');
    btn.addEventListener('click', enviar);
    console.log(btn)
    async function enviar(){
        const user_name =  document.querySelector('input[name="user_name"]').value.trim();
        const password =  document.querySelector('input[name="password"]').value.trim();
        
        const res = await fetch('index.php?controller=UsuariosController&accion=verificarUsuario', {
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

<!-- Overlay para el popup de registro -->
<div id="overlay-registro">
    <div class="popup-registro">
        <button class="cerrar-registro" id="closePopupRegistro">✖</button>
        <h2>Registrarme</h2>
        <form id="form-registro">
            <input type="text" name="nombre" placeholder="Nombre" required />
            <input type="text" name="apellidos" placeholder="Apellidos" required />
            <input type="date" name="fecha_nacimiento" placeholder="Fecha de nacimiento" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="tel" name="telefono" placeholder="Teléfono (opcional)" />
            <input type="text" name="user_name" placeholder="Usuario" required />
            <input type="password" name="password" placeholder="Contraseña (mínimo 6 caracteres)" required />
            <input type="password" name="password_confirm" placeholder="Repite la contraseña" required />
            <button type="button" id="continuar-registro" class="boton-registro">Registrarme</button>
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

    // Funcionalidad de registro
    let btnRegistro = document.getElementById('continuar-registro');
    btnRegistro.addEventListener('click', registrarUsuario);

    async function registrarUsuario() {
        // Obtener valores del formulario específicamente del popup de registro
        const formRegistro = document.getElementById('overlay-registro');
        const nombre = formRegistro.querySelector('input[name="nombre"]').value.trim();
        const apellidos = formRegistro.querySelector('input[name="apellidos"]').value.trim();
        const fecha_nacimiento = formRegistro.querySelector('input[name="fecha_nacimiento"]').value;
        const email = formRegistro.querySelector('input[name="email"]').value.trim();
        const telefono = formRegistro.querySelector('input[name="telefono"]').value.trim();
        const user_name = formRegistro.querySelector('input[name="user_name"]').value.trim();
        const password = formRegistro.querySelector('input[name="password"]').value;
        const password_confirm = formRegistro.querySelector('input[name="password_confirm"]').value;

        // Debug: mostrar los valores en consola
        console.log('Datos del formulario:', {
            nombre, apellidos, fecha_nacimiento, email, telefono, user_name,
            password: password ? '***' : '', 
            password_confirm: password_confirm ? '***' : ''
        });
        
        // 1. Validar campos obligatorios
        if (!nombre || !apellidos || !fecha_nacimiento || !email || !user_name || !password || !password_confirm) {
            alert('Por favor, completa todos los campos obligatorios');
            return;
        }

        // 2. Validar nombre (mínimo 3 caracteres, máximo 50)
        if (nombre.length < 3) {
            alert('El nombre debe tener al menos 3 caracteres');
            return;
        }
        if (nombre.length > 50) {
            alert('El nombre no puede tener más de 50 caracteres');
            return;
        }

        // 3. Validar apellidos (mínimo 3 caracteres, máximo 100)
        if (apellidos.length < 3) {
            alert('Los apellidos deben tener al menos 3 caracteres');
            return;
        }
        if (apellidos.length > 100) {
            alert('Los apellidos no pueden tener más de 100 caracteres');
            return;
        }

        // 4. Validar fecha de nacimiento (debe ser mayor de 18 años)
        const fechaNacimiento = new Date(fecha_nacimiento);
        const hoy = new Date();
        const edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
        const mes = hoy.getMonth() - fechaNacimiento.getMonth();
        
        if (edad < 18 || (edad === 18 && mes < 0)) {
            alert('Debes ser mayor de 18 años para registrarte');
            return;
        }

        // 5. Validar formato de email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Por favor, introduce un email válido');
            return;
        }

        // 6. Validar teléfono si se proporciona
        if (telefono && telefono.length > 0) {
            const telefonoRegex = /^[0-9]{9,20}$/;
            if (!telefonoRegex.test(telefono.replace(/\s/g, ''))) {
                alert('Por favor, introduce un teléfono válido (solo números, 9-20 dígitos)');
                return;
            }
        }

        // 7. Validar usuario (mínimo 3 caracteres, máximo 30)
        if (user_name.length < 3) {
            alert('El nombre de usuario debe tener al menos 3 caracteres');
            return;
        }
        if (user_name.length > 30) {
            alert('El nombre de usuario no puede tener más de 30 caracteres');
            return;
        }

        // 8. Validar longitud de contraseña
        if (password.length < 6) {
            alert('La contraseña debe tener al menos 6 caracteres');
            return;
        }

        // 9. Validar que las contraseñas coincidan
        if (password !== password_confirm) {
            alert('Las contraseñas no coinciden');
            return;
        }

        try {
            const res = await fetch('index.php?controller=UsuariosController&accion=registrarUsuario', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    nombre: nombre,
                    apellidos: apellidos,
                    fecha_nacimiento: fecha_nacimiento,
                    email: email,
                    telefono: telefono || null,
                    user_name: user_name,
                    password: password
                })
            });

            const data = await res.json();
            
            if (!data.success) {
                alert(data.message);
                return;
            }

            alert('¡Registro exitoso! Ahora puedes iniciar sesión');
            
            // Limpiar formulario
            document.getElementById('form-registro').reset();
            
            // Cerrar popup de registro y abrir el de login
            document.getElementById('overlay-registro').style.display = 'none';
            document.getElementById('overlay-login').style.display = 'flex';

        } catch (error) {
            console.error('Error:', error);
            alert('Ocurrió un error al registrarse. Por favor, inténtalo de nuevo.');
        }
    }
</script>