<div class="barra">
     <p>Hola:<span><?php echo $nombre ?? ''; ?></span></p>
     <a href="/logout" class="boton">Cerrar Sesión</a>
</div>

<?php if(isset($_SESSION['admin'])) { ?>
     <div class="barra-servicios">
          <a class="boton" href="/admin">Ver Citas</a>
          <a class="boton" href="/servicios">Ver servicios</a>
          <a class="boton" href="/servicios/crear">Nuevo servicio</a>
     </div>


<?php } else ?>