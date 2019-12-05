<?php


try {
    require_once '../model/code.php';
    require_once '../util/funciones/Funciones.clase.php';
    require_once 'tokenvalidar.php';

    if (!isset($_SERVER["HTTP_TOKEN"])) {
        Funciones::imprimeJSON(500, "Debe especificar un token", "");
        exit();
    }
    $token = $_SERVER["HTTP_TOKEN"];
    $code = json_decode(file_get_contents("php://input"))->p_code;

    $obj = new code();
    $resultado = $obj->search_code($code);
    if($resultado){
        Funciones::imprimeJSON(200, "El código ha sido validado","");
    }else{
        Funciones::imprimeJSON(203, "Código incorrecto!", "");
    }



} catch (Exception $exc) {
    Helper::imprimeJSON(500, $exc->getMessage(), "");
}