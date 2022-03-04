<?php

namespace Controllers;

use MVC\Router;

class CitaController {
    public static function index(Router $router) {

        $alertas = [];
        session_start();

        // Comprueba que el usuario esta autenticado
        isAuth();
        
        $router->render('cita/index', [
            'id' => $_SESSION['id'],
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas,
        ]);
    }
}