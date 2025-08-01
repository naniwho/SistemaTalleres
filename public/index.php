<?php
    use App\Config\errorlogs;
    use App\Config\responseHTTP;
    require dirname(__DIR__).'\vendor\autoload.php';
    errorlogs::activa_error_logs(); //activamos los errors    
    if(isset($_GET['route'])){
        $url = explode('/',$_GET['route']);
        $lista = ['auth', 'user','taller']; // lista de rutas permitidas
        $file =  dirname(__DIR__).'/src/routes/'.$url[0].'.php';
        if(!in_array($url[0], $lista)){
            //echo "La ruta no existe";
            echo json_encode(responseHTTP::status400('ruta no valida'));
            error_log("Esto es una prueba de error...");
           //header(‘HTTP/1.1 404 Not Found’);
            exit; //finalizamos la ejecución
        }  
        
        //validamos que el archivo exista y que es legible
        if(!file_exists($file) || !is_readable($file)){
            //echo "El archivo no existe o no es legible";
            echo json_encode(responseHTTP::status200('El archivo no existe o no es legible!'));
            
        }else{
            require $file;
            exit;
        }

    }else{
        echo "no existe la variable route";
    }

?>