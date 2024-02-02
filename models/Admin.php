<?php

namespace Model;

class Admin extends ActiveRecord
{
    //base de Datos
    protected static $tabla = 'usuarios';
    protected static $columnasDb = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    //no es estatico, requiere instanciarse ->
    public function validar()
    {
        if (!$this->email) {
            self::$errores[] = 'El Email es obligatorio';
        }

        if (!$this->password) {
            self::$errores[] = 'El Password es obligatorio';
        }

        return self::$errores;
    }

    public function existeUsuario()
    {
        //revisar si un usuario existe o no
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        //insertamos query en la BD
        $resultado = self::$db->query($query);

        //si no hay nada en num_rows
        if (!$resultado->num_rows) {
            self::$errores[] = 'El usuario no existe';
            //para que el codigo deje de ejecutarse
            return;
        }
        return $resultado;
    }

    public function comprobarPassword($resultado)
    {
        $usuario = $resultado->fetch_object();
        /*
          toma dos parametros el 1 es el password que vamos a comparar y 
          el segundo es el password que esta en la base de datos, nos retornara true o false
          deopnediendo si el password digitado por el usuario coincide con el de la base de datos
        */
        $autenticado = password_verify($this->password, $usuario->password);

        if (!$autenticado) {
            self::$errores[] = 'El password es incorrecto';
        }

        return $autenticado;
    }

    public function autenticar()
    {
        //siemrpe para iniciar sesion 
        session_start();

        //llenar el arreglo de sesion
        $_SESSION['usuario'] = $this->email;
        //helper
        $_SESSION['login'] = true;

        //redireccionar al usuario
        header('Location: /admin');
    }
}
