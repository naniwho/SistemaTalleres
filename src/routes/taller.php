<?php

use App\Controllers\tallerController;
use App\Config\responseHTTP;

// Capturamos los datos de la solicitud HTTP
$method = strtolower($_SERVER['REQUEST_METHOD']); // Método HTTP (get, post, put, delete)
$route = $_GET['route']; // La ruta completa (ej. 'taller', 'taller/123')
$params = explode('/', $route); // Parámetros de la ruta (ej. ['taller', '123'])
$data = json_decode(file_get_contents("php://input"), true); // Datos enviados en el cuerpo de la solicitud (para POST, PUT, etc.)
$headers = getallheaders(); // Todas las cabeceras de la solicitud

// Instancia el tallerController, pasándole los datos de la solicitud
$app = new tallerController($method, $route, $params, $data, $headers);

// Usa un switch para manejar los diferentes métodos HTTP
switch ($method) {
    case 'post':
        // Llama al método post del controlador para crear un nuevo taller
        $app->post('taller');
        break;
    case 'get':
        // Llama al método get del controlador para obtener talleres (todos o por ID)
        $app->get('taller');
        break;
    case 'put':
        // Llama al método put del controlador para actualizar un taller
        $app->put('taller');
        break;
    case 'delete':
        // Llama al método delete del controlador para eliminar un taller
        $app->delete('taller');
        break;
    default:
        // Si el método HTTP no es soportado, devuelve un error 404
        echo json_encode(responseHTTP::status404('Método no permitido para esta ruta.'));
        break;
}

exit; 