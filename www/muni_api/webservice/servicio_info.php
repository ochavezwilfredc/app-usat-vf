<?php

header('Access-Control-Allow-Origin: *');

require_once '../model/servicio.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';
if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}
$servicio_id = json_decode(file_get_contents("php://input")) -> servicio_id;


try {
    $obj = new servicio();
    $obj->setId($servicio_id);
    $resultado = $obj->serv_atender();
    if($resultado){
        Funciones::imprimeJSON(200, "",$resultado);
    }else{
        Funciones::imprimeJSON(203, "No hay data",$resultado);
    }

} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}