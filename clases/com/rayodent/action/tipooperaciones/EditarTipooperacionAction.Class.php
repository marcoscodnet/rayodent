<?php 

/**
 * Acción para editar un tipooperacion.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
abstract class EditarTipooperacionAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el tipooperacion a modificar.
		$oTipooperacion = new Tipooperacion ( );
		
				
		$oTipooperacion->setCd_tipooperacion ( FormatUtils::getParamPOST('cd_tipooperacion') );	
				
		$oTipooperacion->setDs_tipooperacion ( FormatUtils::getParamPOST('ds_tipooperacion') );	
		
					
		return $oTipooperacion;
	}
	
		
}
