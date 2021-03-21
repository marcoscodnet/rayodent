<?php 

/**
 * Acción para inicializar el contexto para editar
 * un obrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
abstract class EditarObrasocialInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( RYT_TEMPLATE_EDITAR_OBRASOCIAL );		
	}

	
	protected function getEntidad(){
		
		//se construye el obrasocial a modificar.
		$oObrasocial = new Obrasocial ( );
	
				
		$oObrasocial->setCd_obrasocial ( FormatUtils::getParamPOST('cd_obrasocial') );	
				
		$oObrasocial->setDs_obrasocial ( FormatUtils::getParamPOST('ds_obrasocial') );	
		
		$oObrasocial->setBl_activa ( FormatUtils::getParamPOST('bl_activa') );	
		
		
		return $oObrasocial;
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oObrasocial = FormatUtils::ifEmpty($entidad, new Obrasocial());

				
		$xtpl->assign ( 'cd_obrasocial', stripslashes ( $oObrasocial->getCd_obrasocial () ) );
		$xtpl->assign ( 'cd_obrasocial_label', RYT_OBRASOCIAL_CD_OBRASOCIAL );
				
		$xtpl->assign ( 'ds_obrasocial', stripslashes ( $oObrasocial->getDs_obrasocial () ) );
		$xtpl->assign ( 'ds_obrasocial_label', RYT_OBRASOCIAL_DS_OBRASOCIAL );
		
		$bl_activa = ( $oObrasocial->getBl_activa () )?' CHECKED ':'';
		$xtpl->assign ( 'checked_bl_activa', $bl_activa );
		$xtpl->assign ( 'bl_activa_label', RYT_OBRASOCIAL_BL_ACTIVA );
		
		

	}

	

}
