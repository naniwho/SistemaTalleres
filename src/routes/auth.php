<?php
use App\Config\Security;
echo json_encode(Security::secretKey());
echo json_encode(Security::createPassword("hola"));

$pass = Security::createPassword("hola");
if (Security::validatePassword("hola",$pass)){
    echo json_encode("Contraseña correcta");
} else {
    echo json_encode("Contraseña inorrecta");
}
 

echo (json_encode(Security::createTokenJwt(Security::secretKey(),["hola"])));

use App\DB\connectionDB;
connectionDB::getConnection();