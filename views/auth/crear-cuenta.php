<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Rellena el formulario para crear una cuenta</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>

<form class="form" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="¿Cómo te llamas?" value="<?php echo s($usuario->nombre); ?>">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" placeholder="Tu primer apellido es..." value="<?php echo s($usuario->apellido); ?>">
    </div>
    <div class="campo">
        <label for="telefono">Télefono</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Número de télefono" value="<?php echo s($usuario->telefono); ?>">
    </div>
    <div class="campo">
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" placeholder="Tu correo electrónico es..." value="<?php echo s($usuario->email); ?>">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Añade una contraseña a tu cuenta">
    </div>
    <input type="submit" value="Crear Cuenta" class="btn">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>