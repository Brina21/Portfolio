<?php

    $listaUsuarios = json_decode(file_get_contents("usuarios.json"), true);

    $emailUsuario = $_COOKIE['user_email'];

    $usuarioActual = null;

    for ($i = 0; $i < count($listaUsuarios); $i++) {
        if ($listaUsuarios[$i]['user'] === $emailUsuario) {
            $usuarioActual = $listaUsuarios[$i];
            break;
        }
    }

    $nombre = $usuarioActual['nombre'] ?? '';
    $apellidos = $usuarioActual['apellidos'] ?? '';
    $dni = $usuarioActual['dni'] ?? '';
    $pass = $usuarioActual['pass'] ?? '';

    $errorNombre = '';
    $errorApellidos = '';
    $errorDni = '';
    $errorPass = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Saneamiento de variables
        $nombre = trim($_POST['nombre']);
        $apellidos = trim($_POST['apellidos']);
        $dni = trim($_POST['dni']);
        $pass = trim($_POST['password']);

        // Validaciones
        if (empty($nombre)) {
            $errorNombre = "Por favor, introduce un nombre válido.";
        }

        // Comprobar que hay al menos dos palabras en apellidos
        $partesApellidos = explode(" ", $apellidos);
        if (empty($apellidos) || count($partesApellidos) < 2) {
            $errorApellidos = "Introduce dos apellidos separados por espacio.";
        }

        if (empty($dni) || !preg_match("/^[0-9]{8}[A-Z]$/", $dni)) {
            $errorDni = "Por favor, introduce un DNI válido (8 números y 1 letra).";
        }

        if (empty($pass)) {
            $errorPass = "Por favor, introduce una contraseña válida.";
        }

        // Si no hay errores, actualizamos datos
        if ($errorNombre == '' && $errorApellidos == '' && $errorDni == '' && $errorPass == '') {
            for ($i = 0; $i < count($listaUsuarios); $i++) {
                if ($listaUsuarios[$i]['user'] === $emailUsuario) {
                    $listaUsuarios[$i]['nombre'] = $nombre;
                    $listaUsuarios[$i]['apellidos'] = $apellidos;
                    $listaUsuarios[$i]['dni'] = $dni;
                    $listaUsuarios[$i]['pass'] = $pass;
                    break;
                }
            }
            file_put_contents("usuarios.json", json_encode($listaUsuarios, JSON_PRETTY_PRINT));
            header("Location: index.php");
            exit();
        }
    }

    include("templates/header.php");
?>

<div class="contenedor">
    <form method="POST">
        <h2 class="form-title">Datos Usuario</h2>

        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="floatingInput" required 
            value="<?php echo $emailUsuario; ?>" readonly>
            <label for="floatingInput">Correo electrónico</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="nombre" class="form-control" id="Nombre" required
            value="<?php echo $nombre; ?>" >
            <label for="Nombre">Nombre</label>

            <?php if (!empty($errorNombre)): ?>
                <div class="error"><?php echo htmlspecialchars($errorNombre); ?></div>
            <?php endif; ?>
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="apellidos" class="form-control" id="floatApellidos" required
            value="<?php echo $apellidos; ?>">
            <label for="floatApellidos">Apellidos</label>

            <?php if (!empty($errorApellidos)): ?>
                <div class="error"><?php echo htmlspecialchars($errorApellidos); ?></div>
            <?php endif; ?>
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="dni" class="form-control" id="floatDni" required
            value="<?php echo $dni; ?>">
            <label for="floatDni">DNI</label>

            <?php if (!empty($errorDni)): ?>
                <div class="error"><?php echo htmlspecialchars($errorDni); ?></div>
            <?php endif; ?>
        </div>

        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" required
            value="<?php echo $pass; ?>">
            <label for="floatingPassword">Contraseña</label>
            
            <?php if ($errorPass): ?>
                <div class="error"><?php echo $errorPass; ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="index.php" class="btn btn-danger">Cancelar</a>
    </form>
</div>

<?php include("templates/footer.php"); ?>