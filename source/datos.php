<?php
    // UD4.2.e Comprobar si existe la cookie 'user_email' para determinar si el usuario está logeado
    $logedIn = isset($_COOKIE['user_email']) && $_COOKIE['user_email'] !== '';

    // UD3.3.a Array de categorías
    $categorias = [
        "motor" => "Motor",
        "suspension" => "Suspensión",
        "escape" => "Escape",
        "rueda" => "Ruedas",
        "interior" => "Interior",
        "exterior" => "Exterior",
        "iluminacion" => "Iluminación"
    ];

    // UD3.3.g Decodificar los archivos JSON y unirlos en un único array
    // si existe el archivo productos_total.json lo carga, 
    // si no, une los dos archivos productos1.json y productos2.json
    if (file_exists("productos_total.json")) {
        $proyectos = json_decode(file_get_contents("productos_total.json"), true);
    } else {
        $productos1 = json_decode(file_get_contents("productos1.json"), true);
        $productos2 = json_decode(file_get_contents("productos2.json"), true);
        $proyectos = array_merge($productos1, $productos2);
    }

    //echo var_dump($proyectos); // Imprime el array directamente

    // UD3.2.c Variable con mis datos que se mostraran en contacto.php
    $nombre = "Sabrina Bouragba";

    $imagenIndex = "static/my-melody.jpg";
?>