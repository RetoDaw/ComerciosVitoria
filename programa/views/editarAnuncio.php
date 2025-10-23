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
            <div id="crearAnuncioFormulario" name="editarAnuncio">
    <!--Llenar los valores con los datos del backend-->
                <p>Editar anuncio</p>
                <input type="text" name="title" id="titulo" placeholder="Título" value="">
                <input type="number" name="precio" id="precio" placeholder="Precio" value="">   
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción" value=" ">
                <input type="text" name="direccion" id="direccion" placeholder="Dirección" value="">
            </div>

            <select name="Categoria" id="categoria">
    <!--Llenar con php-->
            </select>

            <div id="añadir-imagen">
                <label for="inputAñadirImagen" id="añadir">Añadir fotos</label>
                <input type="file" id="inputAñadirImagen" accept="image/*" multiple hidden>
                <button id="boton">+</button>
            </div>

            <div style="display: flex; gap: 10px;">
                <button id="editar">Editar</button>
                <button id="desactivar">Desactivar</button>
                <button id="borrar">Borrar</button>
            </div>

            <div id="preview"></div>
        </div>

        <div id="imagen">
            <img src="../img/VITORIA-GASTEIZ.jpg" alt="">
        </div>
    </div>

    <script>
        
        const fileInput = document.getElementById('inputAñadirImagen');
        const preview = document.getElementById('preview');
        const addIcon = document.getElementById('boton');
            //Llenar imagenes desde la bbdd
        let imagenes = [

        ];

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

        // Botones
        document.getElementById('editar').addEventListener('click', () => {
            const anuncioEditado = {
                titulo: document.getElementById('titulo').value,
                precio: document.getElementById('precio').value,
                descripcion: document.getElementById('descripcion').value,
                direccion: document.getElementById('direccion').value,
                categoria: document.getElementById('categoria').value,
                imagenes: imagenes
            };
            console.log("Anuncio editado:", anuncioEditado);
            alert("Anuncio editado correctamente!");
            // añadir codigo para enviar al backend
        });

        document.getElementById('desactivar').addEventListener('click', () => {
            alert("Anuncio desactivado");
            // añadir codigo para enviar al backend
        });

        document.getElementById('borrar').addEventListener('click', () => {
            alert("Anuncio borrado");
            // añadir codigo para enviar al backend
        });
    </script>
</body>
</html>
