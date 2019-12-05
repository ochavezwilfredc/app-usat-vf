<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 01/12/19
 * Time: 09:23 PM
 */

header('Access-Control-Allow-Origin: *');

require_once '../model/reporte.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';
require_once '../reportes/Help.php';

if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}
$token = $_SERVER["HTTP_TOKEN"];

$residuo_id = json_decode(file_get_contents("php://input"))->residuo_id;
$fecha_inicial = json_decode(file_get_contents("php://input"))->fecha_inicial;
$fecha_final = json_decode(file_get_contents("php://input"))->fecha_final;
$user_name = json_decode(file_get_contents("php://input"))->user_name;


$objeto = new reporte();

$res = $objeto->ventas_por_producto($residuo_id, $fecha_inicial, $fecha_final);
//if ($res) {
//    Funciones::imprimeJSON(200, "Consulta exitosa", $res);
//} else {
//    Funciones::imprimeJSON(203, "Error en la consulta", $res);
//}




$htmlDatos = '  
<table style="font-size:11px;width:100%">
    <thead>
         <tr style="background-color: #f9f9f9; height:25px;">
            <th style="color:#26B99A">#</th>
            <th style="color:#26B99A">Residuo</th>
            <th style="color:#26B99A">Peso</th>
            <th style="color:#26B99A">Precio</th>
            <th style="color:#26B99A">Sub Total</th>                
        </tr>
    </thead>
    <tbody >';
$num = 0;
for ($i=0; $i<count($res);$i++) {
    $num++;

    $htmlDatos .= '<tr>';
    $htmlDatos .= '<td>'. $num .'</td>';
    $htmlDatos .= '<td>'.$res[$i]["nombre"].'</td>';
    $htmlDatos .= '<td>'.$res[$i]["peso_total"].'</td>';
    $htmlDatos .= '<td>'.$res[$i]["precio"].'</td>';
    $htmlDatos .= '<td>'.$res[$i]["sub_total"].'</td>';
    $htmlDatos .='</tr>';
}
$htmlDatos .= '</tbody></table>';


$producto = "";
if($residuo_id > 0){
    $producto = $res[0]['nombre'];
}

//echo $htmlDatos;
$titulo = 'REPORTE VENTA POR PRODUCTOS';
$htmlReporte = Help::export_pdf(utf8_encode($htmlDatos), utf8_encode($user_name), utf8_encode($titulo) , utf8_encode($producto));
$result = Help::generarReporte($htmlReporte, 2, "reporte_ventas_producto");
