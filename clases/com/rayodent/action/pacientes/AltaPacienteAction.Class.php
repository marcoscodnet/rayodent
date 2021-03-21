<?php 

/**
 * Acción para dar de alta un paciente.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class AltaPacienteAction extends EditarPacienteAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new PacienteManager();
		$manager->agregarPaciente( $oEntidad );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'alta_paciente_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_paciente_error';
	}
		

	protected function getActionForwardFailure(){
		return 'alta_paciente_init';
	}
	
}
