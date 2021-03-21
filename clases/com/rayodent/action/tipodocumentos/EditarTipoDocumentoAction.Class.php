<?php 

/**
 * Acción para editar un tipoDocumento.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
abstract class EditarTipoDocumentoAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el tipoDocumento a modificar.
		$oTipoDocumento = new TipoDocumento ( );
		
				
		$oTipoDocumento->setCd_tipodocumento ( FormatUtils::getParamPOST('cd_tipodocumento') );	
				
		$oTipoDocumento->setDs_tipodocumento ( FormatUtils::getParamPOST('ds_tipodocumento') );	
		
					
		return $oTipoDocumento;
	}
	
		
}
