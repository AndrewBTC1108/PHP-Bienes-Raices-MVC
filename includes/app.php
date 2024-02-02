<?php

    use Dotenv\Dotenv;
    require __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
    require 'funciones.php';
    require 'config/database.php';

    //Conectamos a la base de datos
    $db = conectarDB();

    use Model\ActiveRecord;
    ActiveRecord::setDB($db)
?>