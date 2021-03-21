<?php 

/**
 * Acción para editar un obrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
abstract class EditarObrasocialAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el obrasocial a modificar.
		$oObrasocial = new Obrasocial ( );
		
				
		$oObrasocial->setCd_obrasocial ( FormatUtils::getParamPOST('cd_obrasocial') );	
				
		$oObrasocial->setDs_obrasocial ( FormatUtils::getParamPOST('ds_obrasocial') );	
		
		$oObrasocial->setBl_activa ( FormatUtils::getParamPOST('bl_activa') );	
		
					
		return $oObrasocial;
	}
	
		
}
