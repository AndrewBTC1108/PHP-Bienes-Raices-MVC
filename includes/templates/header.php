<?php

    //si no existe o no esta definida
    if (!isset($_SESSION)) {
        //debemos arrancar la sesion para poder acceder a la super global $_SESSION
        session_start();
    }

    //si no exitse va a colocar bool(false)
    $auth = $_SESSION['login'] ?? false;
    // var_dump($_SESSION);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/bienesRaicesPOO_PHP/build/css/app.css">
</head>

<body>

    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="../../../bienesRaicesPOO_PHP/index.php"> <!--Para referir a la pag principal-->
                    <img src="/bienesRaicesPOO_PHP/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="/bienesRaicesPOO_PHP/build/img/barras.svg" alt="Icono menu responsive">
                </div>

                <div class="derecha">
                    <img src="/bienesRaicesPOO_PHP/build/img/dark-mode.svg" class="dark-mode-boton">
                    <nav class="navegacion">
                        <a href="../../../bienesRaicesPOO_PHP/nosotros.php">Nosotros</a>
                        <a href="../../../bienesRaicesPOO_PHP/anuncios.php">Anuncios</a>
                        <a href="../../../bienesRaicesPOO_PHP/blog.php">Blog</a>
                        <a href="../../../bienesRaicesPOO_PHP/contacto.php">Contacto</a>
                        <!-- si $auth es false no va a mostrar Cerrar sesion -->
                        <?php if ($auth): ?>
                            <a href="../../../bienesRaicesPOO_PHP/cerrar-sesion.php">Cerrar Sesion</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div> <!--barra-->
            <!-- operador ternario -->
            <?php echo $inicio ? "<h1> Venta de casas y departamentos exclusivos de lujo </h1>" : ''; ?>
        </div>
    </header>