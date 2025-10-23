<head>
    <style>
        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea, select {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
        }
    </style>
</head>

<h2>Crear Anuncio</h2>
<?php 
session_start();
$_SESSION['id'] = 4;
?>
<form action="index.php?controller=ComerciosController&accion=store" method="post" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <label for="id_categoria">Categoría:</label>
        <select id="id_categoria" name="id_categoria" >
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

        <button type="submit">Guardar Cambios</button>
    </form>
