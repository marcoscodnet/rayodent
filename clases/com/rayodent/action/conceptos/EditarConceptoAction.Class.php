<?php 

/**
 * Acción para editar un concepto.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
abstract class EditarConceptoAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el concepto a modificar.
		$oConcepto = new Concepto ( );
		
				
		$oConcepto->setCd_concepto ( FormatUtils::getParamPOST('cd_concepto') );	
				
		$oConcepto->setCd_tipoconcepto ( FormatUtils::getParamPOST('cd_tipoconcepto') );	
				
		$oConcepto->setCd_tipooperacion ( FormatUtils::getParamPOST('cd_tipooperacion') );	
				
		$oConcepto->setDs_concepto ( FormatUtils::getParamPOST('ds_concepto') );	
		
					
		return $oConcepto;
	}
	
		
}
