<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/publicarAnuncio.css">
</head>
<body>
    <div id="contenedor">
        <div id="crearAnuncio">
            <form action="index.php?controller=ComerciosController&accion=store" method="post" enctype="multipart/form-data">
            <div id="crearAnuncioFormulario" name="crearAnuncio">
                <p>Crear anuncio</p>
                <input type="text" name="titulo" id="titulo" placeholder="Título" required>
                <input type="number" name="precio" id="precio" placeholder="Precio" required>   
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción" required>
                <input type="text" name="direccion" id="direccion" placeholder="Dirección" required>
            </div>

           <select id="id_categoria" name="id_categoria" id="categoria">
            <?php
                session_start();
                $_SESSION['id'] = 4;
                require_once 'controllers/CategoriasController.php';
                $categoriasController = new CategoriasController;
                $categorias = $categoriasController->cogerCategorias();
                foreach ($categorias as $categoria): 
            ?>
                <option value="<?= $categoria['id'] ?>">
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

            <div id="añadir-imagen">
                <label for="inputAñadirImagen" id="añadir">Añadir fotos</label>
                <input type="file" id="inputAñadirImagen" name="imagenes[]" accept="image/*" multiple hidden>
                <button id="boton" type="button">+</button>
            </div>

            <button id="crear" type="submit">Crear</button>

            <div id="preview"></div>
            </form>
        </div>

        <div id="imagen">
            <img src="../img/VITORIA-GASTEIZ.jpg" alt="">
        </div>
    </div>

   <script>
        function addImage(){
            const nuevosArchivos = Array.from(fileInput.files);
            
            nuevosArchivos.forEach(file => {

                imagenes.push(file);

                //API para leer archivos
                const reader = new FileReader();

                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;

                    //Añadir estilos a las imagenes chiquitas
                    imgStyles(img);

                    img.addEventListener('click', () => {
                        const index = Array.from(preview.children).indexOf(img);
                        if (index > -1) {
                            imagenes.splice(index, 1);
                            img.remove();
                        }
                    });

                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });

            //Limpia el input para poder volver a seleccionar las mismas imágenes después
            fileInput.value = '';
        }

        function imgStyles(img){
            img.classList.add('miniatura');
            img.title = "Haz clic para eliminar";
            img.style.width = '120px';
            img.style.height = '120px';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '8px';
            img.style.margin = '5px';
        }

        const fileInput = document.getElementById('inputAñadirImagen');
        const preview = document.getElementById('preview');
        const addIcon = document.getElementById('boton');

        let imagenes = [];

        //Hacer que el boton '+' tenga la misma funcion que el input
        addIcon.addEventListener('click', () => fileInput.click());


        fileInput.addEventListener('change', () => addImage());

        //Reconstruir el array de imagenes antes de enviar la info

        document.querySelector('form').addEventListener('submit', (e) => {
            //Hacer que el input tenga solo los datos guardados
            const dataTransfer = new DataTransfer();
            imagenes.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;
        });
    </script>
</body>
</html>
