<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- CSS del header -->
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/registrarse.css">
    <link rel="stylesheet" href="css/iniciarSesion.css">

    <!-- CSS del footer -->
    <link rel="stylesheet" href="css/footerStyle.css">

    <!-- CSS de publicar anuncio -->
    <link rel="stylesheet" href="css/publicarAnuncio.css">
</head>
<body>
    <?php 
        require_once 'layout/header.php'; 
    ?>
    <div id="pubAnun-contenedor">
        <div id="pubAnun-crear">
            <form action="index.php?controller=ComerciosController&accion=store" method="post" enctype="multipart/form-data">
            <div id="pubAnun-formulario" name="crearAnuncio">
                <p>Crear anuncio</p>
                <input type="text" name="titulo" id="pubAnun-titulo" placeholder="Título" required>
                <input type="number" name="precio" id="pubAnun-precio" placeholder="Precio" required>   
                <input type="text" name="descripcion" id="pubAnun-descripcion" placeholder="Descripción" required>
                <input type="text" name="direccion" id="pubAnun-direccion" placeholder="Dirección" required>
            </div>

           <select id="pubAnun-categoria" name="id_categoria">
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

            <div id="pubAnun-añadirImagen">
                <label for="pubAnun-inputImg" id="pubAnun-labelAñadir">Añadir fotos</label>
                <input type="file" id="pubAnun-inputImg" name="imagenes[]" accept="image/*" multiple hidden>
                <button id="pubAnun-botonPlus" type="button">+</button>
            </div>

            <button id="pubAnun-botonCrear" type="submit">Crear</button>

            <div id="pubAnun-preview"></div>
            </form>
        </div>

        <div id="pubAnun-imagen">
            <img src="img/VITORIA-GASTEIZ.jpg" alt="">
        </div>
    </div>
    <?php 
        require_once 'layout/footer.php'; 
    ?>
    <script>
        const IMAGENES = [];
    </script>
   <script src="assets/imagenes.js"></script>
</body>
</html>