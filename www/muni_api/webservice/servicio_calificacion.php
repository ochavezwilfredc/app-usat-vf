<?php

header('Access-Control-Allow-Origin: *');

require_once '../model/servicio.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';
if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

$servicio_id = json_decode(file_get_contents("php://input"))->servicio_id;
$calificacion = json_decode(file_get_contents("php://input"))->calificacion;

try {
    $obj = new servicio();

    $obj->setId($servicio_id);
    $obj->setCalificacion($calificacion);

    $res = $obj->update_calificacion();

    if ($res == true) {
        Funciones::imprimeJSON(200, "Se califico de forma correcta!", $res);

    } else {
        Funciones::imprimeJSON(203, "No actualizo estado", $res);
    }


} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}