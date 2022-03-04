<?php 
require __DIR__ . '/../vendor/autoload.php';

// Configuramos Dotenv - De esta forma podemos acceder a las variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // Añadimos la ruta donde se encuentra el archivo
$dotenv->safeLoad(); // Si el archivo de la ruta no existe, no marca el error

require 'funciones.php';
require 'database.php';


// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);