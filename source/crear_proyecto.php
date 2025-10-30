<?php 
include("datos.php");

// Inicializar variables
$clave = '';
$titulo = '';
$descripcion = '';
$dinero = '';
$fecha = '';
$errorClave = '';
$errorTitulo = '';
$errorDescripcion = '';
$errorFecha = '';
$errorImagen = '';

// verificar los datos y si hay errores mostrar mensajes, si todo bien, guardar el nuevo proyecto
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $totalProductos = count($proyectos);
    $idProducto = $totalProductos + 1;

    // Sanizamos con trim
    $clave = trim($_POST["clave"]);
    $titulo = trim($_POST["titulo"]);
    $descripcion = trim($_POST["descripcion"]);
    $dinero = intval($_POST["dinero"]);
    $fecha = trim($_POST["fecha"]);

    // Validaciones
    if (empty($clave) || !array_key_exists($clave, $categorias)) {
        $errorClave = "Por favor, introduce una clave.";
    }

    if (empty($titulo)) {
        $errorTitulo = "Por favor, introduce un título correcto.";
    }

    if (empty($descripcion)) {
        $errorDescripcion = "Por favor, introduce una descripción correcta.";
    }

    if (empty($fecha) || !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $fecha)) {
        $errorFecha = "Por favor, introduce una fecha.";
    }

    // Validación de imagen con ayuda de Chatgpt
    $imagenRuta = '';
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === 0) {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!in_array($_FILES["imagen"]["type"], $allowedTypes)) {
            $errorImagen = "Solo se permiten imágenes JPG y PNG.";
        } else {
            $imagenNombre = basename($_FILES["imagen"]["name"]);
            $imagenRuta = "static/" . $imagenNombre;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $imagenRuta);
        }
    }

    // Si no hay errores, guardar proyecto
    if ($errorClave === '' && $errorTitulo === '' && $errorDescripcion === '' && $errorFecha === '' && $errorImagen === '') {
        $nuevo_proyecto = [
            "id" => $idProducto,
            "clave" => $clave,
            "titulo" => htmlspecialchars($titulo),
            "descripcion" => htmlspecialchars($descripcion),
            "imagen" => $imagenRuta,
            "dinero" => $dinero,
            "fecha" => htmlspecialchars($fecha)
        ];

        $proyectos[] = $nuevo_proyecto;

        file_put_contents("productos_total.json", json_encode($proyectos, JSON_PRETTY_PRINT));

        // Redirigir a página de confirmación
        header("Location: proyectoIndividual.php?id=$idProducto");
        exit();
    }
}

include("templates/header.php");
?>

<style>
.error {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
</style>

<div class="container mt-5">
    <h2>Crear Nuevo Producto</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <p>
                Claves Válidas:<br>
                <?php foreach ($categorias as $claveA => $valor) {
                    echo $claveA . '<br>';
                } ?>
            </p>
            <label for="clave" class="form-label">Clave</label>
            <input type="text" class="form-control" id="clave" name="clave">
            <?php if (!empty($errorClave)): ?>
                <div class="error"><?php echo htmlspecialchars($errorClave); ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" 
                value="<?php echo htmlspecialchars($titulo); ?>">
            <?php if (!empty($errorTitulo)): ?>
                <div class="error"><?php echo htmlspecialchars($errorTitulo); ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion"><?php echo htmlspecialchars($descripcion); ?></textarea>
            <?php if (!empty($errorDescripcion)): ?>
                <div class="error"><?php echo htmlspecialchars($errorDescripcion); ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
            <?php if (!empty($errorImagen)): ?>
                <div class="error"><?php echo htmlspecialchars($errorImagen); ?></div>
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <label for="dinero" class="form-label">Dinero (€)</label>
            <input type="number" class="form-control" id="dinero" name="dinero">
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha (DD/MM/YYYY)</label>
            <input type="text" class="form-control" id="fecha" name="fecha" 
                placeholder="DD/MM/YYYY">
            <?php if (!empty($errorFecha)): ?>
                <div class="error"><?php echo htmlspecialchars($errorFecha); ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Crear Producto</button>
        <a class="btn btn-danger" href="index.php">Cancelar</a>
    </form>
</div>

<?php include("templates/footer.php"); ?>