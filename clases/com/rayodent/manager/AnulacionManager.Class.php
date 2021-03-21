<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 22-12-2011 
 */ 
class AnulacionManager implements IListar{ 

	public function agregarAnulacion(Anulacion $oAnulacion) { 
		//TODO validaciones; 

		//persistir en la bbdd.
		AnulacionDAO::insertarAnulacion($oAnulacion);
	}


	public function modificarAnulacion(Anulacion $oAnulacion) { 
		//TODO validaciones; 

		//persistir en la bbdd.
		AnulacionDAO::modificarAnulacion($oAnulacion);
	}


	public static function eliminarAnulacion($id) { 
		//TODO validaciones; 

		$oAnulacion = new Anulacion();
		$oAnulacion->setCd_anulacion($id);
		AnulacionDAO::eliminarAnulacion($oAnulacion);
	}


	public function getAnulaciones(CriterioBusqueda $criterio) { 
		return AnulacionDAO::getAnulaciones($criterio); 
	}


	public function getCantAnulaciones(CriterioBusqueda $criterio) { 
		return AnulacionDAO::getCantAnulaciones($criterio); 
	}


	public function getAnulacion(CriterioBusqueda $criterio) { 
		return AnulacionDAO::getAnulacion($criterio); 
	}

	//	interface IListar 
	public function getEntidades(CriterioBusqueda $criterio) { 
		return $this->getAnulaciones($criterio); 
	}


	public function getCantidadEntidades(CriterioBusqueda $criterio) { 
		return $this->getCantAnulaciones($criterio); 
	}


} 
?>