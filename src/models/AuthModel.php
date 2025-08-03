<?php
namespace App\Models;

use App\Config\DB;
use App\DB\ConnectionDB;


class AuthModel {
    private $conexion;

    public function __construct() {
        $this->conexion = ConnectionDB::getConnection();
    }

    public function login($correo) {
        try {
            $query = $this->conexion->prepare("CALL Login(?)");
            $query->bindParam(1, $correo);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            return $result ?: false;
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }


}
