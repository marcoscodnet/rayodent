<?php 

/**
 * Acción para editar un tipoPersonal.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
abstract class EditarTipoPersonalAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el tipoPersonal a modificar.
		$oTipoPersonal = new TipoPersonal ( );
		
				
		$oTipoPersonal->setCd_tipopersonal ( FormatUtils::getParamPOST('cd_tipopersonal') );	
				
		$oTipoPersonal->setDs_tipopersonal ( FormatUtils::getParamPOST('ds_tipopersonal') );	
		
					
		return $oTipoPersonal;
	}
	
		
}
