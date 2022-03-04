<?php

namespace Model;

class Servicio extends ActiveRecord {
    // DB
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($array = []) {
        $this->id = $array['id'] ?? null;
        $this->nombre = $array['nombre'] ?? '';
        $this->precio = $array['precio'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Servicio el Obligatorio';
        }
        if(!$this->precio) {
            self::$alertas['error'][] = 'El Precio del Servicio el Obligatorio';
        }
        if(!is_numeric($this->precio)) { // Si el valor no es numerico
            self::$alertas['error'][] = 'El precio no es válido';
        }

        return self::$alertas;
    }
}