<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 05-12-2011
 */ 
class TipoconceptoDAO { 

	public static function insertarTipoconcepto(Tipoconcepto $oTipoconcepto) { 
		$db = DbManager::getConnection(); 		
		$cd_tipoconcepto = $oTipoconcepto->getCd_tipoconcepto();		
		$ds_tipoconcepto = $oTipoconcepto->getDs_tipoconcepto();
                $bl_oculto = $oTipoconcepto->getBl_oculto();
		

		$sql = "INSERT INTO tipoconcepto (ds_tipoconcepto, bl_oculto) VALUES('$ds_tipoconcepto', '$bl_oculto')";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$db->sql_freeresult($result);
	}


	public static function modificarTipoconcepto(Tipoconcepto $oTipoconcepto) { 
		$db = DbManager::getConnection(); 

		
		$cd_tipoconcepto = $oTipoconcepto->getCd_tipoconcepto();		
		$ds_tipoconcepto = $oTipoconcepto->getDs_tipoconcepto();
		$bl_oculto = $oTipoconcepto->getBl_oculto();


		$sql = "UPDATE tipoconcepto SET ds_tipoconcepto = '$ds_tipoconcepto', bl_oculto = '$bl_oculto' WHERE cd_tipoconcepto = $cd_tipoconcepto ";

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$db->sql_freeresult($result);
	}


	public static function eliminarTipoconcepto(Tipoconcepto $oTipoconcepto) { 
		$db = DbManager::getConnection(); 

		$cd_tipoconcepto = $oTipoconcepto->getCd_tipoconcepto();

		$sql = "DELETE FROM tipoconcepto WHERE cd_tipoconcepto = $cd_tipoconcepto "; 

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$db->sql_freeresult($result);
	}


	public static function getTipoconceptos(CriterioBusqueda $criterio) { 
		$db = DbManager::getConnection(); 


		$sql = "SELECT * FROM tipoconcepto "; 
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$items = ResultFactory::toCollection($db, $result, new TipoconceptoFactory());
		$db->sql_freeresult($result);
		return $items;
	}


	public static function getCantTipoconceptos(CriterioBusqueda $criterio) { 
		$db = DbManager::getConnection(); 
		$sql = "SELECT count(*) as count FROM tipoconcepto "; 
		$sql .= $criterio->buildFiltroSinPaginar();
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc($result);
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ((int) $cant);
	}


	public static function getTipoconcepto(CriterioBusqueda $criterio) { 
		$db = DbManager::getConnection(); 


		$sql = "SELECT * FROM tipoconcepto "; 
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		if ($db->sql_numrows() > 0) {
			$temp = $db->sql_fetchassoc($result);
			$factory = new TipoconceptoFactory();
			$obj = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $obj;
	}

} 
?>