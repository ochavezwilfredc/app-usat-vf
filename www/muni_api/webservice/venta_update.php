<?php

header('Access-Control-Allow-Origin: *');

require_once '../model/venta.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';


if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

$venta_id = json_decode(file_get_contents("php://input"))->venta_id;
$estado = json_decode(file_get_contents("php://input"))->estado;
$acopio_final_id = json_decode(file_get_contents("php://input"))->acopio_final_id;
$precio_total= json_decode(file_get_contents("php://input"))->precio_total;
$detalle = json_decode(file_get_contents("php://input"))->detalle;

try {
    $obj = new venta();

    $obj->setId($venta_id);
    $obj->setEstado($estado);
    $obj->setAcopioFinalId($acopio_final_id);
    $obj->setPrecioTotal($precio_total);
    $obj->setDetalle($detalle);

    $res = $obj->update();

    if($res){
        Funciones::imprimeJSON(200, "Se actualizo la venta y su detalle",$res);
    }else{
        Funciones::imprimeJSON(203, "No actualizo ",$res);
    }



} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


