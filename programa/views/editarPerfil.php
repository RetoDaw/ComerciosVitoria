
    /*FALTA AÑADIR EL CODIGO PHP PARA QUE FUNCIONE CORRECTAMENTEA*/
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/publicarAnuncio.css">
</head>
<body>
        <?php 
    require = '../views/layout/header.php'
    require = '../views/layout/footer.php'
    ?>
    <div id="contenedor">
        <div id="crearAnuncio">
            <div id="crearAnuncioFormulario" name="editarPerfil">
                <p>Editar Perfil</p>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="Juan">
                <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" value="Pérez">
                <input type="text" name="fecha_nac" id="fecha_nac" placeholder="DD/MM/YYYY" value="01/01/1990">
                <input type="text" name="telefono" id="telefono" placeholder="Teléfono" value="123456789">
                <input type="email" name="email" id="email" placeholder="Email" value="juan@example.com">
            </div>

            <div id="añadir-imagen">
                <label for="inputAñadirImagen" id="añadir">Añadir fotos</label>
                <input type="file" id="inputAñadirImagen" accept="image/*" multiple hidden>
                <button id="boton">+</button>
            </div>

            <div id="preview"></div>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button id="editar">Guardar cambios</button>
                <button id="desactivar">Desactivar cuenta</button>
                <button id="borrar">Borrar cuenta</button>
            </div>
        </div>

        <div id="imagen">
            <img src="../img/VITORIA-GASTEIZ.jpg" alt="">
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('inputAñadirImagen');
        const preview = document.getElementById('preview');
        const addIcon = document.getElementById('boton');

        // Imágenes iniciales del perfil
        let imagenes = ["../img/perfil1.jpg"];

        // Mostrar imágenes iniciales
        imagenes.forEach(src => {
            const img = document.createElement('img');
            img.src = src;
            img.classList.add('miniatura');
            img.title = "Haz clic para eliminar";
            img.addEventListener('click', () => {
                imagenes = imagenes.filter(i => i !== img.src);
                img.remove();
            });
            preview.appendChild(img);
        });

        // Subir nuevas imágenes
        addIcon.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', () => {
            const nuevosArchivos = Array.from(fileInput.files);

            nuevosArchivos.forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('miniatura');
                    img.title = "Haz clic para eliminar";

                    img.addEventListener('click', () => {
                        imagenes = imagenes.filter(i => i !== img.src);
                        img.remove();
                    });

                    imagenes.push(img.src);
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });

            fileInput.value = '';
        });

        document.getElementById('editar').addEventListener('click', () => {
            const perfilEditado = {
                nombre: document.getElementById('nombre').value,
                apellidos: document.getElementById('apellidos').value,
                fecha_nac: document.getElementById('fecha_nac').value,
                telefono: document.getElementById('telefono').value,
                email: document.getElementById('email').value,
                imagenes: imagenes
            };
            console.log("Perfil editado:", perfilEditado);
            alert("Perfil actualizado correctamente!");
            // AÑADIR codigo para guardar la edicion en la bbdd
        });

        document.getElementById('desactivar').addEventListener('click', () => {
            alert("Cuenta desactivada");
            // AÑADIR codigo para desactivar el perfil
        });

        document.getElementById('borrar').addEventListener('click', () => {
            alert("Cuenta borrada");
            // AÑADIR codigo para borrar el perfil
        });
    </script>
</body>
</html>
