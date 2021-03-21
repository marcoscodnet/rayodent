<?php 

/**
 * Acción para dar de alta un practicaobrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class AltaVigenciasypreciosAction extends EditarVigenciasypreciosAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new PracticaobrasocialManager();
		$manager->agregarPracticaobrasocial( $oEntidad );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'alta_practicaobrasocial_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_practicaobrasocial_error';
	}
		

	protected function getActionForwardFailure(){
		return 'alta_practicaobrasocial_init';
	}
	
}
