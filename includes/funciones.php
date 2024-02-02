<?php

define('TEMPLATES_URL', __DIR__ .  '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false)
{
    include TEMPLATES_URL . "/${nombre}.php";
}

function estaAutenticado(): bool
{
    session_start();
    $auth = $_SESSION['login'];
    //en caso de detectar si esta autenticado
    //si no se va a saltar el if y a a rerornar false;
    //si tienes returns en los if no es necesario los else
    if ($auth) {
        //va a retornar
        return true;
    }
    return false;
}

//algunas funciones helper
function debuguear($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//escapa el HTML / sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

//Validar tipo de contenido
function validarTipoContenido($tipo)
{
    $tipos = ['vendedor', 'propiedad'];
    //primero toma lo que vamos a buscar $tipo y el segundo en el arreglo donde lo vamos a buscar
    return in_array($tipo, $tipos);
}

//muestra los mensajes
function mostrarNotificacion($codigo)
{
    $mensaje = '';
    switch ($codigo) {
        case 1:
            $mensaje = 'Creado correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

function validarORedireccionar(string $url)
{
    $id = $_GET['id']; //obtenemos el id con metodo $_GET
    $id = filter_var($id, FILTER_VALIDATE_INT); //validamos que sea un entero y no otro tipo
    // var_dump($_GET);
    //si no hay un id que seria un dato entero entonces nos redirige a la pagina principal
    if (!$id) {
        header("Location: ${url}");
    }
    return $id;
}
