<?php 

/**
 * Acción para dar de alta un profesional.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class AltaProfesionalAction extends EditarProfesionalAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new ProfesionalManager();
		$manager->agregarProfesional( $oEntidad );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'alta_profesional_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_profesional_error';
	}
		

	protected function getActionForwardFailure(){
		return 'alta_profesional_init';
	}
	
}
