<?php

namespace App\Controllers;
use App\Config\responseHTTP;
use App\Config\Security;
use App\Models\userModel;
class userController{
    private $method;
    private $route;
    private $params;
    private $data;
    private $headers; 
    private static $validar_rol = '/^[1-4]{1}$/'; //validamos rol (1=Padre, 2=Estudiante, 3=Instructor, 4=Admin)
    private static $validar_numero = '/^[0-9]+$/'; //validamos numeros (0-9)
    private static $validar_texto = '/^[a-zA-Z]+$/'; //validamos texto (a-z y A-Z)

    public function __construct($method,$route,$params,$data,$headers){        
        $this->method = $method;        
        $this->route = $route;
        $this->params = $params;
        $this->data = $data;
        $this->headers = $headers;            
    }
        //metodo que recibe un endpoint (ruta a un recurso) para poder registrarlo en la BD
    final public function post($endpoint){
        //validamos method y endpoint 
        if($this->method == 'post' && $endpoint == $this->route){    
            //linea que agregamos para proteger la petición post (se explica en la actualizacion de registros)
            //validamos JWT, enviando header y clave secreta
            //AHORA ESTA COMENTADA PARA PROCEDER CON EL EJEMPLO DE REGISTRO
            //Security::validateTokenJwt($this->headers, Security::secretKey());
            
            //validamos que los campos no vengan vacios
            if (empty($this->data['nombre']) || empty($this->data['dni']) || empty($this->data['email']) || 
              empty($this->data['rol']) || empty($this->data['clave']) || empty($this->data['confirmaClave'])) {
                echo json_encode(responseHTTP::status400('Todos los campos son requeridos, proceda a llenarlos.'));
                //validamos que los campos de texto sean de texto mediante preg_match evaluamos expresiones regulares
            } else if (!preg_match(self::$validar_texto, $this->data['nombre'])) {
                echo json_encode(responseHTTP::status400('En el campo nombre debe ingresar solo texto.'));
                //validamos que los campos numericos sean contengan solo numeros mediante preg_match evaluamos expresiones regulares
            } else if (!preg_match(self::$validar_numero,$this->data['dni'])) {
                echo json_encode(responseHTTP::status400('En el campo dni debe ingresar solo numeros.'));
                //validamos que el correo tenga el formato correcto 
                //filter_var permite crear un filtro especifico y luego validar a partir de este
            }  else if (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(responseHTTP::status400('El correo debe tener el formato correcto.'));
                //validamos el rol 
            }else if (!preg_match(self::$validar_rol,$this->data['rol'])) {
                echo json_encode(responseHTTP::status400('El rol es invalido'));
            } else {
                new userModel($this->data);
                echo json_encode(userModel::post());
            }
            exit;
        }

    }


    //metodo para logearse 
    final public function getLogin($endpoint){    
        //print_r($this->method);    
        //validamos method y endpoint(ruta a recurso)
        /*echo($this->method);*/
        //print_r($this->params);
        //echo($this->route);
        //echo($endpoint);
        if($this-> method == 'get' && $endpoint == $this->route){
            ///echo "ingresa";
            $email = strtolower($this->params[1]); //pasamos el email
            $pass = $this->params[2]; //pasamos la clave
            //algunas validaciones requeridas
            if(empty($email) || empty($pass)){
                echo json_encode(responseHTTP::status400('Todos los campos son requeridos, proceda a
                llenarlos.'));
            }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                echo json_encode(responseHTTP::status400('El correo debe tener el formato correcto.'));
            }else{
                //echo "llega";
                //pasamos los val al modelo que usaremos para hacer la peticion a la BD y llamamos al metodo Login
                userModel::setEmail($email);
                userModel::setClave($pass);
                echo json_encode(userModel::Login());
            }
            exit;  
        }
    }

    final public function getAll($endpoint){        
             //validamos method y endpoint 
        if($this->method == 'get' && $endpoint == $this->route){ 
            //validamos JWT, enviando header y clave secreta
            //Security::validateTokenJwt($this->headers, Security::secretKey());  
            echo json_encode(userModel::getAll());            
            exit;
        }
    }


     final public function getUser ($endpoint){        
             //validamos method y endpoint              
        if($this->method == 'get' && $endpoint == $this->route){     
             //echo "ss2";           
            //validamos JWT, enviando header y clave secreta
           // Security::validateTokenJwt($this->headers, Security::secretKey());  
            $dni = $this->params[1];
            if(!isset($dni)){
                echo json_encode(responseHTTP::status400('Debe ingresar el DNI para proceder!'));
            } else if(!preg_match(self::$validar_numero, $dni)){
                echo json_encode(responseHTTP::status400('El DNI debe contener solo numeros!'));
            }else{
                userModel::setDni($dni);
                echo json_encode(userModel::getUser());         
                exit;
            }            
        }
        //echo "ss";
    }
    
    //metodo para actualizar la contraseña (actualizar parcialmente un recurso PATCH)
    final public function patchPassword($endpoint){
        if($this->method == 'patch' && $endpoint == $this->route){                
            //validamos JWT, enviando header y clave secreta
            Security::validateTokenJwt($this->headers, Security::secretKey());  
            
            //validamos los campos necesarios
            if(empty($this->data['oldPassword']) || empty($this->data['newPassword']) || empty($this->data['confirmPassword'])){
                echo json_encode(responseHTTP::status400('Debe llenar todos los campos para proceder!'));
            //validamos la contraseña anterior (debe ser correcta)
            } elseif(!userModel::validateOldPassword($this->data['IDToken'], $this->data['oldPassword'])){
                echo json_encode(responseHTTP::status400('La contraseña anterior es incorrecta!'));
            //validamos que el DNI tenga solo numeros
            } else if(!preg_match(self::$validar_numero, $dni)){
                echo json_encode(responseHTTP::status400('El DNI debe contener solo numeros!'));
            }else{
                userModel::setDni($dni);
                echo json_encode(userModel::getUser());         
                exit;
            }            
        }
    }
} 
