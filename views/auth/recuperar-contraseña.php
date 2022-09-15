<h1 class="nombre-pagina"> Recuperar contraseña</h1>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu email a continuación</p>

<?php include_once __DIR__ .  '/../templates/alertas.php';?>

<form class="formulario" action="/olvidar" method="POST">
     <div class="campo">
          <label for="email">E-mail:</label>
          <input type="email" name="email" id="email" placeholder="E-mail">
     </div>

     <input type="submit" class="boton" value="Recuperar contraseña">
</form>

<div class="acciones">
     <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
     <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
</div>