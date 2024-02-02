<fieldset>
    <legend>Informacion General</legend>

    <label for="titulo">Titulo</label>
    <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">

    <label for="precio">Precio</label>
    <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

    <label for="imagen">Imagen</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

    <?php if($propiedad->imagen): ?>
        <img src="/bienesRaicesPOO_PHP/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small">
    <?php endif; ?>

    <label for="descripcion">Descripcion</label>
    <textarea id="descripcion" name="descripcion"> <?php echo s($propiedad->descripcion); ?> </textarea>
</fieldset>

<fieldset>
    <legend>Infomracion Propiedad</legend>

    <label for="habitaciones">Habitaciones</label>
    <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">

    <label for="wc">Baños</label>
    <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

    <label for="estacionamiento">Estacionamiento</label>
    <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>

    <label for="vendedor">Vendedor</label>
    <select name="vendedores_id" id="vendedor">
        <option selected value="">-- Seleccione --</option>
        <?php  foreach($vendedores as $vendedor):?>
            <option <?php echo $propiedad->vendedores_id === $vendedor->id ? 'selected' : ''; ?>
            value = "<?php echo s($vendedor->id)?>"
            > <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido)?> </option>
        <?php endforeach;?>
    </select>
</fieldset>