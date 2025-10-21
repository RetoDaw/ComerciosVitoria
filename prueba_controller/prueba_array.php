<?php
    // Array de productos
    $productos = [
        [
            "id" => 1,
            "titulo"  => "raton",
            "descripcion" => "raton inalambrico",
        ],
        [
            "id" => 2,
            "titulo"  => "teclado",
            "descripcion" => "teclado mecanico",
        ],
        [
            "id" => 3,
            "titulo"  => "monitor",
            "descripcion" => "monitor 4k",
        ],
        [
            "id" => 4,
            "titulo"  => "auriculares",
            "descripcion" => "auriculares bluetooth",
        ],
    ];

    //Foreach para recorrer el array de productos
    foreach($productos as $producto){
        echo "<h1>" . $producto["titulo"] . "</h1>";
        echo "<p>" . $producto["descripcion"] . "</p>";

    // Ruta de la carpeta de imágenes del producto
    $ruta = "imagenes/" . $producto["id"] . "/";

    // Buscar todas las imágenes dentro de esa carpeta
    $imagenes = glob($ruta . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

    // Mostrar las imágenes si existen
    if ($imagenes) {
        foreach ($imagenes as $img) {
            echo "<img src='$img'>";
        }
    } else {
        echo "<p><b>No hay imágenes disponibles.</b></p>";
    }

    echo "<hr>";
        
    }

?>