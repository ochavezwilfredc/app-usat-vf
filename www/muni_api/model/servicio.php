<?php

require_once '../datos/conexion.php';

class servicio extends conexion
{
    private $id;
    private $code;
    private $taa;
    private $tra;
    private $calificacion;
    private $estado;
    private $fecha;
    private $hora;
    private $proveedor_id;
    private $reciclador_id;
    private $latitud;
    private $longitud;
    private $referencia;
    private $hora_respuesta;
    private $hora_llegada;
    private $tiempo_aproximado;
    private $imagen;

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




    /**
     * @return mixed
     */
    public function getTiempoAproximado()
    {
        return $this->tiempo_aproximado;
    }

    /**
     * @param mixed $tiempo_aproximado
     */
    public function setTiempoAproximado($tiempo_aproximado)
    {
        $this->tiempo_aproximado = $tiempo_aproximado;
    }



    /**
     * @return mixed
     */
    public function getHoraRespuesta()
    {
        return $this->hora_respuesta;
    }

    /**
     * @param mixed $hora_respuesta
     */
    public function setHoraRespuesta($hora_respuesta)
    {
        $this->hora_respuesta = $hora_respuesta;
    }

    /**
     * @return mixed
     */
    public function getHoraLlegada()
    {
        return $this->hora_llegada;
    }

    /**
     * @param mixed $hora_llegada
     */
    public function setHoraLlegada($hora_llegada)
    {
        $this->hora_llegada = $hora_llegada;
    }



    /**
     * @return mixed
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * @param mixed $referencia
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;
    }


    /**
     * @return mixed
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * @param mixed $latitud
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;
    }

    /**
     * @return mixed
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * @param mixed $longitud
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;
    }


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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getTaa()
    {
        return $this->taa;
    }

    /**
     * @param mixed $tap
     */
    public function setTaa($taa)
    {
        $this->taa = $taa;
    }

    /**
     * @return mixed
     */
    public function getTra()
    {
        return $this->tra;
    }

    /**
     * @param mixed $tra
     */
    public function setTra($tra)
    {
        $this->tra = $tra;
    }

    /**
     * @return mixed
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * @param mixed $calificacion
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;
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

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @param mixed $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    /**
     * @return mixed
     */
    public function getProveedorId()
    {
        return $this->proveedor_id;
    }

    /**
     * @param mixed $proveedor_id
     */
    public function setProveedorId($proveedor_id)
    {
        $this->proveedor_id = $proveedor_id;
    }

    /**
     * @return mixed
     */
    public function getRecicladorId()
    {
        return $this->reciclador_id;
    }

    /**
     * @param mixed $reciclador_id
     */
    public function setRecicladorId($reciclador_id)
    {
        $this->reciclador_id = $reciclador_id;
    }


    public function create()
    {

        try {


            $sql = "select secuencia from correlativo where tabla = 'servicio' ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();

            $secuencia = $resultado["secuencia"];
            $secuencia = $secuencia + 1;
            if (strlen($secuencia) == 1) {
                $pad = 5;
            } else {
                if (strlen($secuencia) == 2) {
                    $pad = 4;
                } else {
                    if (strlen($secuencia) == 3) {
                        $pad = 3;
                    } else {
                        if (strlen($secuencia) == 4) {
                            $pad = 2;
                        } else {
                            if (strlen($secuencia) == 5) {
                                $pad = 1;
                            }
                        }
                    }
                }
            }
            $correlativo = str_pad($secuencia, $pad, "0", STR_PAD_LEFT);
            $numeracion = "SRV-" . $correlativo;
            $this->setCode($numeracion);


            $sql = "insert into servicio (code, estado, fecha, hora, 
                                          proveedor_id, latitud,longitud, referencia)
                    values (:p_code, :p_estado, :p_fecha, :p_hora, 
                                          :p_proveedor_id, :p_latitud, :p_longitud, :p_ref); ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_code", $this->code);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->bindParam(":p_fecha", $this->fecha);
            $sentencia->bindParam(":p_hora", $this->hora);
            $sentencia->bindParam(":p_proveedor_id", $this->proveedor_id);
            $sentencia->bindParam(":p_latitud", $this->latitud);
            $sentencia->bindParam(":p_longitud", $this->longitud);
            $sentencia->bindParam(":p_ref", $this->referencia);
//            $sentencia->bindParam(":p_imagen", $this->imagen);
            $sentencia->execute();

            //Asignamos los servicios a reciclador segun orden de prioridad

            $sql_s = "select p.id, p.valor,
                           (select name_status from status where reciclador_id = p.id
                           order by id desc limit 1) as name_status
                    from  persona p
                    where p.rol_id = 2
                    group by p.id,p.valor
                    having (select name_status from status where reciclador_id = p.id
                             order by id desc limit 1) = 'Disponible'
                    order by p.valor desc limit 1";
            $sentence = $this->dblink->prepare($sql_s);
            $sentence->execute();
            $result = $sentence->fetch(PDO::FETCH_ASSOC);
            //if(count($result)>0){
            if ($sentence->rowCount()) {
                $this->dblink->beginTransaction();
                $sql = "update servicio set reciclador_id = :p_reciclador where code = :p_code ";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_reciclador", $result['id']);
                $sentencia->bindParam(":p_code", $this->code);
                $sentencia->execute();
                $this->dblink->commit();


                date_default_timezone_set("America/Lima");
                $hora = date('H:i:s');
                $fecha = date('Y-m-d');
                $estado = 'Ocupado';

                $sql = "insert into status (fecha, hora, name_status, reciclador_id) 
                        values (:p_fecha,:p_hora,:p_estado,:p_reciclador)";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_fecha", $fecha);
                $sentencia->bindParam(":p_hora", $hora);
                $sentencia->bindParam(":p_estado", $estado);
                $sentencia->bindParam(":p_reciclador", $result['id']);
                $sentencia->execute();
            }


            $this->dblink->beginTransaction();
            $sql = "update correlativo set secuencia = :p_secuencia where tabla = 'servicio' ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_secuencia", $secuencia);
            $sentencia->execute();
            $this->dblink->commit();

            $sql = "select id from servicio order by id desc limit 1 ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

            if ($sentencia->rowCount()) {
                $servicio_id = $resultado['id'];

                $res = $this->position_create($servicio_id, $this->latitud, $this->longitud);
                if($res){
                    return $resultado;
                }
                else{
                    return $resultado;
                }
            }





        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function position_create($servicio_id, $latitud, $longitud){
        try {

            $sql = "insert into position (latitud, longitud, lat_actual, lon_actual, servicio_id)
                    values (:p_latitud, :p_longitud ,:p_latitud_actual, :p_longitud_actual,  :p_servicio_id); ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_latitud", $latitud);
            $sentencia->bindParam(":p_longitud", $latitud);
            $sentencia->bindParam(":p_latitud_actual", $latitud);
            $sentencia->bindParam(":p_longitud_actual", $longitud);
            $sentencia->bindParam(":p_servicio_id", $servicio_id);
            $sentencia->execute();
            return True;

        }catch (Exception $ex) {
            throw $ex;
        }
    }

    public function list_serv_prov()
    {

        try {
            $sql = "select
                    s.id, (p.ap_paterno ||' '|| p.ap_materno ||' '|| p.nombres) as proveedor,
                    s.fecha, s.hora, s.estado, s.tiempo_aprox_atencion
                    from
                    servicio s inner join persona p on s.proveedor_id = p.id
                    where s.estado = 'Abierto' and s.reciclador_id = :p_reciclador_id";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_reciclador_id", $this->reciclador_id);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function serv_atender()
    {

        try {

            $sql = "select  s.id, s.code, (p.ap_paterno ||' '|| p.ap_materno ||' '|| p.nombres) as proveedor,
                        (r.ap_paterno ||' '|| r.ap_materno ||' '|| r.nombres) as reciclador,
                        r.dni as reciclador_dni,
                        s.fecha, s.hora, s.estado, s.tiempo_aprox_atencion, latitud, longitud
                        from  servicio s inner join persona p on s.proveedor_id = p.id
                        left join persona r on s.reciclador_id = r.id
                    where s.id =  :p_serv_id ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_serv_id", $this->id);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;

        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function update_estado_hora()
    {
        $this->dblink->beginTransaction();

        try {

            $sql = "update servicio set estado = :p_estado , hora_respuesta = :p_hora_respuesta,
                    tiempo_aprox_atencion = :p_tiempo_aprox where id = :p_serv_id";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_serv_id", $this->id);
            $sentencia->bindParam(":p_hora_respuesta", $this->hora_respuesta);
            $sentencia->bindParam(":p_tiempo_aprox", $this->tiempo_aproximado);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }


    }
    public function update_estado_hora_llegada()
    {
        $this->dblink->beginTransaction();

        try {

            $sql = "update servicio set estado = :p_estado , hora_llegada = :p_hora_llegada  where id = :p_id";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_id", $this->id);
            $sentencia->bindParam(":p_hora_llegada", $this->hora_llegada);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }


    }

    public function update_estado()
    {
        $this->dblink->beginTransaction();

        try {

            $sql = "update servicio set estado = :p_estado where id = :p_id";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->bindParam(":p_id", $this->id);
            $sentencia->execute();
            $this->dblink->commit();

            return -1;

//            if($this->estado == 'Finalizado'){
//                $sql = "select proveedor_id from servicio
//                    where id = :p_id";
//                $sentencia = $this->dblink->prepare($sql);
//                $sentencia->bindParam(":p_id", $this->id);
//                $sentencia->execute();
//                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
//                if ($sentencia->rowCount()) {
//                    $proveedor_id = $resultado['proveedor_id'];
//                    $res = $this->count_pintrash($proveedor_id);
//                    if($res==-2){
//                        return -2 ;
//                    }else{
//                        return $res;
//                    }
//                }else{
//                    return -1;
//                }
//            }else{
//                return -1;
//            }

        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }


    }

    public function count_pintrash($proveedor_id)
    {
        try {
            $sql = "select count(*)/2 as pintrash from servicio
                    where proveedor_id = :p_proveedor_id
                    group by proveedor_id
                    having count(*)/2 > 0";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_proveedor_id", $proveedor_id);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            if ($sentencia->rowCount()) {
                return $resultado['pintrash'];
            }else{
                return -2;
            }

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function update_calificacion()
    {
        $this->dblink->beginTransaction();

        try {

            $sql = "update servicio set calificacion = :p_calificacion where id = :p_id";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_calificacion", $this->calificacion);
            $sentencia->bindParam(":p_id", $this->id);
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }


    }


}