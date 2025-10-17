<?php include("templates/header.php")?>
<?php include("datos.php")?>
<?php parseFecha(); ?>

<?php

    $idProducto = intval($_GET['id']);

    $productoIndv = null;
    foreach($proyectos as $producto) {
        //var_dump($producto);
        if($idProducto === $producto['id']) {
            $productoIndv = $producto;
            var_dump($productoIndv);
            break;
        }
    }
?>

<div class="d-flex align-items-center justify-content-center">
    <div class="card">
        <!-- UD3.2.d Operador ternario para imagen por defecto -->
        <img class="card-img-top" src="<?php 
            echo file_exists($productoIndv['imagen']) ? $productoIndv['imagen'] : 'static/notFound.jpg';
        ?>">
        <div class="card-body">
            <h5 class="card-title"><?php echo $productoIndv['titulo']?></h5>
            <p class="card-text"><?php echo $productoIndv['descripcion']?></p>
            <p class="card-text"><?php echo $productoIndv['dinero']?>€</p>
            <p class="card-text"><?php echo $productoIndv['fecha']; ?></p>

            <!-- UD3.3.c Listado de categorías del producto individual -->
            <p class="card-text">
                <?php
                    foreach($categorias as $clave => $valor) {
                        if($productoIndv['clave'] === $clave) {
                            echo $valor;
                        }
                    }
                ?>
            </p>
        </div>
        
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    <a class="btn btn-primary mx-2" href="index.php">Atrás</a>
</div>

<?php include("templates/footer.php") ?>