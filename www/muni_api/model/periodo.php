<?php

require_once '../datos/conexion.php';

class periodo extends conexion
{
    private $id;
    private $fecha_inicio;
    private $fecha_fin;
    private $descripcion;
    private $estado;

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
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * @param mixed $fecha_inicio
     */
    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    /**
     * @return mixed
     */
    public function getFechaFin()
    {
        return $this->fecha_fin;
    }

    /**
     * @param mixed $fecha_fin
     */
    public function setFechaFin($fecha_fin)
    {
        $this->fecha_fin = $fecha_fin;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function list_periodos()
    {
        $sql = "SELECT * FROM periodo";
        $sentencia = $this->dblink->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function ultima_fecha()
    {
        $sql = "select (fecha_fin + interval '1 days') as fecha_fin from periodo order by id desc limit 1";
        $sentencia = $this->dblink->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetch();
        return $resultado;
    }

    public function evaluar()
    {
        try {
            $sql = "SELECT estado FROM periodo where 
            (fecha_inicio between :p_fecha_inicio and :p_fecha_fin) 
            or
            (fecha_fin between :p_fecha_inicio and :p_fecha_fin) ";

            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_fecha_inicio", $this->fecha_inicio);
            $sentencia->bindParam(":p_fecha_fin", $this->fecha_fin);
            $sentencia->execute();
            $resultado = $sentencia->fetch();

            if ($sentencia->rowCount()) {
                $state = $resultado["estado"];

                return -1;

            }
            else{
                if($this->estado == '1' or $this->estado == 1){
                    $sql = "SELECT estado FROM periodo where estado = 1";
                    $sentencia = $this->dblink->prepare($sql);
                    $sentencia->execute();
                    if ($sentencia->rowCount()) {
                        return 0;
                    }else{
                        $res = $this->create();
                        return $res;
                    }
                }else{
                    $res =$this->create();
                    return $res;
                }



            }


        } catch (Exception $ex){
            throw $ex;
        }
    }

    public function create(){
        try {

            if ($this->estado=='1' or $this->estado == 1){

                $sql = "INSERT INTO periodo (fecha_inicio, fecha_fin, estado, descripcion) 
                values (:p_fecha_inicio, :p_fecha_fin, :p_estado, :p_descripcion) ";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_fecha_inicio", $this->fecha_inicio);
                $sentencia->bindParam(":p_fecha_fin", $this->fecha_fin);
                $sentencia->bindParam(":p_estado", $this->estado);
                $sentencia->bindParam(":p_descripcion", $this->descripcion);
                $sentencia->execute();

                $sql = "SELECT id FROM periodo order by 1 desc limit 1";
                $sentencia2 = $this->dblink->prepare($sql);
                $sentencia2->execute();
                $resultado = $sentencia2->fetch();
                if ($sentencia2->rowCount()) {
                    $this->create_periodo_criterio($resultado['id']);
                    return true;;

                }
            }else{
                $sql = "INSERT INTO periodo (fecha_inicio, fecha_fin, estado, descripcion) 
                  values (:p_fecha_inicio, :p_fecha_fin, :p_estado, :p_descripcion) ";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_fecha_inicio", $this->fecha_inicio);
                $sentencia->bindParam(":p_fecha_fin", $this->fecha_fin);
                $sentencia->bindParam(":p_estado", $this->estado);
                $sentencia->bindParam(":p_descripcion", $this->descripcion);
                $sentencia->execute();

                return 1;
            }


        } catch (Exception $ex){
            throw $ex;
        }


    }

    public function update(){
        $this->dblink->beginTransaction();
        try{

            if($this->estado == 1 or $this->estado == '1'){
                $sql = "SELECT estado,id FROM periodo where estado = '1' ";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                $resultado = $sentencia->fetch();
                $id = $resultado['id'];

                if($id == $this->id){
                    $sql = "UPDATE periodo SET fecha_inicio= :p_fecha_inicio,fecha_fin = :p_fecha_fin,
                    descripcion =  :p_descripcion, estado = :p_estado WHERE id = :p_id";

                    $sentencia = $this->dblink->prepare($sql);
                    $sentencia->bindParam(":p_fecha_inicio", $this->fecha_inicio);
                    $sentencia->bindParam(":p_fecha_fin", $this->fecha_fin);
                    $sentencia->bindParam(":p_descripcion", $this->descripcion);
                    $sentencia->bindParam(":p_estado", $this->estado);
                    $sentencia->bindParam(":p_id", $this->id);
                    $sentencia->execute();

                    $this->dblink->commit();;

                    return 2;
                }else{
                    if ($sentencia->rowCount()) {
                        return -1;
                    }else{
                        $this->create_periodo_criterio($this->id);

                        $sql = "UPDATE periodo SET fecha_inicio= :p_fecha_inicio,fecha_fin = :p_fecha_fin,
                    descripcion =  :p_descripcion, estado = :p_estado WHERE id = :p_id";

                        $sentencia = $this->dblink->prepare($sql);
                        $sentencia->bindParam(":p_fecha_inicio", $this->fecha_inicio);
                        $sentencia->bindParam(":p_fecha_fin", $this->fecha_fin);
                        $sentencia->bindParam(":p_descripcion", $this->descripcion);
                        $sentencia->bindParam(":p_estado", $this->estado);
                        $sentencia->bindParam(":p_id", $this->id);
                        $sentencia->execute();

                        $this->dblink->commit();;

                        return 2;
                    }
                }
            }else{
                $sql = "UPDATE periodo SET fecha_inicio= :p_fecha_inicio,fecha_fin = :p_fecha_fin,
                    descripcion =  :p_descripcion, estado = :p_estado WHERE id = :p_id";

                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_fecha_inicio", $this->fecha_inicio);
                $sentencia->bindParam(":p_fecha_fin", $this->fecha_fin);
                $sentencia->bindParam(":p_descripcion", $this->descripcion);
                $sentencia->bindParam(":p_estado", $this->estado);
                $sentencia->bindParam(":p_id", $this->id);
                $sentencia->execute();

                $this->dblink->commit();

                return 2;

            }

        }catch (Exception $ex){
            $this->dblink->rollBack();
            throw $ex;
        }
    }

    public function create_periodo_criterio($periodo_id){
        try {

            $criterio_id=0;
            for($i = 0; $i < 4 ; $i++){
                $criterio_id = $criterio_id + 1;

                $sql = "INSERT INTO periodo_criterio (periodo_id, criterio_id) values (:p_periodo_id,:p_criterio_id)";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_periodo_id", $periodo_id);
                $sentencia->bindParam(":p_criterio_id", $criterio_id);
                $sentencia->execute();
            }

        }catch (Exception $ex){
            throw $ex;
        }


    }

    public function read($id)
    {
        $sql = "SELECT *,(CASE when  fecha_fin < current_date then -1 else 0 end) as vigencia
        FROM periodo WHERE id = " . $id ;
        $sentencia = $this->dblink->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetch();
        return $resultado;
    }

    public function vigencia(){
        $sql = "select
                p.estado, p.fecha_inicio, p.fecha_fin, pc.id
                ,(case when fecha_fin < current_date then -1 else 1 end) as vigente
                from periodo p left join periodo_criterio pc on p.id = pc.periodo_id
                --where p.estado = '1'
                group by p.estado, p.fecha_inicio, p.fecha_fin,pc.id;
                " ;
        $sentencia = $this->dblink->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($sentencia->rowCount()) {
            return $resultado;
        }else{
            return -1;
        }

    }


}