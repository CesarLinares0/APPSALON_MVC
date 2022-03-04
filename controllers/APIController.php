<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar() {

        // Almacena la cita, y devuelve su ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $id = $resultado['id'];

        // Almacena los Servicios relacionadas a la Cita
        $idServicios = explode(",", $_POST['servicios']); // Separamos los IDs por las comas

        foreach($idServicios as $idServicio) {
            $args = [
                'cita_id' => $id,
                'servicio_id' => $idServicio
            ];

            // Creamos una nueva instancia, y le pasamos los argumentos
            $citaServicio = new CitaServicio($args); 
            $citaServicio->guardar(); // Al no tener ID, crea el registro

        }

        // Retornamos el resultado
        echo json_encode([
            'resultado' => $resultado
        ]);
    }

    public static function eliminar() {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            
            header( 'Location:' . $_SERVER['HTTP_REFERER'] );
        }
    }
}