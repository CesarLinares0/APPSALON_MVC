<?php

namespace Model;

class Usuario extends ActiveRecord {
    //DB
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'telefono', 'password', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $password;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($array = []) {
        $this->id           =       $array['id'] ?? null;
        $this->nombre       =       $array['nombre'] ?? '';
        $this->apellido     =       $array['apellido'] ?? '';
        $this->email        =       $array['email'] ?? '';
        $this->telefono     =       $array['telefono'] ?? '';
        $this->password     =       $array['password'] ?? '';
        $this->admin        =       $array['admin'] ?? 0;
        $this->confirmado   =       $array['confirmado'] ?? 0;
        $this->token        =       $array['token'] ?? '';
    }

    //Mensajes de validación al crear cuenta
    public function validarNewUsuario() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'Nombre es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'Apellido es Obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'Correo Eléctronico es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'Contraseña es Obligatoria';
        } else {
            //Con strlen, obtenemos la longitud de un string
            if(strlen($this->password) < 6) {
                self::$alertas['error'][] = 'La Contraseña debe tener al menos 6 caracteres';
            }
        }
        
        return self::$alertas;
    }

    //Mensajes de validación del Login
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El correo eléctronico es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }

        return self::$alertas;
    }

    //Mensaje de validación del Olvide
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El correo eléctronico es obligatorio';
        }

        return self::$alertas;
    }

    //Mensaje de validación del recuperar
    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La Contraseña debe tener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    //Comprueba si el usuario ya existe
    public function existeUsuario() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        // Si hay resultados
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya esta registrado';
        }

        return $resultado;
    }

    //Hashea password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //Crea token único
    public function newToken() {
        $this->token = uniqid();
    }

    //Comprueba el password y que el usuario este confirmado
    public function comprobarPasswordAndConfirmado($password) {
        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Contraseña incorrecta o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }
}