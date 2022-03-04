<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elije tus servicios y añade tus datos</p>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elije los servicios disponibles</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tu Datos y Cita</h2>
        <p class="text-center">Añade tus datos y fecha de tu cita</p>
        <div id="cita-alertas"></div>

        <form class="form">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input id="nombre" type="text" placeholder="¿Cómo te llamas?" value="<?php echo $nombre; ?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input id="fecha" type="date" min="<?php echo date('Y-m-d', strtotime('+1 day')); // strtotime() comvierte string en datetime, estamos diciendo que sume dia +1 ?>"> 
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input id="hora" type="time">
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </div>
    <div id="paso-3" class="seccion">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>
        <div id="resumen-alertas"></div>

        <div id="contenido-resumen"></div>
    </div>

    <div class="paginacion">
        <button id="anterior" class="btn">&laquo; Anterior</button>
        <button id="siguiente" class="btn">Siguiente &raquo;</button>
    </div>
</div>

<?php 
    $script = "
        <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>