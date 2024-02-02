<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController
{
    //para no tener necesidad de instaciar
    public static function index(Router $router)
    {
        $propiedades = Propiedad::all();
        $vendedores = vendedor::all();
        //para obtener el valor de resultado del archivo actualizar.php
        $resultado = $_GET['resultado'] ?? null;

        //pasamos hacia la vista
        $router->render('propiedades/admin', [
            //nombre del key es el mismo de la variable
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }
    //es estatico por que no queremos una nueva instancia y solo lo mandamos a llamar en el router
    public static function crear(Router $router)
    {
        //GET
        //instancia un nuevo objeto que va a estar vacio
        $propiedad = new Propiedad;

        //con el fin de mostrar los vendedores en el menu
        $vendedores = vendedor::all();

        //arreglo con mensaje de errores, nos va a retornar el array vacio donde se alojaran los mensajes de error
        $errores = Propiedad::getErrores();

        //POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Crea una nueva instancia y almacenamos los datos en memoria $_POST
            $propiedad = new Propiedad($_POST);

            /** Subida de archivos */
            //generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';
            //setear la imagen
            if ($_FILES['imagen']['tmp_name']) {
                //Realiza un resize a la imagen con intervation
                $imagen = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
                //guarda el nombre de la imagen en la BD
                $propiedad->setImage($nombreImagen);
            }
            //validar
            $errores = $propiedad->validar();

            //revisar que el arreglo de errores este vacio
            if (empty($errores)) {

                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                //guarda la imagen en el servidor
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                //guarda la imagen y los datos $_POST en la base de datos
                $resultado = $propiedad->guardar();
            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores

        ]);
    }
    public static function actualizar(Router $router)
    {
        //GET
        $id = validarORedireccionar('/admin');

        $propiedad = Propiedad::find($id);

        $vendedores = vendedor::all();

        $errores = Propiedad::getErrores();

        //POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Asingar los atributos para luego validar
            //se inicia un array vacio en el cual iremos llenando los datos POST para luego sincronizar
            $args = [];
            $args['titulo'] = $_POST['titulo'] ?? null;
            $args['precio'] = $_POST['precio'] ?? null;
            $args['imagen'] = $_POST['imagen'] ?? null;
            $args['descripcion'] = $_POST['descripcion'] ?? null;
            $args['habitaciones'] = $_POST['habitaciones'] ?? null;
            $args['wc'] = $_POST['wc'] ?? null;
            $args['estacionamiento'] = $_POST['estacionamiento'] ?? null;

            //sincronizamos para agregar nueva informacion que se haya actualizado
            $propiedad->sincronizar($args);

            //validasion
            $errores = $propiedad->validar();

            //subida de archivos
            //generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';

            //setear la imagen(se comprueba si se ha subido una imagen nueva)
            if ($_FILES['imagen']['tmp_name']) {
                //Realiza un resize a la imagen con intervation
                $imagen = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);

                //guarda el nombre de la imagen el la DB
                $propiedad->setImage($nombreImagen);
            }

            //revisar que el arreglo de errores este vacio
            if (empty($errores)) {
                //se verifica si hay una imagen nueva subida
                if (isset($imagen)) {
                    //almacenar la imagen
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }
                //de lo contrario se guarda todo normal
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $tipo = $_POST['tipo'];
                if (validarTipoContenido($tipo)) {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}
