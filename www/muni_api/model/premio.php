<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/12/19
 * Time: 08:37 AM
 */
require_once '../datos/conexion.php';

class premio extends conexion
{

    private $id;
    private $nombre;
    private $stock;
    private $precio;
    private $pintrash;
    private $imagen;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getPintrash()
    {
        return $this->pintrash;
    }

    /**
     * @param mixed $pintrash
     */
    public function setPintrash($pintrash)
    {
        $this->pintrash = $pintrash;
    }

    /**
     * @return mixed
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }


    public function lista()
    {
        try {

//            $sql = "SELECT id,nombre,stock,precio,pintrash from premio";
            $sql = "SELECT * from premio";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;

        } catch (Exception $ex) {
            throw $ex;
        }


    }

    public function create()
    {
        try {


            $sql = "INSERT INTO premio (nombre, stock, precio, pintrash, imagen) 
                  values (:p_nombre, :p_stock, :p_precio, :p_pintrash, :p_imagen) ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_nombre", $this->nombre);
            $sentencia->bindParam(":p_stock", $this->stock);
            $sentencia->bindParam(":p_precio", $this->precio);
            $sentencia->bindParam(":p_pintrash", $this->pintrash);
            $sentencia->bindParam(":p_imagen", $this->imagen);
            $sentencia->execute();

            return true;


        } catch (Exception $ex) {
            throw $ex;
        }


    }

    public function update()
    {

        try {

            $this->dblink->beginTransaction();
            $sql = "update premio set 
                    nombre = :p_nombre, 
                    stock = :p_stock, 
                    precio = :p_precio, 
                    pintrash = :p_pintrash,
                    imagen = :p_imagen
                    where id = :p_premio_id ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_nombre", $this->nombre);
            $sentencia->bindParam(":p_stock", $this->stock);
            $sentencia->bindParam(":p_precio", $this->precio);
            $sentencia->bindParam(":p_pintrash", $this->pintrash);
            $sentencia->bindParam(":p_imagen", $this->imagen);
            $sentencia->bindParam(":p_premio_id", $this->id);
            $sentencia->execute();
            $this->dblink->commit();

            return true;

        } catch (Exception $ex) {
            throw $ex;


        }
    }

    function read(){
        try {

            $sql = "SELECT * from premio where id = :p_id";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_id", $this->id);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

            return $resultado;

        } catch (Exception $ex) {
            throw $ex;
        }

    }


}