<?php

header('Access-Control-Allow-Origin: *');

require_once '../model/periodo.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';

if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}



try {
    $obj = new periodo();
    $resultado = $obj->list_periodos();

    if($resultado){
        Funciones::imprimeJSON(200, "",$resultado);
    }else{
        Funciones::imprimeJSON(203, "No hay periodos","");
    }

} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}