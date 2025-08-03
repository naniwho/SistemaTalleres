<?php

use App\Controllers\TallerController;
use App\Config\ResponseHttp;

$method  = strtolower($_SERVER['REQUEST_METHOD']);
$route   = $_GET['route'] ?? '';
$params  = explode('/', $route);
$data    = json_decode(file_get_contents("php://input"), true) ?? [];
$headers = getallheaders();

try {
    $app = new TallerController($params, $data, $headers);

    switch ($method) {
        case 'get':
            $app->get();
            break;
        case 'post':
            $app->post();
            break;
        case 'put':
            $app->put();
            break;
        case 'delete':
            $app->delete();
            break;
        default:
            echo json_encode(ResponseHttp::status405('Método no permitido'));
    }
} catch (Throwable $e) {
    echo json_encode(ResponseHttp::status500($e->getMessage()));
}
exit;
