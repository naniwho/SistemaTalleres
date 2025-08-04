<?php

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (is_array($data) && isset($data['correo'])) {
    $response = [
        'status' => 'ÉXITO',
        'message' => '¡Finalmente! Se recibieron los datos correctamente.',
        'correo_recibido' => $data['correo']
    ];
    echo json_encode($response);
} else {
    $response = [
        'status' => 'ERROR',
        'message' => 'Incluso con el código simple, no se pudieron leer los datos.',
        'datos_recibidos' => $data // Muestra qué se recibió
    ];
    echo json_encode($response);
}
use App\Controllers\AuthController;
use App\Config\responseHTTP;

require '../vendor/autoload.php';

$method = strtolower($_SERVER['REQUEST_METHOD']);
$headers = getallheaders();
$route = $_GET['route'] ?? '';
$params = explode('/', $route);

$authController = new AuthController();

if ($params[0] === 'auth' && $method === 'post') {
    // Asumiendo que envías login con POST y JSON en el body
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['correo']) || !isset($data['contraseña'])) {
        echo json_encode(responseHTTP::status400('Faltan campos.'));
        exit;
    }
    echo json_encode($authController->login($data));
    exit;
} else {
    echo json_encode(responseHTTP::status400('Ruta no válida'));
    exit;

}