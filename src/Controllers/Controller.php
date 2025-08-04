<?php
namespace App\Controllers;

use App\Config\responseHTTP;

abstract class Controller {
    protected $method;
    protected $route;
    protected $params;
    protected $data;
    protected $headers;

    const VALIDAR_TEXTO = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
    const VALIDAR_EMAIL = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    const VALIDAR_NUMERO = '/^[0-9]+$/';

    public function __construct(string $method, string $route, array $params, array $data, array $headers)
    {
        $this->method = $method;
        $this->route = $route;
        $this->params = $params;
        $this->data = $data;
        $this->headers = $headers;
    }

    protected function validateAndRespond(array $data, array $requiredFields, string $action, array $textFields = [], string $numberPattern = '')
    {
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                echo json_encode(responseHTTP::status400("El campo '{$field}' es requerido."));
                exit;
            }
        }

        foreach ($textFields as $field) {
            if (!preg_match(self::VALIDAR_TEXTO, $data[$field])) {
                echo json_encode(responseHTTP::status400("En el campo '{$field}' debe ingresar solo texto."));
                exit;
            }
        }

        if ($numberPattern) {
            foreach ($data as $key => $value) {
                if (preg_match($numberPattern, $value) && !preg_match($numberPattern, $key) && !is_numeric($value)) {
                    echo json_encode(responseHTTP::status400("El valor del campo '{$key}' debe ser numérico."));
                    exit;
                }
            }
        }

        if ($action === 'post') {
            new \App\Models\TallerModel($data);
            echo json_encode(\App\Models\TallerModel::post());
        } elseif ($action === 'put') {
            new \App\Models\TallerModel($data);
            echo json_encode(\App\Models\TallerModel::update());
        } elseif ($action === 'delete') {
            new \App\Models\TallerModel($data);
            echo json_encode(\App\Models\TallerModel::delete());
        }
    }
}