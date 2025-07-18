<?php
namespace App\Models;

use App\DB\connectionDB;
use App\DB\sql;
use App\Config\responseHTTP;
use App\Config\Security;

class userModel extends connectionDB {
    private static $nombre;
    private static $correo;
    private static $tipo_usuario;
    private static $clave;
    private static $fecha;
    private static $id_usuario;

    public function __construct(array $data) {
        self::$nombre = $data['nombre'] ?? null;
        self::$correo = $data['correo'] ?? null;
        self::$tipo_usuario = $data['tipo_usuario'] ?? null;
        self::$clave = $data['clave'] ?? null;
        self::$fecha = $data['fecha_registro'] ?? date('Y-m-d');
        self::$id_usuario = $data['id_usuario'] ?? null;
    }

    // GETTERS
    public static function getNombre() { return self::$nombre; }
    public static function getCorreo() { return self::$correo; }
    public static function getTipoUsuario() { return self::$tipo_usuario; }
    public static function getClave() { return self::$clave; }
    public static function getFecha() { return self::$fecha; }
    public static function getIdUsuario() { return self::$id_usuario; }

    // SETTERS
    public static function setIdUsuario($id) { self::$id_usuario = $id; }

    // Registrar usuario
    final public static function post() {
        try {
            $con = self::getConnection();
            $query = "CALL InsertarUsuario(:nombre, :tipo_usuario, :correo, :clave, :fecha)";
            $stmt = $con->prepare($query);
            $stmt->execute([
                ':nombre' => self::getNombre(),
                ':tipo_usuario' => self::getTipoUsuario(),
                ':correo' => self::getCorreo(),
                ':clave' => password_hash(self::getClave(), PASSWORD_DEFAULT),
                ':fecha' => self::getFecha()
            ]);

            if ($stmt->rowCount() > 0) {
                return responseHTTP::status200('Usuario registrado correctamente.');
            } else {
                return responseHTTP::status500('Error al registrar el usuario.');
            }
        } catch (\PDOException $e) {
            error_log('userModel::post -> ' . $e);
            die(json_encode(responseHTTP::status500()));
        }
    }

    // Obtener todos los usuarios
    final public static function getAll() {
        try {
            $con = self::getConnection();
            $stmt = $con->prepare("CALL ConsultarUsuarios()");
            $stmt->execute();
            $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $res;
        } catch (\PDOException $e) {
            error_log("userModel::getAll -> " . $e);
            die(json_encode(responseHTTP::status500()));
        }
    }

    // Eliminar usuario
    final public static function delete() {
        try {
            $con = self::getConnection();
            $stmt = $con->prepare("CALL EliminarUsuario(:id_usuario)");
            $stmt->execute([':id_usuario' => self::getIdUsuario()]);

            if ($stmt->rowCount() > 0) {
                return responseHTTP::status200('Usuario eliminado correctamente.');
            } else {
                return responseHTTP::status500('No se eliminó el usuario.');
            }
        } catch (\PDOException $e) {
            error_log("userModel::delete -> " . $e);
            die(json_encode(responseHTTP::status500()));
        }
    }

    // Actualizar nombre y correo del usuario
    final public static function update() {
        try {
            $con = self::getConnection();
            $stmt = $con->prepare("CALL ActualizarUsuario(:id_usuario, :nombre, :correo)");
            $stmt->execute([
                ':id_usuario' => self::getIdUsuario(),
                ':nombre' => self::getNombre(),
                ':correo' => self::getCorreo()
            ]);

            if ($stmt->rowCount() > 0) {
                return responseHTTP::status200('Usuario actualizado correctamente.');
            } else {
                return responseHTTP::status500('No se actualizó ningún dato.');
            }
        } catch (\PDOException $e) {
            error_log("userModel::update -> " . $e);
            die(json_encode(responseHTTP::status500()));
        }
    }
}
