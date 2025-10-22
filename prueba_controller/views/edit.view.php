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

<h2>Editar Anuncio</h2>

<?php if (isset($anuncio) && $anuncio): ?>
<form action="index.php?controller=ComerciosController&accion=update" method="post" enctype="multipart/form-data">
        <input type="text" name="id" value="<?= htmlspecialchars($anuncio['id']) ?>">

        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($anuncio['titulo']) ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required><?= htmlspecialchars($anuncio['descripcion']) ?></textarea>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?= htmlspecialchars($anuncio['direccion']) ?>" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" value="<?= htmlspecialchars($anuncio['precio']) ?>" step="0.01" required>

        <label for="id_categoria">Categoría:</label>
        <select id="id_categoria" name="id_categoria" >
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>" <?= $categoria['id'] == $anuncio['id_categoria'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="1" <?= $anuncio['estado'] ? 'selected' : '' ?>>Activo</option>
            <option value="0" <?= !$anuncio['estado'] ? 'selected' : '' ?>>Inactivo</option>
        </select>

        <button type="submit">Guardar Cambios</button>
    </form>
<?php else: ?>
    <p>No se ha encontrado el anuncio para editar.</p>
<?php endif; ?>
