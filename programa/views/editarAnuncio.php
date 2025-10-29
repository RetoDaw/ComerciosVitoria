<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/publicarAnuncio.css">
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- CSS del header -->
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/registrarse.css">
    <link rel="stylesheet" href="css/iniciarSesion.css">

    <!-- CSS del footer -->
    <link rel="stylesheet" href="css/footerStyle.css">

    <!-- CSS de publicar anuncio -->
    <link rel="stylesheet" href="css/editarAnuncio.css">
</head>

<body>
    <?php 
        session_start();
        require_once 'layout/header.php';
    ?>
    <div id="contenedor">
        <div id="crearAnuncio">
            <form action="index.php?accion=update" method="post" enctype="multipart/form-data">
                <div id="crearAnuncioFormulario" name="editarAnuncio">
                    <p>Editar anuncio</p>

                    <!-- ID -->
                    <input type="text" name="id" id="id" hidden 
                    value="<?= htmlspecialchars($anuncio['id']) ?>" required>

                    <!-- Título -->
                    <input type="text" name="titulo" id="titulo" placeholder="Título"
                        value="<?= htmlspecialchars($anuncio['titulo']) ?>"
                        required maxlength="255"
                        pattern=".{2,255}"
                        title="El título debe tener entre 2 y 255 caracteres">

                    <!-- Precio -->
                    <input type="number" name="precio" id="precio" placeholder="Precio"
                        value="<?= htmlspecialchars($anuncio['precio']) ?>"
                        required min="0.01" step="0.01"
                        title="El precio debe ser mayor que 0">

                    <!-- Descripción -->
                    <input type="text" name="descripcion" id="descripcion" placeholder="Descripción"
                        value="<?= htmlspecialchars($anuncio['descripcion']) ?>"
                        required maxlength="500"
                        pattern=".{5,500}"
                        title="La descripción debe tener entre 5 y 500 caracteres">

                    <!-- Dirección -->
                    <input type="text" name="direccion" id="direccion" placeholder="Dirección"
                        value="<?= htmlspecialchars($anuncio['direccion']) ?>"
                        required maxlength="255"
                        pattern=".{5,255}"
                        title="La dirección debe tener entre 5 y 255 caracteres">

                </div>

                <label for="categoria">Categoría:</label>
                <select name="categoria" id="categoria">
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id'] ?>" <?= $categoria['id'] == $anuncio['id_categoria'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categoria['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div id="añadir-imagen">
                    <label for="inputAñadirImagen" id="añadir">Añadir fotos</label>
                    <input type="file" id="inputAñadirImagen" name="imagenes[]" accept="image/*" multiple hidden>
                    <button id="boton" type="button">+</button>
                </div>

                <div id="preview"></div>
                <div style="display: flex; gap: 10px;">
                    <button id="editar" type="submit">Editar</button>
            </form>
            <?php if ($anuncio['estado'] == 1): ?>
                <button id="desactivar" type="button" value="desactivar">Desactivar</button>
            <?php else: ?>
                <button id="desactivar" type="button" value="reactivar">Reactivar</button>
            <?php endif; ?>
            <form action="index.php?accion=destroy" method="post" enctype="multipart/form-data">
                <input type="text" name="id" id="id" hidden value="<?= htmlspecialchars($anuncio['id']) ?>" required>
                <button id="editar" type="submit">Borrar</button>
            </form>
        </div>
    </div>

    <div id="imagen">
        <img src="img/VITORIA-GASTEIZ.jpg" alt="">
    </div>
    </div>
    <script>
        const IMAGENES = <?= json_encode($imagenes) ?>
    </script>
    <script>
        const ADD_ID = <?= $anuncio['id'] ?>;
    </script>
    <script src="assets/imagenes.js"></script>
     <!--
    defer hace que no se ejecute hasta que se utilice
     -->
    <script src="assets/desactivar.js" defer></script>

    <?php 
        require_once 'layout/footer.php';
    ?>
<script>
    document.querySelector('form[action*="update"]').addEventListener("submit", function(event) {
        const titulo = document.getElementById("titulo").value.trim();
        const descripcion = document.getElementById("descripcion").value.trim();
        const direccion = document.getElementById("direccion").value.trim();
        const precio = parseFloat(document.getElementById("precio").value);

        if (titulo.length < 2 || titulo.length > 255) {
            alert("El título debe tener entre 2 y 255 caracteres.");
            event.preventDefault();
            return;
        }

        if (descripcion.length < 5 || descripcion.length > 500) {
            alert("La descripción debe tener entre 5 y 500 caracteres.");
            event.preventDefault();
            return;
        }

        if (direccion.length < 5 || direccion.length > 255) {
            alert("La dirección debe tener entre 5 y 255 caracteres.");
            event.preventDefault();
            return;
        }

        if (isNaN(precio) || precio <= 0) {
            alert("El precio debe ser un número mayor que 0.");
            event.preventDefault();
            return;
        }
    });
</script>


</body>

</html>