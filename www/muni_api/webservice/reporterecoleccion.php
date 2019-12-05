<?php
header('Access-Control-Allow-Origin: *');

require_once '../model/reporte.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';

if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}
$token = $_SERVER["HTTP_TOKEN"];

$zona_id = json_decode(file_get_contents("php://input"))->zona_id;
$anio_inicial= json_decode(file_get_contents("php://input"))->anio_inicial;
$anio_final = json_decode(file_get_contents("php://input"))->anio_final;

$objeto = new reporte();

$res = $objeto->recoleccion_por_zona($anio_inicial, $anio_final, $zona_id);
if ($res) {
    Funciones::imprimeJSON(200, "Consulta exitosa", $res);
} else {
    Funciones::imprimeJSON(203, "No hubo resutados en la busqueda.", $res);
}
