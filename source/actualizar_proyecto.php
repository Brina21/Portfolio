<?php
    include("datos.php");

    $idProducto = intval($_GET['id']);
    $datos_producto = '';

    foreach ($proyectos as $producto) {
        
        if ($producto['id'] === $idProducto) {
            //var_dump($producto);
            $datos_producto = $producto;
        }
    }

    $errorClave = $errorTitulo = $errorDescripcion = $errorFecha = $errorImagen = '';
    $clave = $datos_producto['clave'];
    $titulo = $datos_producto['titulo'];
    $descripcion = $datos_producto['descripcion'];
    $dinero = $datos_producto['dinero'];
    $fecha = $datos_producto['fecha'];
    $imagenRuta = $datos_producto['imagen']; // ruta actual
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Sanitizar datos
        $clave = trim($_POST['clave']);
        $titulo = trim($_POST['titulo']);
        $descripcion = trim($_POST['descripcion']);
        $dinero = intval($_POST['dinero']);
        $fecha = trim($_POST['fecha']);

        /// Validaciones
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

        // Si no hay errores, actualizar datos
        if ($errorClave=='' && $errorTitulo=='' && $errorDescripcion=='' && $errorFecha=='' && $errorImagen=='') {
            for ($i = 0; $i < count($proyectos); $i++) {
                if ($proyectos[$i]['id'] == $idProducto) {
                    $proyectos[$i]['clave'] = $clave;
                    $proyectos[$i]['titulo'] = htmlspecialchars($titulo);
                    $proyectos[$i]['descripcion'] = htmlspecialchars($descripcion);
                    $proyectos[$i]['dinero'] = $dinero;
                    $proyectos[$i]['fecha'] = htmlspecialchars($fecha);
                    if ($imagenRuta != '') {
                        $proyectos[$i]['imagen'] = $imagenRuta;
                    }
                    break;
                }
            }

            file_put_contents("productos_total.json", json_encode($proyectos, JSON_PRETTY_PRINT));
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
    <h2>Actualizar Producto</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <p>
                Claves Válidas:<br>
                <?php foreach ($categorias as $claveA => $valor) {
                    echo $claveA . '<br>';
                } ?>
            </p>
            <label for="clave" class="form-label">Clave</label>
            <input type="text" class="form-control" id="clave" name="clave"
                value="<?php echo $datos_producto['clave']; ?>">
            <?php if (!empty($errorClave)): ?>
                <div class="error"><?php echo htmlspecialchars($errorClave); ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $datos_producto['titulo']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo $datos_producto['descripcion']; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="dinero" class="form-label">Dinero (€)</label>
            <input type="number" class="form-control" id="dinero" name="dinero" value="<?php echo $datos_producto['dinero']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
            <?php if (!empty($errorImagen)): ?>
                <div class="error"><?php echo htmlspecialchars($errorImagen); ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha (DD/MM/YYYY)</label>
            <input type="text" class="form-control" id="fecha" name="fecha" 
                placeholder="<?php echo $datos_producto['fecha']; ?>">
            <?php if (!empty($errorFecha)): ?>
                <div class="error"><?php echo htmlspecialchars($errorFecha); ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
        <a type="button" class="btn btn-danger" href="index.php">Cancelar</a>
    </form>
</div>

<?php include("templates/footer.php") ?>