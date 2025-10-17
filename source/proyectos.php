<?php include("templates/header.php") ?>
<?php include("datos.php") ?>

<?php    
    // UD3.3.f Filtrado de proyectos por categoría
    $filtrar_por = isset($_GET["categoria"]) ? $_GET["categoria"] : "";
    
    // Si el filtro esta vacio o no existe la clave en el array que salga la alerta
    if ($filtrar_por === "" || !array_key_exists($filtrar_por, $categorias)) {
        echo "<div class='alert alert-danger' role='alert'>
                Categoría no válida.
            </div>";
        //$filtrar_por = $filtrar_por;
        //print($filtrar_por);
    }

    
    // UD3.3.f Usar array_filter para filtrar proyectos por categoría
    $proyectos_mostrar = array_filter($proyectos, function($proyecto) use ($filtrar_por) {
        return $proyecto['clave'] === $filtrar_por;
    });

?>

<div class="container">
    <div class="row">
        <?php foreach($proyectos_mostrar as $proyecto): ?>
            <?php $id = $proyecto['id']; ?>
            <div class="col-sm-3">
                <div class="card h-100">
                    <!-- UD3.2.d Operador ternario para imagen por defecto -->
                    <img class="card-img-top" src="<?php 
                        echo file_exists($proyecto['imagen']) ? $proyecto['imagen'] : 'static/notFound.jpg';
                    ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $proyecto['titulo']?></h5>
                        <p class="card-text"><?php echo $proyecto['descripcion']?></p>
                        <p class="card-text"><?php echo $proyecto['dinero']?>€</p>

                        <!-- UD3.3.c Listado de categorías del proyecto -->
                        <p class="card-text">
                            <?php
                                foreach($categorias as $clave => $valor) {
                                    if($proyecto['clave'] === $clave) {
                                        echo $valor;
                                    }
                                }
                            ?>
                        </p>
                        <a href="proyectoIndividual.php?id=<?= $id ?>" class="btn btn-primary">Ver más</a>
                    </div>
                    
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php include("templates/footer.php") ?>