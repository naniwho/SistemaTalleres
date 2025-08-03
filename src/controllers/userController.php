<?php
namespace App\Controllers;

use App\Config\Security;
use App\Models\UserModel;
use App\Config\responseHTTP;

class UserController {
    private $method;
    private $route;
    private $params;
    private $data;
    private $headers;

    public function __construct($method, $route, $params, $data, $headers) {
        $this->method  = $method;
        $this->route   = $route;
        $this->params  = $params;
        $this->data    = $data;
        $this->headers = $headers;
    }

    public function post($endpoint) {
        if ($this->method === 'post' && $endpoint === $this->route) {
            if (
                empty($this->data['nombre']) ||
                empty($this->data['correo']) ||
                empty($this->data['tipo_usuario']) ||
                empty($this->data['clave']) ||
                empty($this->data['confirmaClave'])
            ) {
                echo json_encode(responseHTTP::status400('Todos los campos son obligatorios.'));
                exit;
            }

            if (!filter_var($this->data['correo'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(responseHTTP::status400('Correo inválido.'));
                exit;
            }

            if ($this->data['clave'] !== $this->data['confirmaClave']) {
                echo json_encode(responseHTTP::status400('Las contraseñas no coinciden.'));
                exit;
            }

            $userModel = new UserModel($this->data);
            $resultado = $userModel::post();

            header('Content-Type: application/json');
            echo json_encode($resultado);
            exit;
        }
    }

    public function get($endpoint) {
        if ($this->method === 'get' && $endpoint === $this->route) {
            $token = $this->headers['Authorization'] ?? null;
            Security::validateTokenJwt($token);

            if (isset($this->params[1])) {
                $id = $this->params[1];
                echo json_encode(UserModel::getOne($id));
            } else {
                echo json_encode(UserModel::get());
            }
            exit;
        }
    }

    public function put($endpoint) {
        ob_clean();
        header('Content-Type: application/json');

        $id = $this->params[1] ?? null;

        if (!$id) {
            echo json_encode(responseHTTP::status400('Falta el ID del usuario.'));
            exit;
        }

        $token = $this->headers['Authorization'] ?? null;
        Security::validateTokenJwt($token);

        $resultado = UserModel::update($id, $this->data);
        echo json_encode($resultado);
        exit;
    }

    public function delete($endpoint) {
        ob_clean();
        header('Content-Type: application/json');

        $id = $this->params[1] ?? null;

        if (!$id) {
            echo json_encode(responseHTTP::status400('Falta el ID.'));
            exit;
        }

        $token = $this->headers['Authorization'] ?? null;
        Security::validateTokenJwt($token);

        $resultado = UserModel::delete($id);
        echo json_encode($resultado);
        exit;
    }
}


