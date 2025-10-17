<?php
// cierra la sesión y redirige a la página de inicio
    session_start();
    session_destroy();
    header('Location: index.php');
    exit;
?>
