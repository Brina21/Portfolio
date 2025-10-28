<?php include("templates/header.php") ?>
<?php include_once("datos.php") ?>
<?php include_once("utiles.php") ?>

<?php
    // Cargar los datos combinados
    $productos = $proyectos ?? [];

    // Eliminar último y guardar en JSON
    if (isset($_GET["delete"]) && $_GET["delete"] === "true") {
        // Eliminar el último elemento del array
        array_pop($productos);
        // Guardar el array actualizado en productos_total.json
        file_put_contents("productos_total.json", json_encode($productos));
    }

    // Ordenar ascendente o descendente
    $ordenar = isset($_GET["orden"]) ? $_GET["orden"] : null;
    if ($ordenar === "asc") {
        usort($productos, function($a, $b) {
            return $a['titulo'] <=> $b['titulo'];
        });
    } elseif ($ordenar === "desc") {
        usort($productos, function($a, $b) {
            return $b['titulo'] <=> $a['titulo'];
        });
    }

    // Paginación
    $maxProyectos = 4;
    $paginaActual = isset($_GET["pagina"]) ? (int)$_GET["pagina"] : 1;
    $inicio = ($paginaActual - 1) * $maxProyectos;
    $totalProyectos = count($productos);
    $totalPaginas = ceil($totalProyectos / $maxProyectos);
    $proyectos_mostrar = array_slice($productos, $inicio, $maxProyectos);
?>

<!-- Botones de ordenación y eliminación -->
<div class="d-flex justify-content-center mt-5 mb-5">
    <a class="btn btn-primary btn-lg mx-2" href="index.php?orden=asc" role="button">Ordenar Ascendente</a>
    <a class="btn btn-primary btn-lg mx-2" href="index.php?orden=desc" role="button">Ordenar Descendente</a>
    <a class="btn btn-danger btn-lg mx-2" href="?delete=true" role="button">Eliminar último elemento</a>
    <a class="btn btn-primary btn-lg mx-2" href="crear_proyecto.php" role="button">Crear Proyecto</a>

</div>

<!-- Contenedor de proyectos -->
<div class="container">
    <div class="row">
        <?php foreach($proyectos_mostrar as $proyecto): ?>
            <?php $id = $proyecto['id'] ?? null; ?>
            <div class="col-sm-3">
                <div class="card h-100">
                    <img class="card-img-top" src="<?php 
                        echo file_exists($proyecto['imagen']) ? $proyecto['imagen'] : 'static/notFound.jpg';
                    ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $proyecto['titulo']?></h5>
                        <p class="card-text"><?php echo $proyecto['descripcion']?></p>
                        <p class="card-text"><?php echo $proyecto['dinero']?>€</p>
                        <p class="card-text">
                            <?php
                                foreach($categorias as $clave => $valor) {
                                    if($proyecto['clave'] === $valor || $proyecto['clave'] === $clave) {
                                        echo $valor;
                                    }
                                }
                            ?>
                        </p>
                        <?php if ($id): ?>
                            <a href="proyectoIndividual.php?id=<?= $id ?>" class="btn btn-primary">Ver más</a>
                        <?php endif; ?>
                        <?php if ($logedIn): ?>
                            <a href="actualizar_proyecto.php?id=<?= $id ?>" class="btn btn-primary">Actualizar</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Navegación -->
<div class="d-flex justify-content-center mt-4">
    <?php if ($paginaActual > 1): ?>
        <a class="btn btn-primary mx-2" href="index.php?pagina=<?php echo $paginaActual - 1; ?><?php echo isset($_GET['orden']) ? '&orden=' . $_GET['orden'] : ''; ?>">Atrás</a>
    <?php else: ?>
        <button class="btn btn-primary mx-2" disabled>Atrás</button>
    <?php endif; ?>

    <?php if ($paginaActual < $totalPaginas): ?>
        <a class="btn btn-primary mx-2" href="index.php?pagina=<?php echo $paginaActual + 1; ?><?php echo isset($_GET['orden']) ? '&orden=' . $_GET['orden'] : ''; ?>">Siguiente</a>
    <?php endif; ?>
</div>

<?php include("templates/footer.php") ?>