<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 24-11-2011
 */
class PracticaobrasocialDAO {

    public static function insertarPracticaobrasocial(Practicaobrasocial $oPracticaobrasocial) {
        $db = DbManager::getConnection();

        $cd_practicaobrasocial = $oPracticaobrasocial->getCd_practicaobrasocial();
        $cd_practica = $oPracticaobrasocial->getCd_practica();
        $cd_obrasocial = $oPracticaobrasocial->getCd_obrasocial();
        $nu_practicaos = $oPracticaobrasocial->getNu_practicaos();
        if ($oPracticaobrasocial->getNu_limiterepeticiones() == "" || $oPracticaobrasocial->getNu_limiterepeticiones() == null) {
            $nu_limiterepeticiones = 'NULL';
        } else {
            $nu_limiterepeticiones = $oPracticaobrasocial->getNu_limiterepeticiones();
        }
        $nu_importe = $oPracticaobrasocial->getNu_importe();
        $dt_vigencia = $oPracticaobrasocial->getDt_vigencia();

        $sql = "INSERT INTO practicaobrasocial (cd_practica, cd_obrasocial, nu_practicaos, nu_limiterepeticiones, nu_importe, dt_vigencia) VALUES('$cd_practica', '$cd_obrasocial', '$nu_practicaos', $nu_limiterepeticiones,'$nu_importe', '$dt_vigencia')";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $id = $db->sql_nextid();
        $oPracticaobrasocial->setCd_practicaobrasocial($id);

        $db->sql_freeresult($result);
    }

    public static function modificarPracticaobrasocial(Practicaobrasocial $oPracticaobrasocial) {
        $db = DbManager::getConnection();

        $cd_practicaobrasocial = $oPracticaobrasocial->getCd_practicaobrasocial();
        $cd_practica = $oPracticaobrasocial->getCd_practica();
        $cd_obrasocial = $oPracticaobrasocial->getCd_obrasocial();
        $nu_practicaos = $oPracticaobrasocial->getNu_practicaos();
        $nu_limiterepeticiones = $oPracticaobrasocial->getNu_limiterepeticiones();
        $nu_importe = $oPracticaobrasocial->getNu_importe();
        $dt_vigencia = $oPracticaobrasocial->getDt_vigencia();

        $sql = "UPDATE practicaobrasocial SET cd_practica = '$cd_practica', cd_obrasocial = '$cd_obrasocial', nu_practicaos = '$nu_practicaos', nu_importe = '$nu_importe', dt_vigencia = '$dt_vigencia', nu_limiterepeticiones = '$nu_limiterepeticiones' WHERE cd_practicaobrasocial = $cd_practicaobrasocial ";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);
    }

    public static function modificarRepeticionesDePracticaobrasocial(Practicaobrasocial $oPracticaobrasocial) {
        $db = DbManager::getConnection();

        $cd_practicaobrasocial = $oPracticaobrasocial->getCd_practicaobrasocial();
        $nu_limiterepeticiones = $oPracticaobrasocial->getNu_limiterepeticiones();
        if ($nu_limiterepeticiones == "") {
            $nu_limiterepeticiones = 'NULL';
        }
        $sql = "UPDATE practicaobrasocial SET nu_limiterepeticiones = $nu_limiterepeticiones WHERE cd_practicaobrasocial = $cd_practicaobrasocial ";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);
    }

    public static function eliminarPracticaobrasocial(Practicaobrasocial $oPracticaobrasocial) {
        $db = DbManager::getConnection();

        $cd_practicaobrasocial = $oPracticaobrasocial->getCd_practicaobrasocial();

        $sql = "DELETE FROM practicaobrasocial WHERE cd_practicaobrasocial = $cd_practicaobrasocial ";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);
    }

    public static function getPracticaobrasociales(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();


        $sql = "SELECT * FROM practicaobrasocial PO";
        $sql .= " LEFT JOIN practica P on (PO.cd_practica = P.cd_practica) ";
        $sql .= " LEFT JOIN obrasocial O on (PO.cd_obrasocial = O.cd_obrasocial) ";
        $sql .= $criterio->buildFiltro();
        //CdtUtils::log_debug('Obtener Practicas obrasociales: ' . $sql);
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $items = ResultFactory::toCollection($db, $result, new PracticaobrasocialFactory());
        $db->sql_freeresult($result);
        return $items;
    }

    public static function getCantPracticaobrasociales(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();


        $sql = "SELECT count(*) as count FROM practicaobrasocial PO";
        $sql .= " LEFT JOIN practica P on (PO.cd_practica = P.cd_practica) ";
        $sql .= " LEFT JOIN obrasocial O on (PO.cd_obrasocial = O.cd_obrasocial) ";
        $sql .= $criterio->buildFiltroSinPaginar();
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $next = $db->sql_fetchassoc($result);
        $cant = $next['count'];
        $db->sql_freeresult($result);
        return ((int) $cant);
    }

    public static function getPracticaobrasocial(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();


        $sql = "SELECT * FROM practicaobrasocial PO";
        $sql .= " LEFT JOIN practica P on (PO.cd_practica = P.cd_practica) ";
        $sql .= " LEFT JOIN obrasocial O on (PO.cd_obrasocial = O.cd_obrasocial) ";
        $sql .= $criterio->buildFiltro();

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        if ($db->sql_numrows() > 0) {
            $temp = $db->sql_fetchassoc($result);
            $factory = new PracticaobrasocialFactory();
            $obj = $factory->build($temp);
        }
        $db->sql_freeresult($result);
        return $obj;
    }

}
?>
