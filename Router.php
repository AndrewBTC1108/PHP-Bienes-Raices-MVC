<?php
/*
/ La clase Router se utiliza para manejar y administrar rutas en una aplicación web, 
permitiendo asociar funciones o métodos específicos a diferentes URL de la aplicación.
*/
namespace MVC;

class Router
{
    public $rutasGet = [];
    public $rutasPost = [];

    //toma dos argumentos: $url y $fn. Este método almacena la función $fn asociada a la URL $url en el array $rutasGet
    public function get($url, $fn)
    {
        $this->rutasGet[$url] = $fn;
    }
    public function post($url, $fn)
    {
        $this->rutasPost[$url] = $fn;
    }
    public function comprobarRutas()
    {
        session_start();

        $auth = $_SESSION['login'] ?? null;
        //Arreglo de rutas protegidas..
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', 
                            '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];

        /*
        $_SERVER['PATH_INFO'] es una variable superglobal que contiene información sobre la ruta relativa del script 
        actual en relación con la raíz del documento. Si esta información no está disponible o no está definida, 
        el operador de fusión de null (??) asignará un valor predeterminado, que en este caso es una barra simple ('/').
        */
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        /*
        $_SERVER['REQUEST_METHOD'] contiene el método de solicitud HTTP utilizado para acceder a la página, como 'GET', 
        'POST', 'PUT', 'DELETE', etc. Esta variable es útil para determinar el tipo de solicitud HTTP y realizar acciones
         apropiadas según el método utilizado.
        */
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {
            /*
            Explode Divide la variable $urlActual usando la función explode() con el delimitador '?'. 
            Esto elimina la cadena de consulta (query string) de la URL (si está presente). 
            }Luego, selecciona el primer elemento del array resultante (índice 0) y lo asigna de nuevo a la variable $urlActual.
            */
            $urlActual = explode('?',$urlActual)[0];
            $fn = $this->rutasGet[$urlActual] ?? null;
        } else {
            $urlActual = explode('?',$urlActual)[0];
            $fn = $this->rutasPost[$urlActual] ?? null;
        }

        //Proteger las rutas..
        /*
        in_array() en PHP se utiliza para verificar si un valor específico existe dentro de un array (arreglo) o no. 
        La función devuelve true si el valor está presente en el array y false si no lo está. 
        Esta función es útil cuando se desea buscar y verificar la existencia de un elemento en un conjunto de datos almacenados en un array.
        */
        if(in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /');
        }

        if ($fn) {
            //La URL existe y hay una funcion asosciada
            //nos va permitir llamar una funcion cuando no sabemos como se llama esa funcion
            call_user_func($fn, $this);
        } else {
            echo 'Pagina no econtrada..';
        }
    }
    //muestra una vista
    /*
    Método render(), que acepta dos argumentos: $view y $datos (un array opcional con valores predeterminados a un array vacío).
     Este método se utiliza para renderizar una vista y enviar datos a esa vista. El método extrae las variables del array $datos
      y crea variables individuales para cada una de ellas. Luego, utiliza la función ob_start() para comenzar a almacenar 
      el contenido en un búfer de salida, incluye la vista y el diseño, y finalmente limpia el búfer de salida con ob_get_clean():
    */
    public function render($view, $datos = [])
    {
        /*
        . El propósito del ciclo es iterar a través del array asociativo $datos y crear variables dinámicamente 
        en función de las claves y valores de dicho array. El método render() utiliza estas variables para pasar datos a una vista específica.
        */
        foreach ($datos as $key => $value) {
            //doble $$ siginifica variable e variable
            $$key = $value;
        }
        ob_start(); // Inicia el almacenamiento en memoria un momento...
        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia la memoria

        include __DIR__ . "/views/layout.php";
    }

    /*
     En resumen, este script define una clase Router en PHP que se utiliza para manejar y administrar rutas en una aplicación web,
     permitiendo asociar diferentes funciones o métodos a diferentes URL y renderizar vistas con datos.
    */
}
