<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\apiController;
use Controllers\citaController;
use Controllers\LoginController;
use Controllers\AdminController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

// Iniciar Sesion - rutas get-post
$router->get('/',[loginController::class,'login']);
$router->post('/',[loginController::class,'login']);
$router->get('/logout',[loginController::class,'logout']); //Cerrar Sesion

// Recuperar password
$router->get('/olvidar',[loginController::class,'olvidar']);
$router->post('/olvidar',[loginController::class,'olvidar']);
$router->get('/recuperar',[loginController::class,'recuperar']);
$router->post('/recuperar',[loginController::class,'recuperar']);

// Crear cuenta
$router->get('/crear-cuenta',[loginController::class,'crear']);
$router->post('/crear-cuenta',[loginController::class,'crear']); 

// Confirmar cuenta
$router->get('/confirmar-cuenta',[loginController::class,'confirmar']);
$router->get('/mensaje',[loginController::class,'mensaje']);

// AREA PRIVADA
$router->get('/cita',[citaController::class,'index']);
$router->get('/admin',[AdminController::class,'index']);

// API CONTROLLER
$router->get('/api/servicios',[apiController::class,'index']);
$router->post('/api/citas',[apiController::class,'guardar']);
$router->post('/api/eliminar',[apiController::class,'eliminar']);

// Crud Servicios
$router->get('/servicios',[ServicioController::class,'index']);
$router->get('/servicios/crear',[ServicioController::class,'crear']);
$router->post('/servicios/crear',[ServicioController::class,'crear']);
$router->get('/servicios/actualizar',[ServicioController::class,'actualizar']);
$router->post('/servicios/actualizar',[ServicioController::class,'actualizar']);
$router->post('/servicios/eliminar',[ServicioController::class,'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();