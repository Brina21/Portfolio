<?php
    // UD4.1.c - Protección del área de administración
    // Si no existe la cookie o está vacía, redirigimos al formulario de login.
    if (!isset($_COOKIE['user_email']) || $_COOKIE['user_email'] === '') {
        // Redirigir al formulario de login
        header('Location: login.php');
        exit;
    }

    include('templates/header.php');
?>

<div class="container mt-5">
    <h2>Área de Administración</h2>
    <p>Bienvenido, <?php echo $_COOKIE['user_email']; ?>.</p>
    
    <a href="index.php" class="btn btn-primary">Inicio</a>
</div>

<?php include('templates/footer.php'); ?>
