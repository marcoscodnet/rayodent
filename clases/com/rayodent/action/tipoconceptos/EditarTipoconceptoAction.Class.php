<?php 

/**
 * Acción para editar un tipoconcepto.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
abstract class EditarTipoconceptoAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el tipoconcepto a modificar.
		$oTipoconcepto = new Tipoconcepto ( );
		
				
		$oTipoconcepto->setCd_tipoconcepto ( FormatUtils::getParamPOST('cd_tipoconcepto') );	
				
		$oTipoconcepto->setDs_tipoconcepto ( FormatUtils::getParamPOST('ds_tipoconcepto') );	
		
					
		return $oTipoconcepto;
	}
	
		
}
