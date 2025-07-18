<?php

use App\Controllers\userController;
use App\Config\responseHTTP;

$method = strtolower($_SERVER['REQUEST_METHOD']); //capturamos el método que se envía
$route = $_GET['route']; //capturamos la ruta
$params = explode('/', $route); //hacemos un explode de route ya que se nos envían user/email/clave tendríamos un array
$data = json_decode(file_get_contents("php://input"), true); //obtendremos la data que enviemos por cualquier método excepto el GET, array asociativo
$headers = getallheaders(); //capturando todas las cabeceras que nos envía

$app = new userController($method, $route, $params, $data, $headers); //instancia clase user controller

switch ($method) {
    case 'post':
        $app->post('user');
        break;
    case 'get':
        $app->getAll('user'); // o getLogin / getUser si es por login u otro parámetro
        break;
    case 'put':
        $app->put('user');
        break;
    case 'delete':
        $app->delete('user');
        break;
    case 'patch':
        $app->patchPassword('user'); // si quieres permitir cambio de clave
        break;
    default:
        echo json_encode(responseHTTP::status404());//imprimimos un error en caso de no encontrar la ruta
        break;
}