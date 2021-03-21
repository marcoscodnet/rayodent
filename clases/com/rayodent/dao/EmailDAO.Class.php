<?php 

/** 
 * Autogenerated class 
 *  
 *  @author Marcos 
 *  @since 10-10-2018
 */ 
class EmailDAO { 

	public static function insertarEmail(Email $oEmail) { 
		$db = DbManager::getConnection(); 

		
		$cd_email = $oEmail->getCd_email();
		
		$ds_remitente = $oEmail->getDs_remitente();
		
		$ds_destinatario = $oEmail->getDs_destinatario();
		
		$ds_asunto = $oEmail->getDs_asunto();
		
		$ds_cuerpo = $oEmail->getDs_cuerpo();
		
		$dt_fecha = $oEmail->getDt_fecha();
		
		$nu_email = $oEmail->getNu_email();
		

		$sql = "INSERT INTO email (ds_remitente, ds_destinatario, ds_asunto, ds_cuerpo, dt_fecha, nu_email) VALUES('$ds_remitente', '$ds_destinatario', '$ds_asunto', '$ds_cuerpo', '$dt_fecha', '$nu_email')"; 

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$db->sql_freeresult($result);
	}


	public static function modificarEmail(Email $oEmail) { 
		$db = DbManager::getConnection(); 

		
		$cd_email = $oEmail->getCd_email();
		
		$ds_remitente = $oEmail->getDs_remitente();
		
		$ds_destinatario = $oEmail->getDs_destinatario();
		
		$ds_asunto = $oEmail->getDs_asunto();
		
		$ds_cuerpo = $oEmail->getDs_cuerpo();
		
		$dt_fecha = $oEmail->getDt_fecha();

		$nu_email = $oEmail->getNu_email();
		
		$sql = "UPDATE email SET ds_remitente = '$ds_remitente', ds_destinatario = '$ds_destinatario', ds_asunto = '$ds_asunto', ds_cuerpo = '$ds_cuerpo', dt_fecha = '$dt_fecha', nu_email = '$nu_email' WHERE cd_email = $cd_email "; 

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$db->sql_freeresult($result);
	}


	public static function eliminarEmail(Email $oEmail) { 
		$db = DbManager::getConnection(); 

		$cd_email = $oEmail->getCd_email();

		$sql = "DELETE FROM email WHERE cd_email = $cd_email "; 

		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$db->sql_freeresult($result);
	}


	public static function getEmails(CriterioBusqueda $criterio) { 
		$db = DbManager::getConnection(); 


		$sql = "SELECT * FROM email "; 
		$sql .= $criterio->buildFiltro();
                
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$items = ResultFactory::toCollection($db, $result, new EmailFactory());
		$db->sql_freeresult($result);
		return $items;
	}


	public static function getCantEmails(CriterioBusqueda $criterio) { 
		$db = DbManager::getConnection(); 
		$sql = "SELECT count(*) as count FROM email "; 
		$sql .= $criterio->buildFiltroSinPaginar();
                
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		$next = $db->sql_fetchassoc($result);
		$cant = $next['count'];
		$db->sql_freeresult($result);
		return ((int) $cant);
	}


	public static function getEmail(CriterioBusqueda $criterio) { 
		$db = DbManager::getConnection(); 


		$sql = "SELECT * FROM email "; 
		$sql .= $criterio->buildFiltro();
		$result = $db->sql_query($sql);
		if (!$result)//hubo un error en la bbdd.
			throw new DBException($db->sql_error());

		if ($db->sql_numrows() > 0) {
			$temp = $db->sql_fetchassoc($result);
			$factory = new EmailFactory();
			$obj = $factory->build($temp);
		}
		$db->sql_freeresult($result);
		return $obj;
	}

} 
?>