<?php

require_once '../datos/conexion.php';

class persona extends conexion
{

    private $id;
    private $dni;
    private $ap_paterno;
    private $ap_materno;
    private $nombres;
    private $sexo;
    private $fn;
    private $celular;
    private $direccion;
    private $correo;
    private $estado;
    private $zona_id;
    private $rol_id;
    private $codigo;
    private $fecha_registro;

    private $status;

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return mixed
     */
    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }

    /**
     * @param mixed $fecha_registro
     */
    public function setFechaRegistro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
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
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param mixed $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    /**
     * @return mixed
     */
    public function getApPaterno()
    {
        return $this->ap_paterno;
    }

    /**
     * @param mixed $ap_paterno
     */
    public function setApPaterno($ap_paterno)
    {
        $this->ap_paterno = $ap_paterno;
    }

    /**
     * @return mixed
     */
    public function getApMaterno()
    {
        return $this->ap_materno;
    }

    /**
     * @param mixed $ap_materno
     */
    public function setApMaterno($ap_materno)
    {
        $this->ap_materno = $ap_materno;
    }

    /**
     * @return mixed
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param mixed $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * @return mixed
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param mixed $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * @return mixed
     */
    public function getFn()
    {
        return $this->fn;
    }

    /**
     * @param mixed $fn
     */
    public function setFn($fn)
    {
        $this->fn = $fn;
    }

    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
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
    public function getZonaId()
    {
        return $this->zona_id;
    }

    /**
     * @param mixed $zona_id
     */
    public function setZonaId($zona_id)
    {
        $this->zona_id = $zona_id;
    }

    /**
     * @return mixed
     */
    public function getRolId()
    {
        return $this->rol_id;
    }

    /**
     * @param mixed $rol_id
     */
    public function setRolId($rol_id)
    {
        $this->rol_id = $rol_id;
    }


    public function create()
    {

        try {

            if ($this->rol_id == 2) {
                $sql = "select secuencia from correlativo where tabla = 'persona_reciclador' ";
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
                $numeracion = "RC-" . $correlativo;
                $this->setCodigo($numeracion);
            } else {
                $this->setCodigo(null);
            }

            $sql = "insert into persona (dni,nombres,ap_paterno,ap_materno,sexo,fecha_nac,celular,direccion,
                      correo,estado,zona_id,rol_id,codigo,fecha_registro)
                    values (:p_dni, :p_nombres ,:p_ap_paterno, :p_ap_materno, :p_sexo, :p_fn, :p_celular, :p_direccion,
                    :p_correo,:p_estado,:p_zona, :p_rol, :p_codigo, :p_fecha_registro); ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_dni", $this->dni);
            $sentencia->bindParam(":p_nombres", $this->nombres);
            $sentencia->bindParam(":p_ap_paterno", $this->ap_paterno);
            $sentencia->bindParam(":p_ap_materno", $this->ap_materno);
            $sentencia->bindParam(":p_sexo", $this->sexo);
            $sentencia->bindParam(":p_fn", $this->fn);
            $sentencia->bindParam(":p_celular", $this->celular);
            $sentencia->bindParam(":p_direccion", $this->direccion);
            $sentencia->bindParam(":p_correo", $this->correo);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->bindParam(":p_zona", $this->zona_id);
            $sentencia->bindParam(":p_rol", $this->rol_id);
            $sentencia->bindParam(":p_codigo", $this->codigo);
            $sentencia->bindParam(":p_fecha_registro", $this->fecha_registro);
            $sentencia->execute();

            if ($this->rol_id == 2) {
                $this->dblink->beginTransaction();

                $sql = "update correlativo set secuencia = :p_secuencia where tabla = 'persona_reciclador' ";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_secuencia", $secuencia);
                $sentencia->execute();
                $this->dblink->commit();
            }
            return True;

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function read()
    {

        try {
            $sql = "select * from persona where id = :p_persona_id";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_persona_id", $this->id);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function update(){
        $this->dblink->beginTransaction();

        try {

            $sql = "update persona set 
                    dni = :p_dni,
                    nombres = :p_nombres,
                    ap_materno = :p_mateno,
                    ap_paterno = :p_paterno,
                    sexo = :p_sexo,
                    fecha_nac = :p_fc,
                    celular = :p_celular,
                    direccion = :p_direccion,
                    correo = :p_correo,
                    estado = :p_estado,
                    zona_id = :p_zona                                        
                    where id = :p_persona_id ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_dni", $this->dni);
            $sentencia->bindParam(":p_nombres", $this->nombres);
            $sentencia->bindParam(":p_mateno", $this->ap_materno);
            $sentencia->bindParam(":p_paterno", $this->ap_paterno);
            $sentencia->bindParam(":p_sexo", $this->sexo);
            $sentencia->bindParam(":p_fc", $this->fn);
            $sentencia->bindParam(":p_celular", $this->celular);
            $sentencia->bindParam(":p_direccion", $this->direccion);
            $sentencia->bindParam(":p_correo", $this->correo);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->bindParam(":p_zona", $this->zona_id);
            $sentencia->bindParam(":p_persona_id", $this->id);

            $sentencia->execute();
            $this->dblink->commit();
            return true;

        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }

    public function reciclador_lista()
    {

        try {
            $sql = "select p.*, z.nombre as zona from persona p inner join zona z on p.zona_id = z.id where p.rol_id = 2 ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function proveedor_lista()
    {

        try {
            $sql = "select p.*, z.nombre as zona from persona p inner join zona z on p.zona_id = z.id where p.rol_id = 3 ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $ex) {
            throw $ex;
        }
    }



}