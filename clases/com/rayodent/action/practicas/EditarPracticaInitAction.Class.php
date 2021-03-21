<?php 

/**
 * Acción para inicializar el contexto para editar
 * un practica.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
abstract class EditarPracticaInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( RYT_TEMPLATE_EDITAR_PRACTICA );		
	}

	
	protected function getEntidad(){
		
		//se construye el practica a modificar.
		$oPractica = new Practica ( );
	
				
		$oPractica->setCd_practica ( FormatUtils::getParamPOST('cd_practica') );	
				
		$oPractica->setDs_practica ( FormatUtils::getParamPOST('ds_practica') );	
		
		$oPractica->setBl_activa ( FormatUtils::getParamPOST('bl_activa') );	
		
		return $oPractica;
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oPractica = FormatUtils::ifEmpty($entidad, new Practica());

				
		$xtpl->assign ( 'cd_practica', stripslashes ( $oPractica->getCd_practica () ) );
		$xtpl->assign ( 'cd_practica_label', RYT_PRACTICA_CD_PRACTICA );
				
		$xtpl->assign ( 'ds_practica', stripslashes ( $oPractica->getDs_practica () ) );
		$xtpl->assign ( 'ds_practica_label', RYT_PRACTICA_DS_PRACTICA );
		
		$bl_activa = ( $oPractica->getBl_activa () )?' CHECKED ':'';
		$xtpl->assign ( 'checked_bl_activa', $bl_activa );
		$xtpl->assign ( 'bl_activa_label', RYT_OBRASOCIAL_BL_ACTIVA );
		
		

	}

	

}
