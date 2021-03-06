<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 05-12-2011 
 */ 
class TipooperacionManager implements IListar{ 

	public function agregarTipooperacion(Tipooperacion $oTipooperacion) { 
		//TODO validaciones; 

		//persistir en la bbdd.
		TipooperacionDAO::insertarTipooperacion($oTipooperacion);
	}


	public function modificarTipooperacion(Tipooperacion $oTipooperacion) { 
		//TODO validaciones; 

		//persistir en la bbdd.
		TipooperacionDAO::modificarTipooperacion($oTipooperacion);
	}


	public static function eliminarTipooperacion($id) { 
		//TODO validaciones; 

		$oTipooperacion = new Tipooperacion();
		$oTipooperacion->setCd_tipooperacion($id);
		TipooperacionDAO::eliminarTipooperacion($oTipooperacion);
	}


	public function getTipooperaciones(CriterioBusqueda $criterio) { 
		return TipooperacionDAO::getTipooperaciones($criterio); 
	}


	public function getCantTipooperaciones(CriterioBusqueda $criterio) { 
		return TipooperacionDAO::getCantTipooperaciones($criterio); 
	}


	public function getTipooperacion(CriterioBusqueda $criterio) { 
		return TipooperacionDAO::getTipooperacion($criterio); 
	}

        public function getCoeficiente($cd_tipooperacion) {
		return TipooperacionDAO::getCoeficiente($cd_tipooperacion);
	}

	//	interface IListar 
	public function getEntidades(CriterioBusqueda $criterio) { 
		return $this->getTipooperaciones($criterio); 
	}


	public function getCantidadEntidades(CriterioBusqueda $criterio) { 
		return $this->getCantTipooperaciones($criterio); 
	}


} 
?>
