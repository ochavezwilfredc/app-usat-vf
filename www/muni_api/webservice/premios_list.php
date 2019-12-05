<?php
header('Access-Control-Allow-Origin: *');

require_once '../model/premio.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';

if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}



try {
    $obj = new premio();
    $resultado = $obj->lista();

//    $lista = array();
//    for ($i = 0; $i < count($resultado); $i++) {
//        $datos = array(
//            "id" => $resultado[$i]["id"],
//            "nombre" => $resultado[$i]["nombre"],
//            "stock" => $resultado[$i]["stock"],
//            "pintrash" => $resultado[$i]["pintrash"],
//            "imagen" => base64_decode($resultado[$i]["imagen"])
//        );
//
//        $lista[$i] = $datos;
//    }

    if($resultado){
        Funciones::imprimeJSON(200, "",$resultado);
    }

} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}