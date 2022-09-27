<?php


namespace Controllers;

use Model\Cita;
use Model\citasservicios;
use Model\Servicio;

class ApiController {
     public static function index() {
          $servicios = Servicio::all();
          echo json_encode($servicios, JSON_UNESCAPED_UNICODE);
     }

     public static function guardar(){

          // Almacena la cita y devuelve el Id
          $cita = new Cita($_POST);
          $resultado = $cita->guardar();

          $id = $resultado['id'];

          // Almacena los servicios con el ID de la cita
          $idServicios = explode(",",$_POST['servicios']);
          foreach ($idServicios as $idServicio ) {
               $args = [
                    'citaId' => $id,
                    'servicioId' =>  $idServicio
               ];
               $citaServicio = new citasservicios($args);
               $citaServicio->guardar();
          }
          echo json_encode(['resultado' => $resultado]);
     }

     public static function eliminar(){
          
          if($_SERVER['REQUEST_METHOD']=== 'POST'){
               $id = $_POST['id'];
               $cita = Cita::find($id);
               $cita->eliminar();
               header('location:' . $_SERVER['HTTP_REFERER']);


          }
     }
}