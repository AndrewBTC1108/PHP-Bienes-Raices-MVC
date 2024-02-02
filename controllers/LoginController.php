<?php

namespace Controllers;

use MVC\Router;
use Model\Admin;

class LoginController
{
    public static function login(Router $router)
    {

        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);

            $errores = $auth->validar();

            if (empty($errores)) {
                //verificar si el usuario existe
                $resultado = $auth->existeUsuario();

                if (!$resultado) {
                    //verificar si el usuario o no (Mensaje de error) array con mensaje de error
                    $errores = Admin::getErrores();
                } else {
                    //verificar el password
                    $autenticado = $auth->comprobarPassword($resultado);

                    if ($autenticado) {
                        //autenticar el usuario
                        $auth->autenticar();
                    } else {
                        //pasword incorrecto(mensaje de error)
                        $errores = Admin::getErrores();
                    }
                }
            }
        }
        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }

    public static function logout()
    {
        //acceder a la sesion actual
        session_start();

        //le agregamos un arreglo vacio el cual va a remplazar la infomracion anterior de la sesion y quedara de nuevo coomo un arrelgo vacio
        $_SESSION = [];

        header('Location: /');
    }
}
