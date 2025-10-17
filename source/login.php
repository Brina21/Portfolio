<?php
    // Verifica si la sesión ya está iniciada; si no, la inicia
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include("datos.php");
    include("templates/header.php");

    // UD4.b: comprobar usuario y contraseña del json
    $usuarios = json_decode(file_get_contents("usuarios.json"), true);

    $emailInput = $_POST['email'] ?? '';
    $passInput = $_POST['password'] ?? '';

    $errorEmail = '';
    $errorPass = '';
    $loginOk = false;

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $usuarioComprobado = false;
        $passComprobado = false;

        foreach($usuarios as $usuario) {
            if($emailInput === $usuario['user']) {
                $usuarioComprobado = true;

                if($passInput === $usuario['pass']) {
                    $passComprobado = true;

                    // UD4.e: Almacenar cookie
                    $loginOk = true;
                    $_SESSION['user_email'] = $emailInput;
                }

                break;
            }
        }

        // UD4.d: Mensajes de error
        if(!$usuarioComprobado) {
            $errorEmail = "No existe el correo.";
        } elseif(!$passComprobado) {
            $errorPass = "Contraseña incorrecta.";
        }
    }
?>

<style>
    .contenedor {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 24px;
        background: #e9ecef;
    }

    form {
        background: #ffffff;
        padding: 28px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        width: 50%;
    }

    .form-title {
        margin-bottom: 18px;
        text-align: center;
        font-weight: 600;
        font-size: 1.25rem;
        color: #212529;
    }

    .form-control {
        font-size: 1rem;
        padding: .85rem .75rem;
    }

    button {
        width: 100%;
        padding: 12px;
        margin-top: 14px;
        border-radius: 6px;
    }

    .error {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<!-- UD4.c: Redirección tras login exitoso -->
<?php if($loginOk): ?>
    <script>
        // redirigir a la página de Administración con JS
        window.location.href = 'contacto_lista.php';
    </script>
<?php endif; ?>

<!-- UD4.a: Formulario de Login -->
<div class="contenedor">
    <form method="post">
        <h2 class="form-title">Iniciar sesión</h2>

        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required 
            value="<?php echo htmlspecialchars($emailInput); ?>"> <!-- UD4.d: Con value no se pierde el contenido -->
            <label for="floatingInput">Correo electrónico</label>

            <?php if ($errorEmail): ?>
                <div class="error"><?php echo $errorEmail; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Contraseña" required 
            value="<?php echo htmlspecialchars($passInput); ?>"> <!-- UD4.d: Con value no se pierde el contenido -->
            <label for="floatingPassword">Contraseña</label>
            
            <?php if ($errorPass): ?>
                <div class="error"><?php echo $errorPass; ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<?php include("templates/footer.php") ?>