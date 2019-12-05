<?php
header('Access-Control-Allow-Origin: *');

require_once '../model/premio.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';

if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

$id = json_decode(file_get_contents("php://input"))->id;

try {
    $obj = new premio();
    $obj->setId($id);

    $resultado = $obj->read();

    if($resultado){
        Funciones::imprimeJSON(200, "",$resultado);
    }else{
        Funciones::imprimeJSON(203, "Error en la busqueda","");
    }

} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}