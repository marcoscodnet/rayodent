<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 14-12-2011
 */ 
class TurnoDAO { 

	public static function insertarTurno(Turno $oTurno) { 
		$db = DbManager::getConnection(); 

		
		$cd_turno = $oTurno->getCd_turno();
		
		$ds_turno = $oTurno->getDs_turno();
		

		$sql = "INSERT INTO turno (ds_turno) VALUES('$ds_turno')"; 

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$db->sql_freeresult($result);
	}


	public static function modificarTurno(Turno $oTurno) { 
		$db = DbManager::getConnection(); 

		
		$cd_turno = $oTurno->getCd_turno();
		
		$ds_turno = $oTurno->getDs_turno();
		


		$sql = "UPDATE turno SET ds_turno = '$ds_turno' WHERE cd_turno = $cd_turno "; 

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$db->sql_freeresult($result);
	}


	public static function eliminarTurno(Turno $oTurno) { 
		$db = DbManager::getConnection(); 

		$cd_turno = $oTurno->getCd_turno();

		$sql = "DELETE FROM turno WHERE cd_turno = $cd_turno "; 

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$db->sql_freeresult($result);
	}


	public static function getTurnos(CriterioBusqueda $criterio) { 
		$db = DbManager::getConnection(); 


		$sql = "SELECT * FROM turno "; 
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$items = ResultFactory::toCollection($db, $result, new TurnoFactory());
		$db->sql_freeresult($result);
		return $items;
	}


	public static function getCantTurnos(CriterioBusqueda $criterio) { 
		$db = DbManager::getConnection(); 


		$sql = "SELECT count(*) as count FROM turno "; 
		$sql .= $criterio->buildFiltroSinPaginar();
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc($result);
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ((int) $cant);
	}


	public static function getTurno(CriterioBusqueda $criterio) { 
		$db = DbManager::getConnection(); 


		$sql = "SELECT * FROM turno "; 
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		if ($db->sql_numrows() > 0) {
			$temp = $db->sql_fetchassoc($result);
			$factory = new TurnoFactory();
			$obj = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $obj;
	}

} 
?>