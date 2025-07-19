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
    public static function getEmail() {return self::$correo;}



    // SETTERS
    public static function setEmail($email) {self::$correo = $email;}
    public static function setTipoUsuario($tipo) {self::$tipo_usuario = $tipo;}
    public static function setClave($clave) {self::$clave = $clave;}
    public static function setFecha($fecha) {self::$fecha = $fecha;}
    public static function setIdUsuario($id) {self::$id_usuario = $id;}

    // Registrar usuario
    final public static function post() {
        try {
            $con = self::getConnection();
            $query = "CALL InsertarUsuario(:p_nombre, :p_tipo_usuario, :p_correo, :p_contraseña, :p_fecha_registro)";
            $stmt = $con->prepare($query);
            $stmt->execute([
                ':p_nombre' => self::getNombre(),
                ':p_tipo_usuario' => self::getTipoUsuario(),
                ':p_correo' => self::getCorreo(),
                ':p_contraseña' => password_hash(self::getClave(), PASSWORD_DEFAULT),
                ':p_fecha_registro' => self::getFecha()
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

    final public static function login(){
       // echo "llegamos al model";
        try {
            $con = self::getConnection(); //abrimos conexion
            $query = "CALL Login(:email)"; //hacemos la consulta para validar la info
            $stmt = $con->prepare($query); //preparamos query
            $stmt->execute([ //pasamos los parametros
                        ':email' => self::getEmail()
                    ]);
                    
            if($stmt->rowCount() == 0){ //contamos los registros retornados
                return responseHTTP::status400('Usuario o Contraseña incorrectas!!!');
            }else{ //si vienen datos
                
                foreach ($stmt as $val) {
                     //validamos que la contraseña que se ingreso sea igual al hash que tenemos en la BD   
                     error_log("Clave recibida del procedimiento: " . json_encode($val));
                    error_log("Contraseña ingresada por el usuario: " . self::getClave());

                     if(Security::validatePassword(self::getClave(), $val['clave'])){
                        //si las claves son igual entonces construyo el Payload de mi JWT  
                        $payload =[
                            'IDToken' => $val['IDToken']
                        ];
                        //creo el token 
                        $token = Security::createTokenJwt(Security::secretKey(),$payload);
                        //datos que le mostraremos a el usuario
                        $data = [
                            'nombre' => $val['nombre'],
                            'rol' => $val['rol'],
                            'token' => $token,
                            'access' => 1,
                        ];
                        
                        return($data);
                        //retorno la data
                        
                     }else{
                        return responseHTTP::status400('Usuario o Contraseña incorrectas1!!!');
                     }
                }
            }
        } catch (\PDOException $e) {
            error_log("userModel::Login -> ".$e);
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