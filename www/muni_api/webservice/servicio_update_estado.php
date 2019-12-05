<?php

header('Access-Control-Allow-Origin: *');

require_once '../model/servicio.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';


if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

$token = $_SERVER["HTTP_TOKEN"];

$parametro = json_decode(file_get_contents("php://input"))->parametro;
$id = json_decode(file_get_contents("php://input"))->id;

if ($parametro == '3' or $parametro == 3) {
    $estado = 'En Atencion';
    date_default_timezone_set("America/Lima");
    $hora_llegada = date('H:i:s');

} else {
    if ($parametro == '4' or $parametro == 4) {
        $estado = 'Finalizado';
    } else {
        if ($parametro == '5' or $parametro == 5) {
            $estado = 'Cancelado';
        }
    }
}
try {
    $obj = new servicio();

    $obj->setEstado($estado);
    $obj->setId($id);

    if ($parametro == '3' or $parametro == 3) {
        $obj->setHoraLlegada($hora_llegada);
        $res = $obj->update_estado_hora_llegada();
    }else{
        $res = $obj->update_estado();
    }

    if($res==-1){
        Funciones::imprimeJSON(200, "Se actualizo estado",$res);
    }
    else{
        if($res == -2){
            Funciones::imprimeJSON(203, "No actualizo estado",$res);

        }else{
            Funciones::imprimeJSON(200, "Estado actualizado, acumulo pintrash",$res);

        }
    }

    if($res){
        Funciones::imprimeJSON(200, "Se actualizo estado",$res);
    }else{
        Funciones::imprimeJSON(203, "No actualizo estado",$res);
    }



} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


