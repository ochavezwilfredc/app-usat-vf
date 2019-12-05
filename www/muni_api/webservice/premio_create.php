<?php


header('Access-Control-Allow-Origin: *');

require_once '../model/premio.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'tokenvalidar.php';

if (!isset($_SERVER["HTTP_TOKEN"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}
$token = $_SERVER["HTTP_TOKEN"];


$operation= json_decode(file_get_contents("php://input"))->operation;
if($operation!='Nuevo'){
    $id = json_decode(file_get_contents("php://input"))->id;

}

$nombre = json_decode(file_get_contents("php://input"))->nombre;
$stock= json_decode(file_get_contents("php://input"))->stock;
$precio = json_decode(file_get_contents("php://input"))->precio;
$pintrash = json_decode(file_get_contents("php://input"))->pintrash;
$foto_name = json_decode(file_get_contents("php://input"))->imagen;
//$cargarimagen=$_FILES['imagen'];



//$path = "/www/muni_web/imagenes/imagenespremios/";
$path = "/www/muni_web/imagenes/imagenespremios/";

//$cargarimagen=($foto['name']);

//$fotito = $path.''.$foto;
//$type = pathinfo($foto, PATHINFO_EXTENSION);
//$data = file_get_contents($cargarimagen);
//$base64 = base64_encode($fotito);




try {

    if ($operation == 'Nuevo') {

        $objp = new premio();
        $objp->setNombre($nombre);
        $objp->setStock($stock);
        $objp->setPrecio($precio);
        $objp->setPintrash($pintrash);
        $objp->setImagen($foto_name);

        //Funciones::imprimeJSON(200, "Agregado Correcto", $foto_name);


        $result = $objp->create();
        if ($result) {
            Funciones::imprimeJSON(200, "Agregado Correcto", $result);
        } else {
            Funciones::imprimeJSON(203, "Error al momento de agregar", "");
        }


    } else {

        $objp = new premio();
        $objp->setNombre($nombre);
        $objp->setStock($stock);
        $objp->setPrecio($precio);
        $objp->setPintrash($pintrash);
        $objp->setImagen($foto_name);
        $objp->setId($id);

        $result = $objp->update();
        if ($result) {
            Funciones::imprimeJSON(200, "Actualizado de manera correcta", $result);
        } else {
            Funciones::imprimeJSON(203, "Error al momento de actualizar", "");
        }
    }


} catch (Exception $exc) {

    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}