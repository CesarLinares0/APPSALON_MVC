<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Crea tu nueva contraseña:</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<?php if($error) return;?>
<form class="form" method="POST"> <!-- Quitamos el atributo action, asi podemos enviar el token (Que nos llega por metodo GET) -->
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Nueva contraseña">
    </div>
    <input type="submit" class="btn" value="Guardar nueva contraseña">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">Crear cuenta</a>
</div>