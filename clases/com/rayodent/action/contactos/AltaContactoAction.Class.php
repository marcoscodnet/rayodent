<?php 

/**
 * Acción para dar de alta un contacto.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class AltaContactoAction extends EditarContactoAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new ContactoManager();
		$manager->agregarContacto( $oEntidad );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'alta_contacto_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_contacto_error';
	}
		

	protected function getActionForwardFailure(){
		return 'alta_contacto_init';
	}
	
}
