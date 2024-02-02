<?php

    function conectarDB() : mysqli { //La sintaxis function nombre_funcion() : tipo_de_retorno { ... } indica que estamos definiendo una función llamada conectarDB(), que devuelve un objeto de tipo mysqli.
        $db = new mysqli(
            $_ENV['DB_HOST'], 
            $_ENV['DB_USER'], 
            $_ENV['DB_PASS'], 
            $_ENV['DB_BD']);

        if(!$db) {
            echo "Error no se pudo conectar";
            exit;
        }

        return $db; //retorna la instancia de la conexion
    }
