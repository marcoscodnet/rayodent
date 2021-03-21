<?php 

/**
 * Acción para editar un profesional.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
abstract class EditarProfesionalAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el profesional a modificar.
		$oProfesional = new Profesional ( );
		
				
		$oProfesional->setCd_profesional ( FormatUtils::getParamPOST('cd_profesional') );	
				
		$oProfesional->setCd_tipodocumento ( FormatUtils::getParamPOST('cd_tipodocumento') );	
				
		$oProfesional->setNu_documento ( FormatUtils::getParamPOST('nu_documento') );	
				
		$oProfesional->setDs_nombre ( FormatUtils::getParamPOST('ds_nombre') );	
				
		$oProfesional->setNu_matricula ( FormatUtils::getParamPOST('nu_matricula') );	
				
		$oProfesional->setDs_domicilio ( FormatUtils::getParamPOST('ds_domicilio') );	
				
		$oProfesional->setDs_telefono ( FormatUtils::getParamPOST('ds_telefono') );	
				
		$oProfesional->setDs_email ( FormatUtils::getParamPOST('ds_email') );	
		
					
		return $oProfesional;
	}
	
		
}
