<!-- // ini_set('display_errors', 1);

// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); -->
<?php
require_once __DIR__ . '/../includes/app.php';
//router se va a encargar de tener todas las rutas, todos los controladores y va a mandar a llamar ciertos metodos
use MVC\Router;
use Controllers\LoginController;
use Controllers\PropiedadController;
use Controllers\VendedorController;
use Controllers\PaginaController;

//Visitamos una URL, esta URL tiene un controlador asociado y tiene un metodo
$router = new Router();
//Private zone
//Propiedades
$router->get('/admin', [PropiedadController::class, 'index']);
$router->get('/propiedades/crear', [PropiedadController::class, 'crear']);
$router->post('/propiedades/crear', [PropiedadController::class, 'crear']);
$router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/propiedades/eliminar', [PropiedadController::class, 'eliminar']);

//vendedores
$router->get('/vendedores/crear', [VendedorController::class, 'crear']);
$router->post('/vendedores/crear', [VendedorController::class, 'crear']);
$router->get('/vendedores/actualizar', [VendedorController::class, 'actualizar']);
$router->post('/vendedores/actualizar', [VendedorController::class, 'actualizar']);
$router->post('/vendedores/eliminar', [VendedorController::class, 'eliminar']);

//zona publica
$router->get('/', [PaginaController::class,'index']);
$router->get('/nosotros', [PaginaController::class,'nosotros']);
$router->get('/propiedades', [PaginaController::class,'propiedades']);
$router->get('/propiedad', [PaginaController::class,'propiedad']);
$router->get('/blog', [PaginaController::class,'blog']);
$router->get('/entrada', [PaginaController::class,'entrada']);
$router->get('/contacto', [PaginaController::class,'contacto']);
$router->post('/contacto', [PaginaController::class,'contacto']);

//Login y Autenticacion
$router->get('/login',[LoginController::class, 'login']);
$router->post('/login',[LoginController::class, 'login']);
$router->get('/logout',[LoginController::class, 'logout']);

$router->comprobarRutas();
?>