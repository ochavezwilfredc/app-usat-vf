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

$residuo_id = json_decode(file_get_contents("php://input"))->residuo_id;
$fecha_inicial = json_decode(file_get_contents("php://input"))->fecha_inicial;
$fecha_final = json_decode(file_get_contents("php://input"))->fecha_final;

$objeto = new reporte();

$res = $objeto->ventas_por_producto($residuo_id, $fecha_inicial, $fecha_final);
if ($res) {
    Funciones::imprimeJSON(200, "Consulta exitosa", $res);
} else {
    Funciones::imprimeJSON(203, "No hubo resutados en la busqueda.", $res);
}
