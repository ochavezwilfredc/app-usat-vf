<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 10/11/19
 * Time: 12:47 PM
 */
header('Access-Control-Allow-Origin: *');

require_once '../model/servicio.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';

if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}
$token = $_SERVER["HTTP_TOKEN"];

$proveedor_id = json_decode(file_get_contents("php://input"))->proveedor_id;
$latitud = json_decode(file_get_contents("php://input"))->latitud;
$longitud = json_decode(file_get_contents("php://input"))->longitud;
$referencia = json_decode(file_get_contents("php://input"))->referencia;
//$imagen = pg_escape_bytea(file_get_contents("php://input"))->imagen;

$objeto = new servicio();

date_default_timezone_set("America/Lima");
$hora = date('H:i:s');
$fecha = date('Y-m-d');
$estado = 'Abierto';

$objeto->setProveedorId($proveedor_id);
$objeto->setFecha($fecha);
$objeto->setHora($hora);
$objeto->setLatitud($latitud);
$objeto->setLongitud($longitud);
$objeto->setReferencia($referencia);
$objeto->setEstado($estado);
//$objeto->setImagen($imagen);

$res = $objeto->create();
if ($res) {
    Funciones::imprimeJSON(200, "Se guardo el servicio", $res);
} else {
    Funciones::imprimeJSON(203, "Error al guardar", "");
}


