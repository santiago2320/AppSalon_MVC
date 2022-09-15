<?php 

require_once __DIR__ . '/../includes/app.php';

use controllers\apiController;
use controllers\citaController;
use controllers\LoginController;
use controllers\AdminController;
use controllers\ServicioController;
use MVC\Router;

$router = new Router();

// Iniciar Sesion - rutas get-post
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);
$router->get('/logout',[LoginController::class,'logout']); //Cerrar Sesion

// Recuperar password
$router->get('/olvidar',[LoginController::class,'olvidar']);
$router->post('/olvidar',[LoginController::class,'olvidar']);
$router->get('/recuperar',[LoginController::class,'recuperar']);
$router->post('/recuperar',[LoginController::class,'recuperar']);

// Crear cuenta
$router->get('/crear-cuenta',[LoginController::class,'crear']);
$router->post('/crear-cuenta',[LoginController::class,'crear']); 

// Confirmar cuenta
$router->get('/confirmar-cuenta',[LoginController::class,'confirmar']);
$router->get('/mensaje',[LoginController::class,'mensaje']);

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