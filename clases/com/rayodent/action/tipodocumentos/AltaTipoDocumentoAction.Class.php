<?php 

/**
 * Acción para dar de alta un tipoDocumento.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class AltaTipoDocumentoAction extends EditarTipoDocumentoAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new TipoDocumentoManager();
		$manager->agregarTipoDocumento( $oEntidad );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'alta_tipodocumento_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_tipodocumento_error';
	}
		

	protected function getActionForwardFailure(){
		return 'alta_tipoDocumento_init';
	}
	
}
