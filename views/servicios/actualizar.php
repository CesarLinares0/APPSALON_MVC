<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Modifica los valores necesarios del formulario</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="form" method="POST"> <!-- Eliminamos el atributo action="" para poder recoger datos por metodo GET -->
    <?php include_once __DIR__ . '/form.php'; ?>
    <input type="submit" class="btn" value="Guardar Servicio">
</form>