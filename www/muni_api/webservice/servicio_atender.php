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
$tiempo_aprox = json_decode(file_get_contents("php://input")) -> tiempo_aprox;



try {
    $obj = new servicio();

    date_default_timezone_set("America/Lima");
    $hora_respuesta = date('H:i:s');
    $estado = 'En Camino'; //2 - En camino


    $obj->setId($servicio_id);
    $obj->setEstado($estado);
    $obj->setHoraRespuesta($hora_respuesta);
    $obj->setTiempoAproximado($tiempo_aprox);


    $res = $obj->update_estado_hora();
    if($res==true){

        $resultado = $obj->serv_atender();

        if($resultado){
            Funciones::imprimeJSON(200, "",$resultado);
        }else{
            Funciones::imprimeJSON(203, "No hay data",$resultado);
        }
    }else{
        Funciones::imprimeJSON(203, "No actualizo estado",$resultado);
    }



} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}