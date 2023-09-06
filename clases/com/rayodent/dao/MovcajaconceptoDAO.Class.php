<?php

/**
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 14-12-2011
 */
class MovcajaconceptoDAO {

    public static function insertarMovcajaconcepto(Movcajaconcepto $oMovcajaconcepto) {
        $db = DbManager::getConnection();
        $cd_movcajaconcepto = $oMovcajaconcepto->getCd_movcajaconcepto();
        $cd_movcaja = $oMovcajaconcepto->getCd_movcaja();
        $cd_concepto = $oMovcajaconcepto->getCd_concepto();
        $nu_importe = $oMovcajaconcepto->getNu_importe();
        $bl_tarjeta = ($oMovcajaconcepto->getBl_tarjeta())?$oMovcajaconcepto->getBl_tarjeta():0;
        $bl_digital = ($oMovcajaconcepto->getBl_digital())?$oMovcajaconcepto->getBl_digital():0;
        $cd_ordenpractica = ($oMovcajaconcepto->getCd_ordenpractica()==null || trim($oMovcajaconcepto->getCd_ordenpractica())=='' || $oMovcajaconcepto->getCd_ordenpractica()==0)?0:$oMovcajaconcepto->getCd_ordenpractica();
        $sql = "INSERT INTO movcajaconcepto (cd_movcaja, cd_concepto, nu_importe, cd_ordenpractica, bl_tarjeta, bl_digital) VALUES('$cd_movcaja', '$cd_concepto', '$nu_importe', '$cd_ordenpractica', '$bl_tarjeta', '$bl_digital')";
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $id = $db->sql_nextid();
        $oMovcajaconcepto->setCd_movcajaconcepto($id);
        $db->sql_freeresult($result);
    }

    public static function modificarMovcajaconcepto(Movcajaconcepto $oMovcajaconcepto) {
        $db = DbManager::getConnection();


        $cd_movcajaconcepto = $oMovcajaconcepto->getCd_movcajaconcepto();

        $cd_movcaja = $oMovcajaconcepto->getCd_movcaja();

        $cd_concepto = $oMovcajaconcepto->getCd_concepto();

        $nu_importe = $oMovcajaconcepto->getNu_importe();
        
        $bl_tarjeta = ($oMovcajaconcepto->getBl_tarjeta())?$oMovcajaconcepto->getBl_tarjeta():0;
        $bl_digital = ($oMovcajaconcepto->getBl_digital())?$oMovcajaconcepto->getBl_digital():0;

		$cd_ordenpractica = ($oMovcajaconcepto->getCd_ordenpractica()==null || trim($oMovcajaconcepto->getCd_ordenpractica())=='' || $oMovcajaconcepto->getCd_ordenpractica()==0)?0:$oMovcajaconcepto->getCd_ordenpractica();
        $sql = "UPDATE movcajaconcepto SET cd_movcaja = '$cd_movcaja', cd_concepto = '$cd_concepto', nu_importe = '$nu_importe', bl_tarjeta = '$bl_tarjeta', bl_digital = '$bl_digital', cd_ordenpractica = '$cd_ordenpractica' WHERE cd_movcajaconcepto = $cd_movcajaconcepto ";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);
    }

    public static function eliminarMovcajaconcepto(Movcajaconcepto $oMovcajaconcepto) {
        $db = DbManager::getConnection();

        $cd_movcajaconcepto = $oMovcajaconcepto->getCd_movcajaconcepto();

        $sql = "DELETE FROM movcajaconcepto WHERE cd_movcajaconcepto = $cd_movcajaconcepto ";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);
    }

    public static function getMovcajaconceptos(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();
        $sql = "SELECT MCC.cd_concepto as mcc_cd_concepto, MCC.cd_movcaja as mcc_cd_movcaja, MCC.cd_movcajaconcepto as mcc_cd_movcajaconcepto, MCC.nu_importe as mcc_nu_importe, MCC.bl_tarjeta as mcc_bl_tarjeta, MCC.bl_digital as mcc_bl_digital, MCC.cd_ordenpractica as mcc_cd_ordenpractica, POP.*, TC.*, C.*, T_O.*, OP.*, POS.*, P.*, OS.*  FROM movcajaconcepto MCC";
        $sql .= " LEFT JOIN movcaja MC ON (MCC.cd_movcaja = MC.cd_movcaja)";
        $sql .= " LEFT JOIN practicaordenpractica POP ON (POP.cd_movcajaconcepto = MCC.cd_movcajaconcepto)";
        $sql .= " LEFT JOIN practicaobrasocial POS ON (POP.cd_practicaobrasocial = POS.cd_practicaobrasocial)";
        $sql .= " LEFT JOIN concepto C ON (C.cd_concepto = MCC.cd_concepto)";
        $sql .= " LEFT JOIN tipoconcepto TC ON (C.cd_tipoconcepto = TC.cd_tipoconcepto)";
        $sql .= " LEFT JOIN tipooperacion T_O ON (T_O.cd_tipooperacion = C.cd_tipooperacion)";
        $sql .= " LEFT JOIN ordenpractica OP ON (OP.cd_ordenpractica = POP.cd_ordenpractica)";
        $sql .= " LEFT JOIN practica P ON ( POS.cd_practica = P.cd_practica )";
		$sql .= " LEFT JOIN obrasocial OS ON ( POS.cd_obrasocial = OS.cd_obrasocial )";
        $sql .= $criterio->buildFiltro();
        //echo "<br/>" . $sql;
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $items = ResultFactory::toCollection($db, $result, new MovcajaconceptoNoConflictFactory('mcc_'));
        $db->sql_freeresult($result);
        return $items;
    }

    public static function getMovcajaconceptosDeObraSocial(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();
        $sql = "SELECT DISTINCT(MCC.cd_movcajaconcepto) as mcc_cd_movcajaconcepto, MCC.cd_concepto as mcc_cd_concepto, MCC.cd_movcaja as mcc_cd_movcaja,  MCC.nu_importe as mcc_nu_importe, POP.*, TC.*, C.*, T_O.*, OP.*, P.* ";
        $sql .= "FROM movcajaconcepto MCC, practicaordenpractica POP, concepto C,tipoconcepto TC, tipooperacion T_O, ordenpractica OP, practicaobrasocial POS, paciente P  ";
        $sql .= $criterio->buildWHERE();
        $sql .= " AND (POP.cd_movcajaconcepto = MCC.cd_movcajaconcepto)";
        $sql .= " AND (C.cd_concepto = MCC.cd_concepto)";
        $sql .= " AND (C.cd_tipoconcepto = TC.cd_tipoconcepto)";
        $sql .= " AND (T_O.cd_tipooperacion = C.cd_tipooperacion)";
        $sql .= " AND (OP.cd_ordenpractica = POP.cd_ordenpractica)";
        $sql .= " AND (OP.cd_paciente = P.cd_paciente)";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $items = ResultFactory::toCollection($db, $result, new MovcajaconceptoNoConflictFactory('mcc_'));
        $db->sql_freeresult($result);
        return $items;
    }

    public static function getCantMovcajaconceptos(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();


        $sql = "SELECT count(*) as count FROM movcajaconcepto ";
        $sql .= $criterio->buildFiltroSinPaginar();
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $next = $db->sql_fetchassoc($result);
        $cant = $next['count'];
        $db->sql_freeresult($result);
        return ((int) $cant);
    }

    public static function getMovcajaconcepto(CriterioBusqueda $criterio) {
        $db = DbManager::getConnection();


        $sql = "SELECT * FROM movcajaconcepto ";
        $sql .= $criterio->buildFiltro();
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        if ($db->sql_numrows() > 0) {
            $temp = $db->sql_fetchassoc($result);
            $factory = new MovcajaconceptoFactory();
            $obj = $factory->build($temp);
        }
        $db->sql_freeresult($result);
        return $obj;
    }

	public static function modificarImportes( $ids,  $nu_importe ){
    	
		$db = DbManager::getConnection();

		$strIds = implode($ids, ",");
		
        $sql = "UPDATE movcajaconcepto SET nu_importe = '$nu_importe' WHERE cd_movcajaconcepto IN ( $strIds ) ";

        //CdtUtils::log_debug('SQL actualizando importe en movcajaconcepto: ' . $sql);
        
        $result = $db->sql_query($sql);
        
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);    	
    	
    }
    
	public static function eliminarMovcajaconceptoPorMovcaja($cd_movcaja) {
        $db = DbManager::getConnection();

        $sql = "DELETE FROM movcajaconcepto WHERE cd_movcaja = $cd_movcaja ";

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());

        $db->sql_freeresult($result);
    }
}
?>
