<?php

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/Config/errorlogs.php';
require_once dirname(__DIR__) . '/Config/responseHTTP.php';
require_once __DIR__ . '/connectionDB.php';
require_once __DIR__ . '/dataDB.php';

use App\Config\errorlogs;
use App\Config\responseHTTP;
use App\DB\ConnectionDB;
use Dotenv\Dotenv;

errorlogs::activa_error_logs();

// carga del archivo .env
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

// variables de entorno
if (
    empty($_ENV['USER']) ||
    empty($_ENV['DB']) ||
    empty($_ENV['IP']) ||
    empty($_ENV['PORT'])
) {
    die(" Las variables de entorno no están bien definidas");
}

//datos de conexión
$data = [
    "user" => $_ENV['USER'],
    "password" => $_ENV['PASSWORD'],
    "DB" => $_ENV['DB'],
    "IP" => $_ENV['IP'],
    "port" => $_ENV['PORT']
];

// DSN
$host = "mysql:host={$data['IP']};port={$data['port']};dbname={$data['DB']}";

// inicialización de la conexión
connectionDB::inicializar($host, $data['user'], $data['password']);

// prueba de la conexión real
try {
    $pdo = connectionDB::getConnection(); // <-- Este es el que realmente conecta
    echo "Conectado correctamente a la base de datos '{$data['DB']}' en {$data['IP']}:{$data['port']}";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}