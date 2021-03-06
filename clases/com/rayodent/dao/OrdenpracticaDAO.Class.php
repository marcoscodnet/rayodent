<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 14-12-2011
 */
class OrdenpracticaDAO {

    public static function insertarOrdenpractica(Ordenpractica $oOrdenpractica) {
        $db = DbManager::getConnection();


        $cd_ordenpractica = $oOrdenpractica->getCd_ordenpractica();

        $dt_carga = $oOrdenpractica->getDt_carga();

        $cd_turno = $oOrdenpractica->getCd_turno();

        $cd_paciente = $oOrdenpractica->getCd_paciente();

        $cd_profesional = $oOrdenpractica->getCd_profesional();

        //$cd_empleado = $oOrdenpractica->getCd_empleado();
        $cd_empleado = ($oOrdenpractica->getCd_empleado()==null || trim($oOrdenpractica->getCd_empleado())=='' || $oOrdenpractica->getCd_empleado()==0)?0:$oOrdenpractica->getCd_empleado();

        $cd_obrasocial = $oOrdenpractica->getCd_obrasocial();
        $cd_movcaja = $oOrdenpractica->getCd_movcaja();
		//CdtUtils::log_debug('Bl bono: ' . $oOrdenpractica->getBl_bono());
        //$bl_bono = (trim($oOrdenpractica->getBl_bono())!='')?"'".$oOrdenpractica->getBl_bono()."'":null;
        
        $bl_bono = ($oOrdenpractica->getBl_bono()==null || trim($oOrdenpractica->getBl_bono())=='' || $oOrdenpractica->getBl_bono()==0)?0:$oOrdenpractica->getBl_bono();

        //$nu_importebono = $oOrdenpractica->getNu_importebono();
        
        $nu_importebono = ($oOrdenpractica->getNu_importebono()==null || trim($oOrdenpractica->getNu_importebono())=='' || $oOrdenpractica->getNu_importebono()==0)?0:$oOrdenpractica->getNu_importebono();

        //$nu_reciboreintegro = $oOrdenpractica->getNu_reciboreintegro();
		$nu_reciboreintegro = ($oOrdenpractica->getNu_reciboreintegro()==null || trim($oOrdenpractica->getNu_reciboreintegro())=='' || $oOrdenpractica->getNu_reciboreintegro()==0)?0:$oOrdenpractica->getNu_reciboreintegro();

        $sql = "INSERT INTO ordenpractica (dt_carga, cd_turno, cd_paciente, cd_profesional, cd_empleado, cd_obrasocial, bl_bono, nu_importebono, nu_reciboreintegro, cd_movcaja) VALUES('$dt_carga', '$cd_turno', '$cd_paciente', '$cd_profesional', '$cd_empleado', '$cd_obrasocial', '$bl_bono', '$nu_importebono', '$nu_reciboreintegro', '$cd_movcaja')";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $id = $db->sql_nextid();
        $oOrdenpractica->setCd_ordenpractica($id);
        $db->sql_freeresult($result);
    }

    public static function modificarOrdenpractica(Ordenpractica $oOrdenpractica) {
        $db = DbManager::getConnection();
        $cd_ordenpractica = $oOrdenpractica->getCd_ordenpractica();
        $dt_carga = $oOrdenpractica->getDt_carga();
        $cd_turno = $oOrdenpractica->getCd_turno();
        $cd_paciente = $oOrdenpractica->getCd_paciente();
        $cd_profesional = $oOrdenpractica->getCd_profesional();
        $cd_movcaja = $oOrdenpractica->getCd_movcaja();
        $cd_empleado = ($oOrdenpractica->getCd_empleado())?$oOrdenpractica->getCd_empleado():0;
        $cd_obrasocial = $oOrdenpractica->getCd_obrasocial();
        $bl_bono = ($oOrdenpractica->getBl_bono()==null || trim($oOrdenpractica->getBl_bono())=='' || $oOrdenpractica->getBl_bono()==0)?0:$oOrdenpractica->getBl_bono();

        //$nu_importebono = $oOrdenpractica->getNu_importebono();
        
        $nu_importebono = ($oOrdenpractica->getNu_importebono()==null || trim($oOrdenpractica->getNu_importebono())=='' || $oOrdenpractica->getNu_importebono()==0)?0:$oOrdenpractica->getNu_importebono();

        //$nu_reciboreintegro = $oOrdenpractica->getNu_reciboreintegro();
		$nu_reciboreintegro = ($oOrdenpractica->getNu_reciboreintegro()==null || trim($oOrdenpractica->getNu_reciboreintegro())=='' || $oOrdenpractica->getNu_reciboreintegro()==0)?0:$oOrdenpractica->getNu_reciboreintegro();
        

        $sql = "UPDATE ordenpractica SET dt_carga = '$dt_carga', cd_turno = '$cd_turno', cd_paciente = '$cd_paciente', cd_profesional = '$cd_profesional', cd_empleado = '$cd_empleado', cd_obrasocial = '$cd_obrasocial', bl_bono = '$bl_bono', nu_importebono = '$nu_importebono', nu_reciboreintegro = '$nu_reciboreintegro', cd_movcaja = '$cd_movcaja' WHERE cd_ordenpractica = $cd_ordenpractica ";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);
    }

    public static function eliminarOrdenpractica(Ordenpractica $oOrdenpractica) {
        $db = DbManager::getConnection();

        $cd_ordenpractica = $oOrdenpractica->getCd_ordenpractica();

        $sql = "DELETE FROM ordenpractica WHERE cd_ordenpractica = $cd_ordenpractica ";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);
    }

    public static function getOrdenpracticas(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();


        $sql = "SELECT * FROM ordenpractica OP";
        $sql .= " LEFT JOIN paciente PA ON(PA.cd_paciente = OP.cd_paciente)";
        $sql .= " LEFT JOIN profesional PR ON(PR.cd_profesional = OP.cd_profesional)";
        $sql .= $criterio->buildFiltro();
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $items = ResultFactory::toCollection($db, $result, new OrdenpracticaFactory());
        $db->sql_freeresult($result);
        return $items;
    }

    public static function getCantOrdenpracticas(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();


        $sql = "SELECT count(*) as count FROM ordenpractica OP";
        $sql .= " LEFT JOIN paciente PA ON(PA.cd_paciente = OP.cd_paciente)";
        $sql .= " LEFT JOIN profesional PR ON(PR.cd_profesional = OP.cd_profesional)";
        $sql .= $criterio->buildFiltroSinPaginar();
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $next = $db->sql_fetchassoc($result);
        $cant = $next['count'];
        $db->sql_freeresult($result);
        return ((int) $cant);
    }

    public static function getOrdenpractica(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();


        $sql = "SELECT * FROM ordenpractica OP";
        $sql .= " LEFT JOIN paciente PA ON(PA.cd_paciente = OP.cd_paciente)";
        $sql .= " LEFT JOIN profesional PR ON(PR.cd_profesional = OP.cd_profesional)";
        $sql .= " LEFT JOIN movcaja MC ON(MC.cd_movcaja = OP.cd_movcaja)";
        $sql .= $criterio->buildFiltro();
        
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        if ($db->sql_numrows() > 0) {
            $temp = $db->sql_fetchassoc($result);
            $factory = new OrdenpracticaFactory();
            $obj = $factory->build($temp);
        }
        $db->sql_freeresult($result);
        return $obj;
    }
    
	public static function eliminarOrdenpracticaPorMovcaja($cd_movcaja) {
        $db = DbManager::getConnection();

        
        $sql = "DELETE FROM ordenpractica WHERE cd_movcaja = $cd_movcaja ";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);
    }

}
?>
