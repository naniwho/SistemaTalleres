<?php
namespace App\Controllers;

use App\Models\AuthModel;
use App\Config\responseHTTP;
use Firebase\JWT\JWT;

class AuthController {
    private $authModel;
    private $clave_secreta;

    public function __construct() {
        $this->authModel = new AuthModel();
        $this->clave_secreta = \App\Config\Security::secretKey();
    }

    public function login($data) {
        try {
            $correo = $data['correo'] ?? null;
            $clave = $data['contraseña'] ?? null;

            if (!$correo || !$clave) {
                return responseHTTP::status400('Correo y contraseña son requeridos.');
            }

            $usuario = $this->authModel->login($correo);

            if (!$usuario) {
                return responseHTTP::status401('Usuario no encontrado.');
            }

            if (!password_verify($clave, $usuario['contraseña'])) {
                return responseHTTP::status401('Contraseña incorrecta.');
            }

            $payload = [
                'iat' => time(),        // Fecha de creación
                'exp' => time() + 3600, // 1 hora de validez
                'data' => [
                    'id_usuario' => $usuario['id_usuario'],
                    'correo' => $usuario['correo'],
                    'rol' => $usuario['rol']
                ]
            ];

            $jwt = JWT::encode($payload, $this->clave_secreta, 'HS256');

            return responseHTTP::status200('Login exitoso', [
                'token' => $jwt,
                'usuario' => [
                    'nombre' => $usuario['nombre'],
                    'rol' => $usuario['rol']
                ]
            ]);

        } catch (\Exception $e) {
            return responseHTTP::status500('Excepción: ' . $e->getMessage());
        }
    }
}

