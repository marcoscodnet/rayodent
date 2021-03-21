<?php 

/**
 * Acción para modificar un pacienteobrasocial.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class ModificarPacienteobrasocialAction extends EditarPacienteobrasocialAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new PacienteobrasocialManager();
		$manager->modificarPacienteobrasocial( $oEntidad );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'modificar_pacienteobrasocial_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'modificar_pacienteobrasocial_error';
	}
		

	public function getIdEntidad(){
		return FormatUtils::getParamPOST('id');
	}
	
	
	protected function getActionForwardFailure(){
		return 'modificar_pacienteobrasocial_init';
	}
	
}
