<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
      <link rel="icon" href="../img/logo.png" type="image/x-icon">

    <!-- CSS del header -->
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/registrarse.css">
    <link rel="stylesheet" href="css/iniciarSesion.css">

    <!-- CSS del footer -->
    <link rel="stylesheet" href="css/footerStyle.css">

    <!-- CSS del formulario de anuncio/edición -->
    <link rel="stylesheet" href="css/editarPerfil.css">
</head>
<body>
    <?php require_once 'layout/header.php'; ?>
    <div id="anuncio-contenedor">
        <div id="anuncio-formulario-wrapper">
            <div id="anuncio-formulario" name="editarPerfil">
                <p class="anuncio-titulo">Editar Perfil</p>
               <form id="formEditar" action="index.php?controller=UsuariosController&accion=update" method="post">
                    <!-- Nombre -->
                    <input type="text" name="nombre" id="nombre" class="anuncio-input"
                        placeholder="Nombre"
                        value="<?= $usuario['nombre']?>"
                        required maxlength="255"
                        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,255}"
                        title="Solo letras y espacios, mínimo 2 y máximo 255 caracteres">

                    <!-- Apellidos -->
                    <input type="text" name="apellidos" id="apellidos" class="anuncio-input"
                        placeholder="Apellidos"
                        value="<?= $usuario['apellidos']?>"
                        required maxlength="255"
                        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,255}"
                        title="Solo letras y espacios, mínimo 2 y máximo 255 caracteres">

                    <!-- Fecha de nacimiento -->
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="anuncio-input"
                        value="<?= $usuario['fecha_nacimiento']?>"
                        required
                        max="<?= date('Y-m-d') ?>"
                        title="Debe ser una fecha válida y no en el futuro">

                    <!-- Teléfono -->
                    <input type="text" name="telefono" id="telefono" class="anuncio-input"
                        placeholder="Teléfono"
                        value="<?= $usuario['telefono']?>"
                        required
                        maxlength="12"
                        title="Debe ser un teléfono español válido de 9 dígitos. Puedes poner espacios entre los números.">

                    <!-- Email -->
                    <input type="email" name="email" id="email" class="anuncio-input"
                        placeholder="Email"
                        value="<?= $usuario['email']?>"
                        required
                        maxlength="255"
                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                        title="Formato válido: texto@texto.com">

                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="btn-anuncio">Editar</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="anuncio-imagen-wrapper">
            <img src="../img/VITORIA-GASTEIZ.jpg" alt="">
        </div>
    </div>
    <?php require_once 'layout/footer.php'; ?>
<script>
    document.getElementById("formEditar").addEventListener("submit", function(event) {
        // --- Teléfono ---
        let tel = document.getElementById("telefono").value;
        tel = tel.replace(/\s+/g, ''); // quitar espacios

        const telefonoValido = /^[6789]\d{8}$/.test(tel);
        if(!telefonoValido){
            alert("El teléfono no es válido. Debe tener 9 dígitos, empezar por 6,7,8 o 9 y puedes poner espacios.");
            event.preventDefault();
            return;
        }

        document.getElementById("telefono").value = tel; // enviar limpio

        // --- Fecha ---
        const fecha = document.getElementById("fecha_nacimiento").value;
        const hoy = new Date().toISOString().split("T")[0];
        if(fecha > hoy){
            alert("La fecha de nacimiento no puede ser futura.");
            event.preventDefault();
            return;
        }

        // --- Email ---
        const email = document.getElementById("email").value;
        const emailRegex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;
        if(!emailRegex.test(email)){
            alert("El email no es válido. Debe tener el formato email@gmail.com");
            event.preventDefault();
            return;
        }
    });
</script>

</body>
</html>