<?php 

/**
 * Acción para editar un contacto.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
abstract class EditarContactoAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el contacto a modificar.
		$oContacto = new Contacto ( );

				
		$oContacto->setCd_contacto ( FormatUtils::getParamPOST('cd_contacto') );	
				
		$oContacto->setDs_apynom ( FormatUtils::getParamPOST('ds_apynom') );	
				
		$oContacto->setDs_movil ( FormatUtils::getParamPOST('ds_movil') );	
				
		$oContacto->setDs_telefonotrabajo ( FormatUtils::getParamPOST('ds_telefonotrabajo') );	
				
		$oContacto->setDs_direccion ( FormatUtils::getParamPOST('ds_direccion') );	
				
		$oContacto->setDs_telefono ( FormatUtils::getParamPOST('ds_telefono') );	
				
		$oContacto->setDs_email ( FormatUtils::getParamPOST('ds_email') );	
		
		$oContacto->setNu_documento ( FormatUtils::getParamPOST('nu_documento') );	
		
		$oContacto->setNu_cuit ( FormatUtils::getParamPOST('nu_cuit') );	
		
					
		return $oContacto;
	}
	
		
}
