<fieldset>
    <legend>Informacion General</legend>

    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" placeholder="Nombre Vendedor@" value="<?php echo s($vendedor->nombre); ?>">

    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="apellido" placeholder="Apellido Vendedor@" value="<?php echo s($vendedor->apellido); ?>">

    <label for="imagen">Imagen</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

    <?php if($vendedor->imagen): ?>
        <img src="/imagenes/<?php echo $vendedor->imagen ?>" class="imagen-small">
    <?php endif; ?>

</fieldset>

<fieldset>
    <legend>Informacion Extra</legend>

    <label for="telefono">Telefono</label>
    <input type="text" id="telefono" name="telefono" placeholder="Telefono Vendedor@" value="<?php echo s($vendedor->telefono); ?>">

</fieldset>