<?php

namespace App\Config;

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Config\responseHTTP;

class Security {
    private static $jwt_data;

    public static function secretKey() {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
        return $_ENV['SECRET_KEY'];
    }

    public static function createPassword($pass) {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    public static function validatePassword($pw, $pwh) {
        return password_verify($pw, $pwh);
    }

    public static function createTokenJwt(string $key, array $data) {
        $payload = [
            "iat" => time(),
            "exp" => time() + (60 * 60 * 6), // 6 horas
            "data" => $data
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    public static function validateTokenJwt(?string $authHeader) {
        if (!$authHeader) {
            echo json_encode(responseHTTP::status401("Token no enviado"));
            exit;
        }

        $token = str_replace("Bearer ", "", $authHeader);

        try {
            $decoded = JWT::decode($token, new Key(self::secretKey(), 'HS256'));
            self::$jwt_data = $decoded;
            return $decoded->data;
        } catch (\Firebase\JWT\ExpiredException $e) {
            error_log('Token expirado: ' . $e);
            echo json_encode(responseHTTP::status401("Token expirado"));
            exit;
        } catch (\Exception $e) {
            error_log('Token inválido: ' . $e);
            echo json_encode(responseHTTP::status401("Token inválido"));
            exit;
        }
    }

    public static function getDataJwt() {
        $jwt_decoded_array = json_decode(json_encode(self::$jwt_data), true);
        return $jwt_decoded_array['data'] ?? [];
    }
}
