<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
// ---------------------------------

use App\Config\responseHTTP;

if (isset($_GET['route']) && !empty(trim($_GET['route']))) {
    $url = explode('/', trim($_GET['route']));
    $modulo = $url[0];

    $lista = ['auth', 'user', 'taller', 'inscripcion', 'asistencia', 'calificacion', 'notificacion', 'horario', 'dashboard', 'report'];

    if (!in_array($modulo, $lista)) {
        echo json_encode(responseHTTP::status400('Ruta no válida'));
        error_log("Ruta no válida: $modulo");
        exit;
    }

    $file = dirname(__DIR__) . '/src/routes/' . $modulo . '.php';

    if (file_exists($file) && is_readable($file)) {
        include_once $file;
    } else {
        echo json_encode(responseHTTP::status404('El archivo de ruta no existe o no es legible!'));
        http_response_code(404);
        exit;
    }

} else {
    header('Content-Type: application/json');
    echo json_encode(responseHTTP::status400('No se ha proporcionado la variable route o esta vacia'));
    http_response_code(400);
    exit;
}

