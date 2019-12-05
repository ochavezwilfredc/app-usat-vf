<?php


header('Access-Control-Allow-Origin: *');

require_once '../model/periodo.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';

if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}
$token = $_SERVER["HTTP_TOKEN"];
$periodo_id = json_decode(file_get_contents("php://input"))->p_periodo_id;
$fecha_inicio = json_decode(file_get_contents("php://input"))->p_fecha_inicio;
$fecha_fin = json_decode(file_get_contents("php://input"))->p_fecha_fin;
$descripcion= json_decode(file_get_contents("php://input"))->p_descripcion;
$estado = json_decode(file_get_contents("php://input"))->p_estado;
$operation = json_decode(file_get_contents("php://input"))->p_operacion;


try {
    $objPeriodo = new periodo();

    $objPeriodo->setId($periodo_id);
    $objPeriodo->setFechaInicio($fecha_inicio);
    $objPeriodo->setFechaFin($fecha_fin);
    $objPeriodo->setDescripcion($descripcion);
    $objPeriodo->setEstado($estado);

    $datetime1 = new DateTime($fecha_inicio);
    $datetime2 = new DateTime($fecha_fin);
    $interval = $datetime1->diff($datetime2);
    $dias = $interval->format('%R%a');

    date_default_timezone_set("America/Lima");
    $hoy = date('Y-m-d');
    $datetime3 = new DateTime($hoy);
    $interval = $datetime3->diff($datetime2);
    $dias2 = $interval->format('%R%a');

    if ($dias2 < 0 && $estado==1){
        Funciones::imprimeJSON(203, "Esta tratando de validar una fecha fuera de rango. ", "");

    }else{
        if ($dias < 0 ){
            Funciones::imprimeJSON(203, "La fecha de incio no puede ser menor o igual a la fecha de final ", "");

        } else{
            if ($operation == "nuevo") {
                $resultado = $objPeriodo->evaluar();
                if ($resultado == 1) {
                    Funciones::imprimeJSON(200, "Periodo agregado correctamente", "");
                }else{
                    if($resultado == -1){
                        Funciones::imprimeJSON(203, "Ya existe un periodo en estas fechas. ", "");
                    }else{
                        Funciones::imprimeJSON(203, "Ya hay una periodo activo. <br> Nota: Se recomienda modificar la última vigente.", $resultado);

                    }
                }
            } else { //Editar
                $resultado = $objPeriodo->update();
                if ($resultado==2) {
                    Funciones::imprimeJSON(200, "Periodo Actualizado correctamente", "");
                }else{
                    if ($resultado==-1) {
                        Funciones::imprimeJSON(203, "Ya hay una periodo activo. <br> Nota: Se recomienda modificar la última vigente.", $resultado);
                    }else{
                        Funciones::imprimeJSON(200, "Periodo Actualizado correctamente y validado.", "");

                    }

                }

            }
        }
    }


} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}