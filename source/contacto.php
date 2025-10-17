<?php include("templates/header.php"); ?>
<?php include("datos.php"); ?>

<?php 
    $x = isset($_GET["x"]) ? (int)$_GET["x"] : 1;
?>


<div class="container">
    <h2 class="mb-5">Contacto</h2>
    <div class="row">
        <div class="col-md">
            <img src="static/my-melody.jpg" class="img-fluid rounded">
        </div>
        <div class="col-md">
            <!-- UD3.2.c Mostrar nombre y apellidos desde variable en datos.php -->
            <h3><?php echo $nombre; ?></h3>
            <p>Ciclo Superior DAW.</p>
            <p>Apasionado del mundo de la programación en general, y de las tecnologías web en particular.</p>
            <p>Si tienes cualquier tipo de pregunta, contacta conmigo por favor.</p>
            <p>Teléfono: 87654321</p>
        </div>
    </div>
</div>

<?php include("templates/footer.php"); ?>