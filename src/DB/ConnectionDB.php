<?php

namespace App\DB;

use App\Config\responseHTTP;
use PDO;
use Dotenv\Dotenv; 
class ConnectionDB {

    private static ?PDO $conexion = null;

  final public static function getConnection(): ?PDO {
    if (self::$conexion === null) {

        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $port = $_ENV['DB_PORT'] ?? '3306';
        $db = $_ENV['DB_DATABASE'] ?? 'talleres_escolares';
        $user = $_ENV['DB_USER'] ?? 'root';
        $password = $_ENV['DB_PASSWORD'] ?? '';

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";

        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        self::$conexion = new PDO($dsn, $user, $password, $opt);

        error_log("Conexión exitosa a la BD.");
    }
    return self::$conexion;
}
}