<?php
namespace App\Models;

use App\DB\ConnectionDB;
use App\Config\responseHTTP;

class UserModel extends ConnectionDB {
    private static $nombre;
    private static $tipo_usuario;
    private static $correo;
    private static $clave;
    private static $fecha;

    public function __construct(array $data) {
        self::$nombre        = $data['nombre'] ?? null;
        self::$tipo_usuario  = $data['tipo_usuario'] ?? null;
        self::$correo        = $data['correo'] ?? null;
        self::$clave         = $data['clave'] ?? null;
        self::$fecha         = date('Y-m-d');
    }

    public static function post() {
        try {
            $con = self::getConnection();

            // Verificar si el correo ya existe y está activo
            $check = $con->prepare("SELECT COUNT(*) FROM usuario WHERE correo = :correo AND activo = 1");
            $check->bindParam(':correo', self::$correo);
            $check->execute();
            $existe = $check->fetchColumn();

            if ($existe > 0) {
                return \App\Config\responseHTTP::status400('El correo ya está registrado y activo.');
            }

            // Registro de nuevo usuario
            $query = "CALL InsertarUsuario(:p_nombre, :p_tipo_usuario, :p_correo, :p_password, :p_fecha_registro)";
            $stmt = $con->prepare($query);

            $valores = [
                ':p_nombre'         => self::$nombre,
                ':p_tipo_usuario'   => self::$tipo_usuario,
                ':p_correo'         => self::$correo,
                ':p_password'       => password_hash(self::$clave, PASSWORD_DEFAULT),
                ':p_fecha_registro' => self::$fecha
            ];

            $stmt->execute($valores);

            if ($stmt->rowCount() > 0) {
                return \App\Config\responseHTTP::status200('Usuario registrado correctamente.');
            } else {
                return \App\Config\responseHTTP::status500('Error al registrar el usuario.');
            }

        } catch (\PDOException $e) {
            error_log('UserModel::post -> ' . $e);
            return \App\Config\responseHTTP::status500('Error específico: ' . $e->getMessage());
        }
    }


    public static function get() {
        try {
            $con = self::getConnection();
            $stmt = $con->query("SELECT id_usuario, nombre, tipo_usuario, correo, fecha_registro FROM usuario WHERE activo = 1");
            $usuarios = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return responseHTTP::status200('Usuarios obtenidos correctamente.', $usuarios);
        } catch (\PDOException $e) {
            error_log('UserModel::get -> ' . $e);
            return responseHTTP::status500('Error al obtener los usuarios.');
        }
    }

   public static function update($id, $data) {
        try {
            $con = self::getConnection();

            $campos = [];
            $valores = [':id' => $id];

            if (!empty($data['nombre'])) {
                $campos[] = "nombre = :nombre";
                $valores[':nombre'] = $data['nombre'];
            }

            if (!empty($data['correo'])) {
                $campos[] = "correo = :correo";
                $valores[':correo'] = $data['correo'];
            }

            if (empty($campos)) {
                return responseHTTP::status400('Nada que actualizar.');
            }

            $sql = "UPDATE usuario SET " . implode(', ', $campos) . " WHERE id_usuario = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute($valores);

            if ($stmt->rowCount() > 0) {
                return [
                'status' => 'OK',
                'message' => 'Usuario actualizado correctamente.',
                'data' => []
            ];
            } else {
                return [
                'status' => 'ERROR',
                'message' => 'No se hicieron cambios.',
                'data' => []
            ];

            }

        } catch (\PDOException $e) {
            error_log('UserModel::update -> ' . $e);
            return responseHTTP::status500('Error al actualizar el usuario.');
        }
    }

    public static function delete($id) {
        try {
            $con = self::getConnection();
            $stmt = $con->prepare("UPDATE usuario SET activo = 0 WHERE id_usuario = :id");
            $stmt->execute([':id' => $id]);

            if ($stmt->rowCount() > 0) {
                return \App\Config\responseHTTP::status200('Usuario eliminado correctamente.');
            } else {
                return \App\Config\responseHTTP::status400('No se eliminó ningún usuario.');
            }

        } catch (\PDOException $e) {
            error_log('UserModel::delete -> ' . $e);
            return \App\Config\responseHTTP::status500('Error interno al eliminar el usuario.');
        }
    }

    public static function getOne($id) {
        try {
            $con = self::getConnection();
            $stmt = $con->prepare("SELECT id_usuario, nombre, tipo_usuario, correo, fecha_registro FROM usuario WHERE id_usuario = :id AND activo = 1");
            $stmt->execute([':id' => $id]);
            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Registro en log
            error_log('FETCH getOne usuario: ' . json_encode($usuario));

            if ($usuario) {
                return [
                    'status' => 'OK',
                    'message' => 'Usuario encontrado (prueba real).',
                    'data' => $usuario
                ];
            } else {
                return [
                    'status' => 'ERROR',
                    'message' => 'Usuario no encontrado.',
                    'data' => []
                ];
            }
        } catch (\PDOException $e) {
            error_log('UserModel::getOne -> ' . $e);
            return [
                'status' => 'ERROR',
                'message' => 'Error al obtener el usuario.',
                'data' => []
            ];
        }
    }
}