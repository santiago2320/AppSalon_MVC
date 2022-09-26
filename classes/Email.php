<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

     // Atributos
     public $email;
     public $nombre;
     public $token;

     public function __construct($email, $nombre, $token)
     {
          $this->email = $email;
          $this->nombre = $nombre;
          $this->token = $token;
     }
     public function enviarConfirmacion(){

          // Crear el objeto del email
          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->Host = 'smtp.mailtrap.io';
          $mail->SMTPAuth = true;
          $mail->Port = 2525;
          $mail->Username = 'e8502175ac776d';
          $mail->Password = '60e19931a3b9b0';
          $mail->SMTPSecure= 'tls';

          $mail->setFrom('cuentas@appsalon.com');
          $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
          $mail->Subject = 'Confirma tu cuenta';

          // SET HTML
          $mail->isHTML(true);
          $mail->CharSet = 'UTF-8';

          $contenido = "<html>";
          $contenido .= "<p> <strong>Hola ". $this->email ." </strong> Has creado tu cuenta en AppSalon, debes confirmar la cuenta presionando el siguiente enlace</p>";
          $contenido .= "<p> Presiona aqui: <a href='https://dry-caverns-20785.herokuapp.com/confirmar-cuenta?token=" . $this->token ."'>Confirmar cuenta</a>";
          $contenido .= "<p> Si tu no solicitaste este cuenta, puedes ignorar el mensaje </p>";
          $contenido .= "</html>";
          $mail->Body = $contenido;

          //Enviar el email
          $mail->send();


     }

     public function enviarInstrucciones(){
          // Crear el objeto del email
          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->Host = 'smtp.mailtrap.io';
          $mail->SMTPAuth = true;
          $mail->Port = 2525;
          $mail->Username = 'e8502175ac776d';
          $mail->Password = '60e19931a3b9b0';
          $mail->SMTPSecure= 'tls';

          $mail->setFrom('cuentas@appsalon.com');
          $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
          $mail->Subject = 'Reestable password';

          // SET HTML
          $mail->isHTML(true);
          $mail->CharSet = 'UTF-8';

          $contenido = "<html>";
          $contenido .= "<p> <strong>Hola ". $this->nombre ." </strong> Ha solicitado Reestablecer tu password, sigue el siguiente enlace para hacerlo.</p>";
          $contenido .= "<p> Presiona aqui: <a href='https://dry-caverns-20785.herokuapp.com/recuperar?token=".
          $this->token ."'>Reestablecer Password</a>";
          $contenido .= "<p> Si tu no solicitaste este cuenta, puedes ignorar el mensaje </p>";
          $contenido .= "</html>";
          $mail->Body = $contenido;

          //Enviar el email
          $mail->send();
     }

}
?>
