<?php


require_once '../datos/conexion.php';

class fila extends conexion
{

    private $codigo;
    private $criterio_id;
    private $valor;

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
    public function getCriterioId()
    {
        return $this->criterio_id;
    }

    /**
     * @param mixed $criterio_id
     */
    public function setCriterioId($criterio_id)
    {
        $this->criterio_id = $criterio_id;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }


    public function create()
    {
        $this->dblink->beginTransaction();

        try {
            $sql = "select codigo , criterio_id, valor from fila where codigo = :p_codigo and criterio_id = :p_criterioid";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo", $this->codigo);
            $sentencia->bindParam(":p_criterioid", $this->criterio_id);
            $sentencia->execute();
            $resultado = $sentencia->fetch();

            if ($sentencia->rowCount()) {
                $sql = "update fila  set valor = :p_valor where codigo = :p_codigo and criterio_id= :p_criterioid";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_valor", $this->valor);
                $sentencia->bindParam(":p_criterioid", $this->criterio_id);
                $sentencia->bindParam(":p_codigo", $this->codigo);
                $sentencia->execute();
                //}
            } else {
                $sql = "insert into fila(codigo, criterio_id, valor) values(:p_codigo, :p_criterioid, :p_valor)";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_codigo", $this->codigo);
                $sentencia->bindParam(":p_criterioid", $this->criterio_id);
                $sentencia->bindParam(":p_valor", $this->valor);
                $sentencia->execute();
            }
            $this->dblink->commit();
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }


    }
}