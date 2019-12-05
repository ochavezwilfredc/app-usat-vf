<?php

header('Access-Control-Allow-Origin: *');
require_once '../model/paciente.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';

if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}
$token = $_SERVER["HTTP_TOKEN"];
$dni_paciente = json_decode(file_get_contents("php://input")) ->dni_paciente;

try {
//    if (validarToken($token)) {

    $obj = new paciente();
    $obj->setDni($dni_paciente); 


    $resultado = $obj->validar_dni();
    if($resultado==1){
        Funciones::imprimeJSON(203, "El dni ya existe", "");
    }else{
        Funciones::imprimeJSON(200, "", "");
    }
//    }
} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}