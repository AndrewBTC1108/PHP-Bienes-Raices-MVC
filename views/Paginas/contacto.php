<main class="contenedor">
    
    <?php if ($mensaje) { ?>
        <p class="alerta exito"><?php echo $mensaje; ?></p>;
    <?php } ?>
    
    <h1>Contacto</h1>
    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen Contacto">
    </picture>

    <h2>Llene el formulario de Contacto</h2>

    <form class="formulario" action="/contacto" method="POST">
        <!--Grupo de campos-->
        <fieldset>
            <legend>Informacion Personal</legend>

            <label for="nombre">Nombre</label>
            <input type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]" required>

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="contacto[mensaje]" required></textarea>
        </fieldset>

        <fieldset>
            <legend>Informacion sobre la propiedad</legend>
            <label for="opciones">Vende o Compra</label>
            <select id="opciones" name="contacto[tipo]" required>
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="compra">Compra</option>
                <option value="vende">vende</option>
            </select>

            <label for="presupuesto">Precio o Presupuesto</label>
            <input type="number" placeholder="Tu Precio o Presupuesto" id="presupuesto" name="contacto[precio]" required>
        </fieldset>

        <fieldset>
            <legend>Contacto</legend>

            <p>como desea ser contactado</p>

            <div class="forma-contacto">
                <label for="contactar-telefono">Telefono</label>
                <!-- value define el campo elegido -->
                <input type="radio" value="telefono" id="contactar-telefono" name="contacto[contacto]" required>

                <label for="contactar-email">E-mail</label>
                <input type="radio" value="email" id="contactar-emial" name="contacto[contacto]" required>
            </div>

            <div id="contacto"></div>
        </fieldset>

        <input type="submit" value="Enviar" class="boton-verde">
    </form>
</main>