<?php

namespace App\DB;

use App\Config\responseHTTP;
use PDO;
use Dotenv\Dotenv;

class ConnectionDB {
    private static $conexion = null;

    final public static function getConnection() {
        if (self::$conexion === null) {
            try {
                // Cargar .env
                $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
                $dotenv->load();

                $host     = $_ENV['IP'] ?? '127.0.0.1';
                $port     = $_ENV['PORT'] ?? '3306';
                $db       = $_ENV['DB'] ?? 'talleresescolares';
                $user     = $_ENV['USER'] ?? 'root';
                $password = $_ENV['PASSWORD'] ?? '';

                $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";

                $opt = [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ];

                self::$conexion = new PDO($dsn, $user, $password, $opt);
                error_log("Conexión exitosa a la BD");

            } catch (\PDOException $e) {
                error_log("Error en la conexión a la BD: " . $e->getMessage());
                die(json_encode(responseHTTP::status500()));
            }
        }

        return self::$conexion;
    }
}
