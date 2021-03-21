<?php 

/**
 * Acción para dar de alta un pacienteobrasocial.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class AltaPacienteobrasocialAction extends EditarPacienteobrasocialAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new PacienteobrasocialManager();
		$manager->agregarPacienteobrasocial( $oEntidad );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'alta_pacienteobrasocial_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_pacienteobrasocial_error';
	}
		

	protected function getActionForwardFailure(){
		return 'alta_pacienteobrasocial_init';
	}
	
}
