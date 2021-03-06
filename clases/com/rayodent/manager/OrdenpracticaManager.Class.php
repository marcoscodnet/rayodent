<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 14-12-2011 
 */ 
class OrdenpracticaManager implements IListar{ 

	public function agregarOrdenpractica(Ordenpractica $oOrdenpractica) { 
		//TODO validaciones; 

		//persistir en la bbdd.
		OrdenpracticaDAO::insertarOrdenpractica($oOrdenpractica);
	}


	public function modificarOrdenpractica(Ordenpractica $oOrdenpractica) { 
		//TODO validaciones; 

		//persistir en la bbdd.
		OrdenpracticaDAO::modificarOrdenpractica($oOrdenpractica);
	}


	public static function eliminarOrdenpractica($id) { 
		//TODO validaciones; 

		$oOrdenpractica = new Ordenpractica();
		$oOrdenpractica->setCd_ordenpractica($id);
		OrdenpracticaDAO::eliminarOrdenpractica($oOrdenpractica);
	}


	public function getOrdenpracticas(CriterioBusqueda $criterio) { 
		return OrdenpracticaDAO::getOrdenpracticas($criterio); 
	}


	public function getCantOrdenpracticas(CriterioBusqueda $criterio) { 
		return OrdenpracticaDAO::getCantOrdenpracticas($criterio); 
	}


	public function getOrdenpractica(CriterioBusqueda $criterio) { 
		return OrdenpracticaDAO::getOrdenpractica($criterio); 
	}

	//	interface IListar 
	public function getEntidades(CriterioBusqueda $criterio) { 
		return $this->getOrdenpracticas($criterio); 
	}


	public function getCantidadEntidades(CriterioBusqueda $criterio) { 
		return $this->getCantOrdenpracticas($criterio); 
	}
	
	public static function eliminarOrdenpracticaPorMovcaja($cd_movcaja) { 
		//TODO validaciones; 

		OrdenpracticaDAO::eliminarOrdenpracticaPorMovcaja($cd_movcaja);
	}


} 
?>
