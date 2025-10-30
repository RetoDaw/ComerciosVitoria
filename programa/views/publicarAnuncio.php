<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- CSS del header -->
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/registrarse.css">
    <link rel="stylesheet" href="css/iniciarSesion.css">
      <link rel="icon" href="img/logo.png" type="image/x-icon">

    <!-- CSS del footer -->
    <link rel="stylesheet" href="css/footerStyle.css">

    <!-- CSS de publicar anuncio -->
    <link rel="stylesheet" href="css/publicarAnuncio.css">
</head>
<body>
    <?php 
        session_start();
        require_once 'layout/header.php';
    ?>
    <div id="contenedor">
        <div id="crearAnuncio">
            <form id="formAnuncio" action="index.php?controller=ComerciosController&accion=store" method="post" enctype="multipart/form-data">
            <div id="crearAnuncioFormulario" name="crearAnuncio">
                <p>Crear anuncio</p>
                    <!-- Título -->
                    <input type="text" name="titulo" id="titulo" placeholder="Título"
                        required maxlength="255"
                        pattern=".{2,255}"
                        title="El título debe tener entre 2 y 255 caracteres">

                    <!-- Precio -->
                    <input type="number" name="precio" id="precio" placeholder="Precio"
                        required min="0.01" step="0.01"
                        title="El precio debe ser mayor que 0">

                    <!-- Descripción -->
                    <input type="text" name="descripcion" id="descripcion" placeholder="Descripción"
                        required maxlength="500"
                        pattern=".{5,500}"
                        title="La descripción debe tener entre 5 y 500 caracteres">

                    <!-- Dirección -->
                    <input type="text" name="direccion" id="direccion" placeholder="Dirección"
                        required maxlength="255"
                        pattern=".{5,255}"
                        title="La dirección debe tener entre 5 y 255 caracteres">
            </div>

           <select id="id_categoria" name="id_categoria" id="categoria">
            <?php
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
            <img src="img/VITORIA-GASTEIZ.jpg" alt="">
        </div>
    </div>
    <script>
        const IMAGENES = [];
    </script>
   <script src="assets/imagenes.js"></script>
    <?php 
        require_once 'layout/footer.php';
    ?>
<script>
    document.getElementById("formAnuncio").addEventListener("submit", function(event) {
        const titulo = document.getElementById("titulo").value.trim();
        const descripcion = document.getElementById("descripcion").value.trim();
        const direccion = document.getElementById("direccion").value.trim();
        const precio = parseFloat(document.getElementById("precio").value);

        if(titulo.length < 2 || titulo.length > 255){
            alert("El título debe tener entre 2 y 255 caracteres.");
            event.preventDefault();
            return;
        }

        if(descripcion.length < 5 || descripcion.length > 500){
            alert("La descripción debe tener entre 5 y 500 caracteres.");
            event.preventDefault();
            return;
        }

        if(direccion.length < 5 || direccion.length > 255){
            alert("La dirección debe tener entre 5 y 255 caracteres.");
            event.preventDefault();
            return;
        }

        if(isNaN(precio) || precio <= 0){
            alert("El precio debe ser un número mayor que 0.");
            event.preventDefault();
            return;
        }
    });
</script>

</body>
</html>