<h1 class="nombre-pagina">Olvide la Contraseña</h1>
<p class="descripcion-pagina">Reestablece tu constraseña, escribe tu correo eléctronico asociado a tu cuenta</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="form" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Correo Eléctronico</label>
        <input type="email" id="email" name="email" placeholder="Correo eléctronico">
    </div>
    <input type="submit" class="btn" value="Enviar">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">Crea tu cuenta</a>
</div>