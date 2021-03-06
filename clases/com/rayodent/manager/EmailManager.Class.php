<?php 

/** 
 * Autogenerated class 
 *  
 *  @author Marcos 
 *  @since 10-10-2018 
 */ 
class EmailManager implements IListar{ 

	public function agregarEmail(Email $oEmail) { 
		//TODO validaciones; 

		//persistir en la bbdd.
		EmailDAO::insertarEmail($oEmail);
	}


	public function modificarEmail(Email $oEmail) { 
		//TODO validaciones; 

		//persistir en la bbdd.
		EmailDAO::modificarEmail($oEmail);
	}


	public static function eliminarEmail($id) { 
		//TODO validaciones; 

		$oEmail = new Email();
		$oEmail->setCd_email($id);
		EmailDAO::eliminarEmail($oEmail);
	}


	public function getEmails(CriterioBusqueda $criterio) { 
		return EmailDAO::getEmails($criterio); 
	}


	public function getCantEmails(CriterioBusqueda $criterio) { 
		return EmailDAO::getCantEmails($criterio); 
	}


	public function getEmail(CriterioBusqueda $criterio) { 
		return EmailDAO::getEmail($criterio); 
	}

	//	interface IListar 
	public function getEntidades(CriterioBusqueda $criterio) { 
		return $this->getEmails($criterio); 
	}


	public function getCantidadEntidades(CriterioBusqueda $criterio) { 
		return $this->getCantEmails($criterio); 
	}


} 
?>
