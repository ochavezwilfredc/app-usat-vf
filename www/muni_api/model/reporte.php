<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 01/12/19
 * Time: 08:02 PM
 */
require_once '../datos/conexion.php';
class reporte extends conexion
{


    public function ventas_por_producto($residuo_id, $fecha_inicio, $fecha_fin){
        try {

            $sql = "select
                     r.id, r.nombre, SUM(d.cantidad) as peso_total , d.precio, SUM(d.sub_total) as sub_total
                    from detalle d inner join residuo r on d.residuo_id = r.id
                    inner join venta v on d.venta_id = v.id
                    where (case when 0 = :p_residuo_id then true else r.id = :p_residuo_id end)
                     and v.fecha_registro between :p_fecha_inicio and :p_fecha_fin
                    group by r.id, r.nombre, d.precio ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_residuo_id", $residuo_id);
            $sentencia->bindParam(":p_fecha_inicio", $fecha_inicio);
            $sentencia->bindParam(":p_fecha_fin", $fecha_fin);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function criterios_prioridad_reciclador(){
        try {

            $sql = "select pc.persona_id,
                   (p.ap_paterno||' '|| p.ap_materno ||' '|| p.nombres) as reciclador,
                   SUM(case when pc.criterio_id=1 then pc.valor end) * 100 as criterio1,
                   SUM(case when pc.criterio_id=2 then pc.valor end) * 100 as criterio2,
                   SUM(case when pc.criterio_id=3 then pc.valor end) * 100 as criterio3,
                   SUM(case when pc.criterio_id=4 then pc.valor end) * 100 as criterio4,
                   p.valor * 100 as prioridad
                    from persona_criterio pc inner join persona p on pc.persona_id = p.id
                    group by persona_id,p.ap_paterno||' '|| p.ap_materno ||' '|| p.nombres,p.valor
                    order by p.valor desc ;
                    ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function recoleccion_por_zona($anio1, $anio2, $zona_id){
        try {

            $sql = "select extract(year from v.fecha_registro) as anio,
                           SUM(case when (extract(month from v.fecha_registro)) = 1  then (d.cantidad) else 0 end) as enero,
                           SUM(case when (extract(month from v.fecha_registro)) = 2  then (d.cantidad) else 0 end) as febrero,
                           SUM(case when (extract(month from v.fecha_registro)) = 3  then (d.cantidad) else 0 end) as marzo,
                           SUM(case when (extract(month from v.fecha_registro)) = 4  then (d.cantidad) else 0 end) as abril,
                           SUM(case when (extract(month from v.fecha_registro)) = 5  then (d.cantidad) else 0 end) as mayo,
                           SUM(case when (extract(month from v.fecha_registro)) = 6  then (d.cantidad) else 0 end) as junio,
                           SUM(case when (extract(month from v.fecha_registro)) = 7  then (d.cantidad) else 0 end) as julio,
                           SUM(case when (extract(month from v.fecha_registro)) = 8  then (d.cantidad) else 0 end) as agosto,
                           SUM(case when (extract(month from v.fecha_registro)) = 9  then (d.cantidad) else 0 end) as setiembre,
                           SUM(case when (extract(month from v.fecha_registro)) = 10  then (d.cantidad) else 0 end) as octubre,
                           SUM(case when (extract(month from v.fecha_registro)) = 11  then d.cantidad else 0 end) as noviembre,
                           SUM(case when (extract(month from v.fecha_registro)) = 12  then d.cantidad else 0 end) as diciembre
                    from venta v
                           inner join detalle d on d.venta_id =v.id
                           inner join persona p on v.reciclador_id = p.id
                    where v.estado = 'Vendido'
                      and (extract(year from v.fecha_registro) BETWEEN :p_anio1 and :p_anio2)
                      and p.zona_id = :p_zona_id
                    GROUP BY  extract(year from v.fecha_registro)                    ;
                                        ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_anio1", $anio1);
            $sentencia->bindParam(":p_anio2", $anio2);
            $sentencia->bindParam(":p_zona_id", $zona_id);

            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function list_proveedores_reciclador($reciclador_id, $fecha_inicio, $fecha_fin){
        try {

            $sql = "select  (p.ap_paterno ||' '|| p.ap_materno ||' '|| p.nombres) as proveedor,
                      p.dni as proveedor_dni, count(p.dni) as total_servicios
                        from  servicio s inner join persona p on s.proveedor_id = p.id
                        inner join persona r on s.reciclador_id = r.id
                    where s.reciclador_id = :p_reciclador_id and 
                          s.fecha between :p_fecha_inicio and :p_fecha_fin
                          group by  p.ap_paterno ||' '|| p.ap_materno ||' '|| p.nombres,p.dni ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_reciclador_id", $reciclador_id);
            $sentencia->bindParam(":p_fecha_inicio", $fecha_inicio);
            $sentencia->bindParam(":p_fecha_fin", $fecha_fin);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;

        } catch (Exception $ex) {
            throw $ex;
        }
    }


}