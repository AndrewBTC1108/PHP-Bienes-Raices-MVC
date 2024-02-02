<main class="contenedor">
    <h1>Registrar Vendedor@</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <!-- con ayuda de un foreach nos mostrara la alerta -->
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

                                                                                    
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <!-- llamamos el template -->
        <?php include 'formulario.php';?>
        <input type="submit" value="Actualizar Vendedor" class="boton boton-verde">
    </form>
</main>