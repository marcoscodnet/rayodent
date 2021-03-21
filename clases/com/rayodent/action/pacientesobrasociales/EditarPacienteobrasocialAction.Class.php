<?php 

/**
 * Acción para editar un pacienteobrasocial.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
abstract class EditarPacienteobrasocialAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el pacienteobrasocial a modificar.
		$oPacienteobrasocial = new Pacienteobrasocial ( );
		
				
		$oPacienteobrasocial->setCd_pacienteobrasocial ( FormatUtils::getParamPOST('cd_pacienteobrasocial') );	
				
		$oPacienteobrasocial->setCd_paciente ( FormatUtils::getParamPOST('cd_paciente') );	
				
		$oPacienteobrasocial->setCd_obrasocial ( FormatUtils::getParamPOST('cd_obrasocial') );	
		
					
		return $oPacienteobrasocial;
	}
	
		
}
