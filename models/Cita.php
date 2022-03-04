<?php

namespace Model;

class Cita extends ActiveRecord {
    //DB
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'usuario_id'];

    public $id;
    public $fecha;
    public $hora;
    public $usuario_id;

    public function __construct($array = []) 
    {
        $this->id           =   $array['id'] ?? null;
        $this->fecha        =   $array['fecha'] ?? '';
        $this->hora         =   $array['hora'] ?? '';
        $this->usuario_id   =   $array['usuario_id'] ?? '';
    }
}