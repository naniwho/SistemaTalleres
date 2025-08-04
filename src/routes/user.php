<?php
use App\Controllers\UserController;
use App\Config\responseHTTP;

$method  = strtolower($_SERVER['REQUEST_METHOD']);
$route   = $_GET['route'] ?? '';
$params  = explode('/', $route);
$data    = json_decode(file_get_contents("php://input"), true);
$headers = getallheaders();

$userController = new UserController($method, $route, $params, $data, $headers);

switch ($method) {
    case 'post':
        $userController->post('user');
        break;

    case 'get':
        $userController->get('user');
        break;

    case 'put':
        $userController->put('user');
        break;

    case 'delete':
        $userController->delete('user');
        break;

    default:
        echo json_encode(responseHTTP::status404('Método no permitido.'));
        break;
}
