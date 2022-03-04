<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        session_start();

        // Comproba que el usuario sea Admin
        isAdmin();

        // Obtiene la fecha por GET, si no existe, obtiene la fecha actual
        $fecha = $_GET['fecha'] ?? date('Y-m-d');

        // Comprueba si no es una fecha valida, redirecciona al cliente
        $fechas = explode('-', $fecha);
        if( !checkdate($fechas[1], $fechas[2], $fechas[0]) ) {
            header('Location: /404');
        }

        // Consulta Plana de SQL
        $consulta = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio ";
        $consulta .= " FROM citas ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON usuarios.id=citas.usuario_id ";
        $consulta .= " LEFT OUTER JOIN citas_servicios ";
        $consulta .= " ON citas_servicios.cita_id=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citas_servicios.servicio_id ";
        $consulta .= " WHERE fecha = '${fecha}' ";

        // Consultar la DB
        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}