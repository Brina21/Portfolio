<?php
    // Verifica si la sesión ya está iniciada; si no, la inicia
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>


<!DOCTYPE html>
<html>
<head>
    <title>Portfolio de proyectos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/flatly/bootstrap.min.css" integrity="sha384-qF/QmIAj5ZaYFAeQcrQ6bfVMAh4zZlrGwTPY7T/M+iTTLJqJBJjwwnsE5Y0mV7QK" crossorigin="anonymous">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include("datos.php") ?>
    <?php include("utiles.php") ?>

</head>
<!-- https://radu.link/make-footer-stay-bottom-page-bootstrap/ -->
<body class="d-flex flex-column min-vh-100">

    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            <span class="fs-4">Portfolio Sabrina <?php echo addFecha(); ?></span>
        </a>

        <!-- UD3.2.a Modificado enlace para que me lleve al fichero Inicio y se marque siempre que este en inicio -->
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="index.php"
                    <?php if($_SERVER['SCRIPT_NAME'] == "/index.php") { ?>
                        class="nav-link active"
                    <?php } else { ?>
                        class="nav-link"
                    <?php } ?>
                    >INICIO
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="proyectos.php"
                    <?php 
                    $isProyectos = $_SERVER['SCRIPT_NAME'] == "/proyectos.php" || $_SERVER['SCRIPT_NAME'] == "/proyectos.php";
                    if($isProyectos) { ?>
                        class="nav-link dropdown-toggle active"
                    <?php } else { ?>
                        class="nav-link dropdown-toggle"
                    <?php } ?>
                    id="dropdownMenu1" data-bs-toggle="dropdown" aria-expanded="false">
                    CATEGORÍAS
                </a>
                <!-- UD3.3.e y UD3.4.b Dropdown de categorías generado con bucle foreach -->
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <?php foreach($categorias as $clave => $nombre) { ?>
                        <li><a class="dropdown-item" href="proyectos.php?categoria=<?php echo $clave; ?>"><?php echo $nombre; ?></a></li>
                    <?php } ?>
                </ul>
            </li>

            <!-- UD3.2.b Modificado enlace para que me lleve al fichero Contacto y se marque siempre que este en contacto -->
            <li class="nav-item">
                <a href="contacto.php"
                    <?php if($_SERVER['SCRIPT_NAME'] == "/contacto.php") { ?>
                            class="nav-link active"
                        <?php } else { ?>
                            class="nav-link"
                        <?php } ?>
                >CONTACTO</a>
            </li>

            <!-- UD4.a: Control de menú según autenticación -->
            <!-- UD4.c: en funcion de la cookie se muestra u oculta el apartado de administración -->
            <?php if($logedIn) { ?>
                <li class="nav-item">
                    <a href="contacto_lista.php" class="nav-link">ADMINISTRACIÓN</a>
                </li>
                
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">LOG OUT</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a href="login.php" class="nav-link">LOG IN</a>
                </li>
            <?php } ?>

        </ul>
    </header> 