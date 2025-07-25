<?php
namespace App\Models;

use App\DB\connectionDB;
use App\Config\responseHTTP;

class tallerModel extends connectionDB {
    private static $id_taller;
    private static $id_instructor;
    private static $nombre;
    private static $descripcion;
    private static $duracion;

    public function __construct(array $data) {
        self::$id_taller = $data['id_taller'] ?? null;
        self::$id_instructor = $data['id_instructor'] ?? null;
        self::$nombre = $data['nombre'] ?? null;
        self::$descripcion = $data['descripcion'] ?? null;
        self::$duracion = $data['duracion'] ?? null;
    }

    // GETTERS
    public static function getIdTaller() { return self::$id_taller; }
    public static function getIdInstructor() { return self::$id_instructor; }
    public static function getNombre() { return self::$nombre; }
    public static function getDescripcion() { return self::$descripcion; }
    public static function getDuracion() { return self::$duracion; }

    // SETTERS
    public static function setIdTaller($id) { self::$id_taller = $id; }
    public static function setIdInstructor($id) { self::$id_instructor = $id; }
    public static function setNombre($nombre) { self::$nombre = $nombre; }
    public static function setDescripcion($descripcion) { self::$descripcion = $descripcion; }
    public static function setDuracion($duracion) { self::$duracion = $duracion; }

    /**
     * Crear un nuevo taller (para el botón "Agregar Nuevo Taller")
     */
    final public static function post() {
        try {
            $con = self::getConnection();
            $query = "CALL InsertarTaller(:p_id_instructor, :p_nombre, :p_descripcion, :p_duracion)";
            $stmt = $con->prepare($query);
            $stmt->execute([
                ':p_id_instructor' => self::getIdInstructor(),
                ':p_nombre'        => self::getNombre(),
                ':p_descripcion'   => self::getDescripcion(),
                ':p_duracion'      => self::getDuracion()
            ]);

            if ($stmt->rowCount() > 0) {
                return responseHTTP::status200('Taller registrado correctamente.');
            } else {
                return responseHTTP::status500('Error al registrar el taller.');
            }
        } catch (\PDOException $e) {
            error_log('tallerModel::post -> ' . $e);
            die(json_encode(responseHTTP::status500()));
        }
    }

    /**
     * Obtener todos los talleres (para la "Lista de Talleres Activos")
     */
    final public static function getAll() {
        try {
            $con = self::getConnection();
            // El procedimiento podría unir tablas para traer también el nombre del instructor
            $stmt = $con->prepare("CALL ConsultarTalleres()");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("tallerModel::getAll -> " . $e);
            die(json_encode(responseHTTP::status500()));
        }
    }
    
    /**
     * Obtener un taller por su ID (para cargar datos en el formulario de "Editar")
     */
    final public static function getById() {
        try {
            $con = self::getConnection();
            $stmt = $con->prepare("CALL ConsultarTallerPorID(:p_id_taller)");
            $stmt->execute([':p_id_taller' => self::getIdTaller()]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("tallerModel::getById -> " . $e);
            die(json_encode(responseHTTP::status500()));
        }
    }

    /**
     * Actualizar un taller (para el botón "Editar")
     */
    final public static function update() {
        try {
            $con = self::getConnection();
            $query = "CALL ActualizarTaller(:p_id_taller, :p_id_instructor, :p_nombre, :p_descripcion, :p_duracion)";
            $stmt = $con->prepare($query);
            $stmt->execute([
                ':p_id_taller'      => self::getIdTaller(),
                ':p_id_instructor'  => self::getIdInstructor(),
                ':p_nombre'         => self::getNombre(),
                ':p_descripcion'    => self::getDescripcion(),
                ':p_duracion'       => self::getDuracion()
            ]);

            if ($stmt->rowCount() > 0) {
                return responseHTTP::status200('Taller actualizado correctamente.');
            } else {
                return responseHTTP::status404('No se encontró el taller o no se modificaron datos.');
            }
        } catch (\PDOException $e) {
            error_log("tallerModel::update -> " . $e);
            die(json_encode(responseHTTP::status500()));
        }
    }

    /**
     * Eliminar un taller 
     */
    final public static function delete() {
        try {
            $con = self::getConnection();
            $stmt = $con->prepare("CALL EliminarTaller(:p_id_taller)");
            $stmt->execute([':p_id_taller' => self::getIdTaller()]);

            if ($stmt->rowCount() > 0) {
                return responseHTTP::status200('Taller eliminado correctamente.');
            } else {
                return responseHTTP::status404('No se encontró el taller a eliminar.');
            }
        } catch (\PDOException $e) {
            error_log("tallerModel::delete -> " . $e);
            die(json_encode(responseHTTP::status500()));
        }
    }
}