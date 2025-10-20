<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/publicarAnuncio.css">
</head>
<body>
    <div id="contenedor">
        <div id="crearAnuncio">
            <div id="crearAnuncioFormulario" name="crearAnuncio">
                <p>Crear anuncio</p>
                <input type="text" name="title" id="titulo" placeholder="Título">
                <input type="number" name="precio" id="precio" placeholder="Precio">   
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción">
                <input type="text" name="direccion" id="direccion" placeholder="Dirección">
            </div>

            <select name="Categoria" id="categoria">
            </select>

            <div id="añadir-imagen">
                <label for="inputAñadirImagen" id="añadir">Añadir fotos</label>
                <input type="file" id="inputAñadirImagen" accept="image/*" multiple hidden>
                <button id="boton">+</button>
            </div>

            <button id="crear">Crear</button>

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

        let imagenes = [];

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
                    img.src = e.target.result;
                    img.style.width = '120px';
                    img.style.height = '120px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    img.style.margin = '5px';
                    preview.appendChild(img);

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
    </script>
</body>
</html>
