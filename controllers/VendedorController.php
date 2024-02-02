<?php

namespace Controllers;

use MVC\Router;
use Model\vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class VendedorController
{
    public static function crear(Router $router)
    {
        //get
        $errores = vendedor::getErrores();

        $vendedor = new vendedor;

        //POST
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $vendedor = new Vendedor($_POST);

            /** Subida de archivos */
            //generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';
            //setear la imagen
            if ($_FILES['imagen']['tmp_name']) {
                //Realiza un resize a la imagen con intervation
                $imagen = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
                //guarda el nombre de la imagen en la BD
                $vendedor->setImage($nombreImagen);
            }
            //validar
            $errores = $vendedor->validar();

            if (empty($errores)) {
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                //guarda la imagen en el servidor
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                //guarda la imagen y los datos $_POST en la base de datos
                $resultado = $vendedor->guardar();
            }
        }
        //pasamos hacia la vista
        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }

    public static function actualizar(Router $router)
    {
        //GET
        $id = validarORedireccionar('/admin');

        $vendedor = vendedor::find($id);

        $errores = vendedor::getErrores();

        //POST
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            //Asingar los atributos
            $args = [];
            $args['nombre'] = $_POST['nombre'] ?? null;
            $args['apellido'] = $_POST['apellido'] ?? null;
            $args['imagen'] = $_POST['imagen'] ?? null;
            $args['telefono'] = $_POST['telefono'] ?? null;

            //sincronizar
            $vendedor->sincronizar($args);

            //validasion
            $errores = $vendedor->validar();
            /** Subida de archivos */
            //generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';
            //setear la imagen
            if ($_FILES['imagen']['tmp_name']) {
                //Realiza un resize a la imagen con intervation
                $imagen = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
                //guarda el nombre de la imagen en la BD
                $vendedor->setImage($nombreImagen);
            }

            //revisar que el arreglo de errores este vacio
            if (empty($errores)) {
                //se verifica si hay una imagen nueva subida
                if (isset($imagen)) {
                    //almacenar la imagen
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }
                //de lo contrario se guarda todo normal
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
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
                    $vendedor = vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}
