<?php

header('Access-Control-Allow-Origin: *');

require_once '../model/usuario.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';

if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}
$token = $_SERVER["HTTP_TOKEN"];
$user_id = json_decode(file_get_contents("php://input")) ->user_id;
$clave= json_decode(file_get_contents("php://input")) ->clave;

try {
//    if (validarToken($token)) {

    $obj = new usuario();
    $obj->setId($user_id);
    $obj->setClave($clave);


    $resultado = $obj->validar_password();
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);
    }else{
        Funciones::imprimeJSON(203, "", "");
    }
//    }
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}