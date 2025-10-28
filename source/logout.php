<?php
    // cierra la sesión y redirige a la página de inicio
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Vaciar todas las variables de sesión
    $_SESSION = array();

    // Esto eliminará la sesión del servidor
    session_destroy();

    // Eliminar la cookie estableciéndola con una fecha de expiración pasada,
    //  en este caso hace una hora
    setcookie('user_email', '', time() - 3600, "/");

    header('Location: index.php');
    exit;
?>
