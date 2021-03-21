<?php 

/**
 * Acción para editar un empleado.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
abstract class EditarEmpleadoAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el empleado a modificar.
		$oEmpleado = new Empleado ( );
		
				
		$oEmpleado->setCd_empleado ( FormatUtils::getParamPOST('cd_empleado') );	
				
		$oEmpleado->setCd_tipodocumento ( FormatUtils::getParamPOST('cd_tipodocumento') );	
				
		$oEmpleado->setNu_documento ( FormatUtils::getParamPOST('nu_documento') );	
				
		$oEmpleado->setDs_nombre ( FormatUtils::getParamPOST('ds_nombre') );	
				
		$oEmpleado->setCd_tipopersonal ( FormatUtils::getParamPOST('cd_tipopersonal') );	
				
		$oEmpleado->setDs_domicilio ( FormatUtils::getParamPOST('ds_domicilio') );	
				
		$oEmpleado->setDs_telefono ( FormatUtils::getParamPOST('ds_telefono') );	
				
		$oEmpleado->setDs_email ( FormatUtils::getParamPOST('ds_email') );	
		
					
		return $oEmpleado;
	}
	
		
}
