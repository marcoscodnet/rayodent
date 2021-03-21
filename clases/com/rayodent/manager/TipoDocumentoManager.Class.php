<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 28-10-2011 
 */ 
class TipoDocumentoManager implements IListar{ 

	public function agregarTipoDocumento(TipoDocumento $oTipoDocumento) { 
		//TODO validaciones; 

		//persistir en la bbdd.
		TipoDocumentoDAO::insertarTipoDocumento($oTipoDocumento);
	}


	public function modificarTipoDocumento(TipoDocumento $oTipoDocumento) { 
		//TODO validaciones; 

		//persistir en la bbdd.
		TipoDocumentoDAO::modificarTipoDocumento($oTipoDocumento);
	}


	public static function eliminarTipoDocumento($id) { 
		//TODO validaciones; 

		$oTipoDocumento = new TipoDocumento();
		$oTipoDocumento->setCd_tipodocumento($id);
		TipoDocumentoDAO::eliminarTipoDocumento($oTipoDocumento);
	}


	public function getTipoDocumentos(CriterioBusqueda $criterio) { 
		return TipoDocumentoDAO::getTipoDocumentos($criterio); 
	}


	public function getCantTipoDocumentos(CriterioBusqueda $criterio) { 
		return TipoDocumentoDAO::getCantTipoDocumentos($criterio); 
	}


	public function getTipoDocumento(CriterioBusqueda $criterio) { 
		return TipoDocumentoDAO::getTipoDocumento($criterio); 
	}

	//	interface IListar 
	public function getEntidades(CriterioBusqueda $criterio) { 
		return $this->getTipoDocumentos($criterio); 
	}


	public function getCantidadEntidades(CriterioBusqueda $criterio) { 
		return $this->getCantTipoDocumentos($criterio); 
	}


} 
?>