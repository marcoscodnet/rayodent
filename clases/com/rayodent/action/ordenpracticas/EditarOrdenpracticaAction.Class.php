<?php 

/**
 * Acción para editar un ordenpractica.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
abstract class EditarOrdenpracticaAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el ordenpractica a modificar.
		$oOrdenpractica = new Ordenpractica ( );
		
				
		$oOrdenpractica->setCd_ordenpractica ( FormatUtils::getParamPOST('cd_ordenpractica') );	
				
		$oOrdenpractica->setDt_carga ( FormatUtils::getParamPOST('dt_carga') );	
				
		$oOrdenpractica->setCd_turno ( FormatUtils::getParamPOST('cd_turno') );	
				
		$oOrdenpractica->setCd_paciente ( FormatUtils::getParamPOST('cd_paciente') );	
				
		$oOrdenpractica->setCd_profesional ( FormatUtils::getParamPOST('cd_profesional') );	
				
		$oOrdenpractica->setCd_empleado ( FormatUtils::getParamPOST('cd_empleado') );	
				
		$oOrdenpractica->setCd_obrasocialbono ( FormatUtils::getParamPOST('cd_obrasocialbono') );	
				
		$oOrdenpractica->setBl_bono ( FormatUtils::getParamPOST('bl_bono') );	
				
		$oOrdenpractica->setNu_importebono ( FormatUtils::getParamPOST('nu_importebono') );	
				
		$oOrdenpractica->setNu_reciboreintegro ( FormatUtils::getParamPOST('nu_reciboreintegro') );	
		
					
		return $oOrdenpractica;
	}
	
		
}
