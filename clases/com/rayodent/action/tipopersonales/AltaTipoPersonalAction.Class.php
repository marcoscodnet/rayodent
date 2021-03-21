<?php 

/**
 * Acción para dar de alta un tipoPersonal.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class AltaTipoPersonalAction extends EditarTipoPersonalAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new TipoPersonalManager();
		$manager->agregarTipoPersonal( $oEntidad );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'alta_tipopersonal_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_tipopersonal_error';
	}
		

	protected function getActionForwardFailure(){
		return 'alta_tipoPersonal_init';
	}
	
}
