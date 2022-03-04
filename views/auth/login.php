<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="form" method="POST" action="/">
    <div class="campo">
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" placeholder="Introduzca correo electrónico" name="email">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="Introduzca contraseña" name="password">
    </div>
    <input type="submit" class="btn" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/crear-cuenta">Crear cuenta</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>