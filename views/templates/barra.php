<div class="barra">
    <p>Hola: <?php echo $nombre ?? ''; ?></p>
    <a class="btn" href="/logout">Cerrar Sesión</a>
</div>

<?php if( isset($_SESSION['admin']) ): // Si es admin ?>
    <div class="barra-servicios">
        <a class="btn" href="/admin">Ver Citas</a>
        <a class="btn" href="/servicios">Ver Servicios</a>
        <a class="btn" href="/servicios/crear">Nuevo Servicio</a>
    </div>
<?php endif; ?>