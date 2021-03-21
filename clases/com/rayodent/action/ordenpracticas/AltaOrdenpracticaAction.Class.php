<?php 

/**
 * Acción para dar de alta un ordenpractica.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class AltaOrdenpracticaAction extends EditarOrdenpracticaAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new OrdenpracticaManager();
		$manager->agregarOrdenpractica( $oEntidad );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'alta_ordenpractica_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_ordenpractica_error';
	}
		

	protected function getActionForwardFailure(){
		return 'alta_ordenpractica_init';
	}
	
}
