<?php
    require dirname(__DIR__).'\vendor\autoload.php';
    use App\Config\errorlogs;
    use App\Config\responseHTTP;
    use App\DB\ConnectionDB;
    errorlogs::activa_error_logs(); //permite activar los errores
  
    if (isset($_GET['route']) && !empty(trim($_GET['route']))) {
    $url = explode('/', trim($_GET['route']));
    $lista = ['auth', 'user', 'taller', 'inscripcion', 'asistencia','calificacion', 
              'notificacion', 'horario', 'dashboard', 'report'];

    $modulo = $url[0];

    if (!in_array($modulo, $lista)) {
        echo json_encode(responseHTTP::status400('Ruta no válida'));
        error_log("Ruta no válida: $modulo");
        exit;
    }

    $file = dirname(__DIR__).'/src/routes/'.$modulo.'.php';
    if (!file_exists($file) || !is_readable($file)) {
        echo json_encode(responseHTTP::status404('El archivo no existe o no es legible!'));
        http_response_code(404);
        exit;
    } else {
        ob_start();
        include_once $file;
        ob_end_clean();
        exit;

    }

} else {
    header('Content-Type: application/json');
    echo json_encode(responseHTTP::status400('No se ha proporcionado la variable route o está vacía'));
    http_response_code(400);
    exit;
}
