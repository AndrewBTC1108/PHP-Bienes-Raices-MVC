<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar sesion</h1>

    <!-- con ayuda de un foreach nos mostrara la alerta del error -->
    <?php foreach($errores as $error):?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" novalidate>
        <fieldset>
            <legend>E-mail y Password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu E-mail" id="email">

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Tu Password" id="password">
        </fieldset>
        <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
    </form>
</main>