<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");


require_once '../model/usuario.php';
require_once '../model/paciente.php';
require_once '../model/medico.php';
require_once '../model/enfermera.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';

if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}
$user_id = json_decode(file_get_contents("php://input"))->p_usuario_id;
$dni = json_decode(file_get_contents("php://input"))->p_documento;
$rol = json_decode(file_get_contents("php://input"))->p_tipo;
$clave = json_decode(file_get_contents("php://input"))->p_password;
$estado = json_decode(file_get_contents("php://input"))->p_estado;
$operation = json_decode(file_get_contents("php://input"))->p_operacion;

try {

    $objuser = new usuario();
    $objuser->setId($user_id);
    $objuser->setDni($dni);
    $objuser->setTipo($rol);
    $objuser->setClave($clave);
    $objuser->setEstado($estado);


    if ($operation == 'editar') {
        $res = $objuser->update();
        if ($res) {
            if ($rol == "1" || $rol == "2") {
                $object_med = new medico();
                $result = $object_med->update_user($dni, $estado, $user_id);
                if ($result) {
                    Funciones::imprimeJSON(200, "Se actualizo Correctamente", "");
                }
            }
            if ($rol == "3") {
                $object_enf = new enfermera();
                $result = $object_enf->update_user($dni, $estado, $user_id);
                if ($result) {
                    Funciones::imprimeJSON(200, "Se actualizo Correctamente", "");
                } else {
                    Funciones::imprimeJSON(203, "No se actualizo", "");
                }
            } else {
                if ($rol == '4') {
                    $object_pac = new paciente();
                    $result = $object_pac->update_user($dni, $estado, $user_id);
                    if ($result) {
                        Funciones::imprimeJSON(200, "Se actualizo Correctamente", "");

                    }
                }
            }
        } else {
            Funciones::imprimeJSON(203, "No se actualizo", "");
        }

    }
}
catch
    (Exception $exc) {

        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }