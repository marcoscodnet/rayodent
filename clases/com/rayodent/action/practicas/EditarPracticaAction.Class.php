<?php 

/**
 * Acción para editar un practica.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
abstract class EditarPracticaAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el practica a modificar.
		$oPractica = new Practica ( );
		
				
		$oPractica->setCd_practica ( FormatUtils::getParamPOST('cd_practica') );	
				
		$oPractica->setDs_practica ( FormatUtils::getParamPOST('ds_practica') );	
		
		$oPractica->setBl_activa ( FormatUtils::getParamPOST('bl_activa') );	
		
					
		return $oPractica;
	}
	
		
}
