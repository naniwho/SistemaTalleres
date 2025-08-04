<?php

namespace App\Controllers;

use App\Config\responseHTTP;
use App\Models\TallerModel;

class TallerController extends Controller
{
    public const VALIDAR_NUMERO = '/^[0-9]+$/';

    public function __construct(string $method, string $route, array $params, array $data, array $headers)
    {
        parent::__construct($method, $route, $params, $data, $headers);
    }
    
    // Método para manejar las peticiones GET
    final public function get(string $endpoint)
    {
        if ($this->method === 'get' && $endpoint === $this->route) {
            
            // Si no hay parámetros, obtener todos los talleres
            if (empty($this->params)) {
                echo json_encode(TallerModel::getAll());
                exit;
            }
            
            // Si hay un parámetro, verificar si es el de instructor o un ID de taller
            if (isset($this->params[0])) {
                
                // Ruta para obtener talleres por ID de instructor (/taller/instructor/id)
                if ($this->params[0] === 'instructor' && isset($this->params[1]) && !empty($this->params[1])) {
                    $id_instructor = $this->params[1];
                    if (!preg_match(self::VALIDAR_NUMERO, $id_instructor)) {
                        echo json_encode(responseHTTP::status400('El ID del instructor debe ser numérico.'));
                        exit;
                    }
                    $this->data['id_instructor'] = $id_instructor;
                    new TallerModel($this->data);
                    echo json_encode(TallerModel::getByInstructorId());
                    exit;
                }

                // Ruta para obtener un taller por su ID (/taller/id)
                if (count($this->params) === 1) {
                    $id_taller = $this->params[0];
                    if (!preg_match(self::VALIDAR_NUMERO, $id_taller)) {
                        echo json_encode(responseHTTP::status400('El ID del taller debe ser numérico.'));
                        exit;
                    }
                    $this->data['id_taller'] = $id_taller;
                    new TallerModel($this->data);
                    echo json_encode(TallerModel::getById());
                    exit;
                }
            }

            // Si no se encuentra una ruta válida, devolver un 404
            echo json_encode(responseHTTP::status404('Ruta no encontrada.'));
            exit;
        }
    }
    
    final public function post(string $endpoint)
    {
        if ($this->method === 'post' && $endpoint === $this->route) {
            $this->validateAndRespond($this->data, ['id_instructor', 'nombre', 'descripcion', 'duracion'], 'post', ['nombre', 'descripcion'], self::VALIDAR_NUMERO);
        }
    }

    final public function put(string $endpoint)
    {
        if ($this->method === 'put' && $endpoint === $this->route) {
            $this->validateAndRespond($this->data, ['id_taller', 'id_instructor', 'nombre', 'descripcion', 'duracion'], 'put', ['nombre', 'descripcion'], self::VALIDAR_NUMERO);
        }
    }

    final public function delete(string $endpoint)
    {
        if ($this->method === 'delete' && $endpoint === $this->route) {
            $this->validateAndRespond($this->data, ['id_taller'], 'delete');
        }
    }
}