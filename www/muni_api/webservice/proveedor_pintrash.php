<?php

header('Access-Control-Allow-Origin: *');
require_once '../model/servicio.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';

if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

$proveedor_id = json_decode(file_get_contents("php://input"))->proveedor_id;


try {
    $obj = new servicio();
    $resultado = $obj->count_pintrash($proveedor_id);

    if($resultado == -2){
        Funciones::imprimeJSON(203, "No hay pintrash","");
    }else{
        Funciones::imprimeJSON(200, "Su puntuacion pintrash es",$resultado);
    }

} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

