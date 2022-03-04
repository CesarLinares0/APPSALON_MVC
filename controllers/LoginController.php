<?php

namespace Controllers;

use Layout\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function crear (Router $router) {

        $usuario = new Usuario;
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Sincronizamos los datos de la entidad con los datos del formulario.
            $usuario->sincronizar($_POST);

            // Validación
            $alertas = $usuario->validarNewUsuario();

            if(empty($alertas)) {
                // Comprobar que el nuevo usuario no esta ya registrado
                $resultado = $usuario->existeUsuario();

                //Si esta registrado
                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas(); //Obtenemos las alertas
                } else {
                    //Hashear el Password
                    $usuario->hashPassword();

                    //Generar un Token único
                    $usuario->newToken();

                    //Enviar correo
                    $email = new Email($usuario->email, $usuario->nombre , $usuario->token);
                    $email->enviarConfirmacion();

                    // debuguear($usuario);

                    //Crear el usuario
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        header('Location: /mensaje');
                    }
                    
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas,
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router) {

        $alertas= [];

        //Obtenemos el token y lo sanitizamos
        $token = s($_GET['token']);   

        // Buscamos el usuario con dicho token en la DB
        $usuario = Usuario::where('token', $token); 

        if(empty($usuario)) {
            //Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            // Confirmar el usuario
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas,
        ]);
    }

    public static function login (Router $router) {

        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)) {
                //Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if($usuario) {
                    //Verificar el password
                    if( $usuario->comprobarPasswordAndConfirmado($auth->password) ) {
                        //Autenticar el usuario
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        /*Podemos ir llenando la session con todos los datos que creamos que son necesarios, 
                        para que a lo largo de la navegacion del usuario tengamos los datos, no tener que consultar la DB a cada rato*/

                        //Redireccionamiento (Dependiendo del rol del usuario)
                        if($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }

                    }
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas,
        ]);
    }

    public static function logout () {
        session_start();

        // Limpiamos la session
        $_SESSION = [];

        header('Location: /');
    }

    public static function olvide (Router $router) {
        
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                
                //Comprobar si existe y si esta confirmado
                if($usuario && $usuario->confirmado === "1") {

                    //Generar un token
                    $usuario->newToken();
                    $usuario->guardar();

                    //Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Mensaje enviado, revisa tu correo eléctronico');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas,
        ]);
    }

    public static function recuperar (Router $router) {

        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        //Buscar usuario por su Token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                //Eliminamos el password del Usuario y guardamos el nuevo
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword(); // No olvides hashear las contraseñas antes de añadirla a la DB

                //Eliminamos el token
                $usuario->token = null;

                $resultado = $usuario->guardar();

                if($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error,
        ]);
    }
}