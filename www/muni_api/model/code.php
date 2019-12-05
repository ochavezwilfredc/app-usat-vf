<?php

require_once '../datos/conexion.php';
class code extends conexion
{

    public function ultimo()
    {
        $sql = "select * from code  order by id desc limit 1";
        $sentencia = $this->dblink->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function search_code($code){
        try {

            $sql = "select * from code where numero = :p_code ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_code", $code);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            if ($sentencia->rowCount()) {
                return true;
            }else{
                return false;
            }
        }catch (Exception $ex){
            throw $ex;
        }


    }

}