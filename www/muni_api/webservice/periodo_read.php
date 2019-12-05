<?php

try {
    require_once '../model/periodo.php';
    require_once '../util/funciones/Funciones.clase.php';
    require_once 'tokenvalidar.php';

    if (!isset($_SERVER["HTTP_TOKEN"])) {
        Funciones::imprimeJSON(500, "Debe especificar un token", "");
        exit();
    }
    $token = $_SERVER["HTTP_TOKEN"];
    $id = json_decode(file_get_contents("php://input"))->p_id;

    $objPeriodo = new periodo();
    $resultado = $objPeriodo->read($id);

    Funciones::imprimeJSON(200, "", $resultado);

} catch (Exception $exc) {
    Helper::imprimeJSON(500, $exc->getMessage(), "");
}

