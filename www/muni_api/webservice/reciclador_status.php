<?php

header('Access-Control-Allow-Origin: *');

require_once '../model/persona_status.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';


if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

$token = $_SERVER["HTTP_TOKEN"];

$id = json_decode(file_get_contents("php://input"))->id;
$status = json_decode(file_get_contents("php://input"))->status;

if($status==1){
    $name_status = 'Disponible';
}
else{
    if($status==2){
        $name_status = 'No Disponible';
    }else{
        $name_status = 'Ocupado';
    }
}

date_default_timezone_set("America/Lima");
$hora = date('H:i:s');
$fecha = date('Y-m-d');

try {
    $obj = new persona_status();
    $obj->setNameStatus($name_status);
    $obj->setRecicladorId($id);
    $obj->setHora($hora);
    $obj->setFecha($fecha);
    $res = $obj->insert_disponibilidad($status);

    if($res == 1){
        Funciones::imprimeJSON(200, "Se asigno servicio a reciclador",$res);
    }else{
        if($res == 0){
            Funciones::imprimeJSON(203, "Actualizo disponibilidad, no hay servicios pendientes",$res);
        }else{
            Funciones::imprimeJSON(203, "Se actualizo disponibilidad, pero no asigno servicio",$res);

        }
    }

} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


