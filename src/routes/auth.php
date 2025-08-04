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