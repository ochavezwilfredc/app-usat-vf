<?php

header('Access-Control-Allow-Origin: *');

//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
//header("Allow: GET, POST, OPTIONS, PUT, DELETE");


require_once '../model/usuario.php';
require_once '../util/funciones/Funciones.clase.php';

$rol = json_decode(file_get_contents("php://input")) -> p_rol;
$dni = json_decode(file_get_contents("php://input")) -> p_dni;
$clave = json_decode(file_get_contents("php://input")) -> p_clave;

//Funciones::imprimeJSON(200, "Bienvenido a la aplicacion", $clave);
if ($dni === ""){
    Funciones::imprimeJSON(500, "Falta completar los datos requeridos", "");
    exit();
}
//$var= json_decode($_POST["p_dni"]);
//$dni = $_POST["p_dni"];
//$request = $_REQUEST["p_dni"];

//$clave = $_POST["p_clave"];

try {
    //Funciones::imprimeJSON(200, "Bienvenido a la aplicacion", $request);
    $objSesion = new usuario();
    $objSesion->setRol($rol);
    $objSesion->setDni($dni);
    $objSesion->setCodigo($dni);
    $objSesion->setClave($clave);
    $resultado = $objSesion->auth();

    if ($resultado["estado"] == 'A') {
        //unset($resultado["estado"]);

        /*Generar un token de seguridad*/
        require_once 'tokengenerar.php';
        $token = generarToken(null,3600);
        $resultado["token"] = $token;
        /*Generar un token de seguridad*/

        Funciones::imprimeJSON(200, "Bienvenido a la aplicacion", $resultado);
    } else {
        Funciones::imprimeJSON(500, "No esta Activo", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}