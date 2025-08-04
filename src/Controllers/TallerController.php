<?php

namespace App\Controllers;

use App\Models\tallerModel;
use App\Config\responseHTTP;

class tallerController
{
    private $method;
    private $route;
    private $params;
    private $data;
    private $headers;

    // Reglas de validación adaptadas para el modelo Taller
    private static $validar_numero = '/^[0-9]+$/'; // Para ID_Instructor, Duracion
    private static $validar_texto = '/^[a-zA-Z\s]+$/'; // Para Nombre (permite espacios)
 

    public function __construct(string $method, string $route, array $params, array $data, array $headers)
    {
        $this->method = $method;
        $this->route = $route;
        $this->params = $params;
        $this->data = $data;
        $this->headers = $headers;
    }

    // Método para manejar las solicitudes POST (Crear un nuevo taller)
    final public function post(string $endpoint)
    {
        if ($this->method == 'post' && $endpoint == $this->route) {
            

            // Validamos que los campos requeridos no vengan vacíos
            if (empty($this->data['id_instructor']) || empty($this->data['nombre']) ||
                empty($this->data['descripcion']) || empty($this->data['duracion'])) {
                echo json_encode(responseHTTP::status400('Todos los campos son requeridos para registrar un taller.'));
            }
            // Validamos que id_instructor y duracion sean solo números
            else if (!preg_match(self::$validar_numero, $this->data['id_instructor'])) {
                echo json_encode(responseHTTP::status400('El ID del instructor debe ser numérico.'));
            } else if (!preg_match(self::$validar_numero, $this->data['duracion'])) {
                echo json_encode(responseHTTP::status400('La duración debe ser un valor numérico.'));
            }
            // Validamos que el nombre contenga solo texto y espacios
            else if (!preg_match(self::$validar_texto, $this->data['nombre'])) {
                echo json_encode(responseHTTP::status400('En el campo nombre debe ingresar solo texto.'));
            }
           
            else {
                // Instanciamos el modelo con los datos y llamamos al método post
                new tallerModel($this->data);
                echo json_encode(tallerModel::post());
            }
            exit;
        }
    }

    // Método para manejar las solicitudes GET (Obtener talleres)
    final public function get(string $endpoint)
    {
        if ($this->method == 'get' && $endpoint == $this->route) {
            
            // Si hay un ID en los parámetros (ej. /taller/123), obtener un taller específico
            if (!empty($this->params[1])) {
                $id_taller = $this->params[1];
                // Validar que el ID sea numérico
                if (!preg_match(self::$validar_numero, $id_taller)) {
                    echo json_encode(responseHTTP::status400('El ID del taller debe ser numérico.'));
                } else {
                    // Preparamos los datos para el modelo
                    $this->data['id_taller'] = $id_taller;
                    new tallerModel($this->data);
                    echo json_encode(tallerModel::getById());
                }
            } else {
                // Si no hay ID, obtener todos los talleres
                echo json_encode(tallerModel::getAll());
            }
            exit;
        }
    }

    // Método para manejar las solicitudes PUT (Actualizar un taller)
    final public function put(string $endpoint)
    {
        if ($this->method == 'put' && $endpoint == $this->route) {
     

            // Validamos que los campos requeridos no vengan vacíos para la actualización
            if (empty($this->data['id_taller']) || empty($this->data['id_instructor']) || empty($this->data['nombre']) ||
                empty($this->data['descripcion']) || empty($this->data['duracion'])) {
                echo json_encode(responseHTTP::status400('Todos los campos son requeridos para actualizar un taller.'));
            }
            // Validamos que los campos numéricos sean válidos
            else if (!preg_match(self::$validar_numero, $this->data['id_taller'])) {
                echo json_encode(responseHTTP::status400('El ID del taller debe ser numérico.'));
            } else if (!preg_match(self::$validar_numero, $this->data['id_instructor'])) {
                echo json_encode(responseHTTP::status400('El ID del instructor debe ser numérico.'));
            } else if (!preg_match(self::$validar_numero, $this->data['duracion'])) {
                echo json_encode(responseHTTP::status400('La duración debe ser un valor numérico.'));
            }
            // Validamos el nombre
            else if (!preg_match(self::$validar_texto, $this->data['nombre'])) {
                echo json_encode(responseHTTP::status400('En el campo nombre debe ingresar solo texto.'));
            }
            else {
                // Instanciamos el modelo con los datos y llamamos al método update
                new tallerModel($this->data);
                echo json_encode(tallerModel::update());
            }
            exit;
        }
    }

    // Método para manejar las solicitudes DELETE (Eliminar un taller)
    final public function delete(string $endpoint)
    {
        if ($this->method == 'delete' && $endpoint == $this->route) {
       
            // Esperamos el ID del taller como el primer parámetro de la URL (ejemplo: /taller/123)
            if (empty($this->params[1])) {
                echo json_encode(responseHTTP::status400('Se requiere el ID del taller para eliminar.'));
            } else {
                $id_taller = $this->params[1];
                // Validar que el ID sea numérico
                if (!preg_match(self::$validar_numero, $id_taller)) {
                    echo json_encode(responseHTTP::status400('El ID del taller a eliminar debe ser numérico.'));
                } else {
                    // Preparamos los datos para el modelo
                    $this->data['id_taller'] = $id_taller;
                    new tallerModel($this->data);
                    echo json_encode(tallerModel::delete());
                }
            }
            exit;
        }
    }
}