<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginaController
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::get(3);
        $inicio = True;
        $router->render('Paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router)
    {
        $router->render('Paginas/nosotros');
    }

    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render('Paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router)
    {
        //GET
        $id = validarORedireccionar('/propiedades');

        $propiedad = Propiedad::find($id);

        $router->render('Paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    public static function blog(Router $router)
    {
        $router->render('Paginas/blog');
    }

    public static function entrada(Router $router)
    {
        $router->render('Paginas/entrada');
    }

    public static function contacto(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $mensaje = null;

            $respuestas = $_POST['contacto'];

            //crear una instancia en PHPMailer
            $mail = new PHPMailer();

            //configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '410c31a36bedc6';
            $mail->Password = '3bee4669506e7e';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            //configurar el contenido del E-email
            //quien envia el e-mail
            $mail->setFrom('admin@bienesraices.com');
            //quien recibe el e-mail
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            //mensaje
            $mail->Subject = 'Nuevo Mensaje';

            //habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo Mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';

            //enviar de forma condicional algunos campos de e-mail o telefono
            if($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Eligio ser contactado por Telefono:</p>';
                $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha de Contacto: ' . $respuestas['fecha'] . '</p>';
                $contenido .= '<p>Hora: ' . $respuestas['hora'] . '</p>';

            }else {
                //es e-mail entonces se agrega el campo de e-mail
                $contenido .= '<p>Eligio ser contactado por E-mail:</p>';
                $contenido .= '<p>E-mail: ' . $respuestas['email'] . '</p>';
            }

            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . '</p>';
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio'] . 'COP</p>';
            $contenido .= '<p>Prefiere ser Contactado por: ' . $respuestas['contacto'] . '</p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';

            //enviar el e-mail
            if ($mail->send()) {
                $mensaje = 'Mensaje Enviado Correctamente';
            } else {
                $mensaje = 'El mensaje no se pudo enviar';
            }
        }
        $router->render('Paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}
