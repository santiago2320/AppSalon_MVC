<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class loginController {
     public static function login(Router $router){
          $alertas = [];
          $auth = new Usuario();

          if($_SERVER['REQUEST_METHOD'] === 'POST'){
               // pasamos lo que el ususario escriba en POST
               $auth = new Usuario($_POST); 
               $alertas = $auth->validarLogin();

               if(empty($alertas)){
                    // Comprobar de que exista el Usuario - Email
                    $usuario = Usuario::where('email', $auth->email);

                    if($usuario){
                         // Verificar el Password
                         if( $usuario->comprobarPasswordandVerificar($auth->password) ){
                             //Autenticacion de Usuario
                             session_start();

                             $_SESSION['id'] = $usuario->id;
                             $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                             $_SESSION['email'] = $usuario->email;
                             $_SESSION['login'] = true;

                             // Redireccionamiento
                              if($usuario->admin === "1"){
                                   $_SESSION['admin'] =$usuario->admin ?? null;

                                   header('Location: /admin');
                              }else{
                                   header('Location: /cita');
                              }
                         }  
                    }else {
                         Usuario::setAlerta('error','Usuario no encontrado');
                    }
               }
          }

          $alertas = Usuario::getAlertas();

          $router->render('auth/login',[
               'alertas' => $alertas,
               'auth'=> $auth,
          ]);
     }

     public static function logout(){
          session_start();
          $_SESSION = [];
          header('Location: /');
     }

     public static function olvidar(Router $router){

          $alertas = [];

          if($_SERVER['REQUEST_METHOD'] === 'POST'){
               $auth = new Usuario($_POST);
               $alertas = $auth->validarEmail();

               if(empty($alertas)){
                    $usuario = Usuario::where('email', $auth->email);
                    
                    if($usuario && $usuario->confirmado === "1"){
                         
                         // Generar un token
                         $usuario->crearToken();
                         $usuario->guardar();

                         //TODO: Envair email.
                         $email = new Email($usuario->email, $usuario->nombre,$usuario->token);
                         $email->enviarInstrucciones();

                         // Alerta de exito
                         Usuario::setAlerta('exito','Revisa tu email');
                         
                    } else{
                         // Asignar alertas
                         Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                        
                    }
                     
               }
               
          }

          $alertas = Usuario::getAlertas();

          $router->render('auth/recuperar-contraseña',[
               'alertas'=> $alertas
          ]);
     }
     // Recuperar contraseñas
     public static function recuperar(Router $router){
          $alertas = [];
          $error = false;
          // Leer token
          $token = s($_GET['token']);

          // Buscar usuario por el token
          $usuario = Usuario::where('token',$token);

          if(empty($usuario)){
               Usuario::setAlerta('error','Token no valido'); 
               $error = true;
          }

          if($_SERVER['REQUEST_METHOD']=== 'POST'){
               // Leer el nuevo password y guardarlo
               $password = new Usuario($_POST);
               $alertas = $password->validarPassword();

               if(empty($alertas)){
                    $usuario->password = null;
                    
                    $usuario->password = $password->password;
                    // Hashear la contraseña
                    $usuario->hashPassword();
                    // Token vacio
                    $usuario->token = null;
                    // guardamos la contraseña bd
                    $resultado = $usuario->guardar();
                    // si guardo correctamente lo enviamos INICIAR SESION
                    if($resultado){
                         header('location: /');
                    }
               }
          }

          $alertas = Usuario::getAlertas();
          $router->render('auth/recuperar-password',[
               'alertas'=> $alertas,
               'error'=> $error
          ]);
     }

     public static function crear(Router $router){  
          $usuario = new Usuario;
          // Alertas Vacias
          $alertas=[];
          if($_SERVER['REQUEST_METHOD'] === 'POST'){
               
               $usuario->sincronizar($_POST);
               $alertas = $usuario->validarNuevaCuenta();

               // Revisar que alertas este vacio
               if(empty($alertas)){
                    // Verficar que el usuario no este registrado
                   $resultado =  $usuario->existeUsuario();

                   if($resultado->num_rows){
                        $alertas = Usuario::getAlertas();
                   }else{
                       //hashear el password **NO**
                       $usuario->hashPassword();
                       // Generar un token unico
                       $usuario->crearToken();
                       // Enviar el Email
                       $email = new Email($usuario->nombre, $usuario->email,$usuario->token);
                       // Enviar email de confirmación
                       $email->enviarConfirmacion();

                       // Crear el usuario
                       $resultado=$usuario->guardar();

                       if($resultado){
                            header('location: /mensaje');
                       }  
                       //debuguear($usuario);
                   }
               }
          }
          // Muestra en la Vista
          $router->render('auth/crear-cuenta',[
               'usuario' => $usuario,
               'alertas' => $alertas
          ]);
     }

     public static function mensaje(Router $router){
          $router->render('auth/mensaje');
     }

     public static function confirmar(Router $router){
          $alertas = [];

          $token = s($_GET['token']);
          
          $usuario = Usuario::where('token',$token);

         if(empty($usuario)){
              // Mostrar mensaje de error
              Usuario::setAlerta('error','Token No Valido');
         }else{
              // Modificar a usuario confirmado
              // Cambia el valor confirmado 
              $usuario->confirmado = "1";
              // Elimina el token
              $usuario->token = null;
              // Guardar y Actualizar
              $usuario->guardar();
              // Mensaje de exito
              Usuario::setAlerta('exito','Cuenta Comprobada correctamente');
         }
          // Obtener alertas
          $alertas = Usuario::getAlertas();

          // Renderizar lasa vistas
          $router->render('auth/confirmar-cuenta',[
               'alertas' => $alertas
          ]);
     }
     
}