<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un tipooperacion.
 *  
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class ModificarTipooperacionInitAction extends EditarTipooperacionInitAction{

	protected function getEntidad(){
		$oTipooperacion = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_tipooperacion', $id, '=');
			
			$manager = new TipooperacionManager();
			$oTipooperacion = $manager->getTipooperacion( $criterio );
			
		}else{
		
			$oTipooperacion = parent::getEntidad();
		
		}
		return $oTipooperacion ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Tipo de operaci&oacute;n";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_tipooperacion";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
