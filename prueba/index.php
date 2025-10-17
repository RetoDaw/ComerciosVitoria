<form action="index.php" method="POST" enctype="multipart/form-data">

    <input type="file" name="imagenes[]" accept="image/png, image/jpeg, image/jpg">
    <input type="file" name="imagenes[]" accept="image/png, image/jpeg, image/jpg">
    <!--
    <input type="date" name="fecha_nacimiento">
        -->
    <input type="submit">
</form>
<?php
require_once __DIR__ . '/CategoriasModel.php';
require_once __DIR__ . '/ComerciosModel.php';
require_once __DIR__ . '/ImagenesModel.php';
require_once __DIR__ . '/UsuariosModel.php';

/*
CategoriasModel::create("electronica");
var_dump(CategoriasModel::getIdByName("electronica"));
var_dump(CategoriasModel::getById(15));
CategoriasModel::deleteById(15);


foreach(CategoriasModel::getAll() as $categoria){
    var_dump($categoria);
}
*/
/*
ComerciosModel::create([
    "Iphone 14 nuevo",
    "VJ jhkdBJKKHEBFJE;YJGHVJDKUYAHSd",
    "C\ nvbhsgdiu ba ",
    950,
    4,
    13
]);

ComerciosModel::deleteById(11);


ComerciosModel::edit([
    12,
    "Iphone 14 usado",
    "VJ jhkdBJKKHEBFJE;YJGHVJDKUYAHSd",
    "C\ nvbhsgdiu ba ",
    950,
    13
]);

foreach(ComerciosModel::getAll() as $anuncio){
    var_dump($anuncio);
}
*/
/*
UsuariosModel::create([
    "manolito",
    "manolo",
    "manolero pepo",
    "manolo@manolito.com",
    "AguguGaga",
    $_POST['fecha_nacimiento'],
    675879809
]);
UsuariosModel::edit([
    7,
    "manolo",
    "manolero",
    "manolo@manolito.com",
    $_POST['fecha_nacimiento'],
    999999999
]);
UsuariosModel::deleteById(7);

var_dump(UsuariosModel::getById(6));
var_dump(UsuariosModel::getIdByUsername("jorge"));
foreach(UsuariosModel::getAll() as $usuario){
    var_dump($usuario);
}
*/
/*
$dbh = Database::getConnection();

if (!empty($_FILES['imagenes'])){
    echo "hay imagen";
    ImagenesModel::create($dbh,$_FILES['imagenes'],1);
}
*/
/*
ImagenesModel::deleteById(17);

ImagenesModel::edit(1,$_FILES['imagenes'],[
    "imagen1" => [
        "id" => 18
    ]
]);
foreach(ImagenesModel::getAll("1") as $imagen){
    var_dump($imagen);
}
*/