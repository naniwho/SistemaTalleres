<?php

use App\Controllers\userController;
use App\Config\responseHTTP;

$method = strtolower($_SERVER['REQUEST_METHOD']); // capturamos el método HTTP
$route = $_GET['route']; // capturamos la ruta
$params = explode('/', $route); // ejemplo: auth/prueba@correo.com/12345abc
$data = json_decode(file_get_contents("php://input"), true);
$headers = getallheaders();

$app = new userController($method, $route, $params, $data, $headers);
$app->getLogin("auth/{$params[1]}/{$params[2]}/");
if ($method === 'get' && count($params) === 3 && $params[0] === 'auth') {
    $app->getLogin('auth');
} else {
    echo json_encode(responseHTTP::status404());}
