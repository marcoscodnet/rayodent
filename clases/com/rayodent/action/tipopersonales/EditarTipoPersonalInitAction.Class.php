<?php 

/**
 * Acción para inicializar el contexto para editar
 * un tipoPersonal.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
abstract class EditarTipoPersonalInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( RYT_TEMPLATE_EDITAR_TIPOPERSONAL );		
	}

	
	protected function getEntidad(){
		
		//se construye el tipoPersonal a modificar.
		$oTipoPersonal = new TipoPersonal ( );
	
				
		$oTipoPersonal->setCd_tipopersonal ( FormatUtils::getParamPOST('cd_tipopersonal') );	
				
		$oTipoPersonal->setDs_tipopersonal ( FormatUtils::getParamPOST('ds_tipopersonal') );	
		
		
		return $oTipoPersonal;
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oTipoPersonal = FormatUtils::ifEmpty($entidad, new TipoPersonal());

				
		$xtpl->assign ( 'cd_tipopersonal', stripslashes ( $oTipoPersonal->getCd_tipopersonal () ) );
		$xtpl->assign ( 'cd_tipopersonal_label', RYT_TIPOPERSONAL_CD_TIPOPERSONAL );
				
		$xtpl->assign ( 'ds_tipopersonal', stripslashes ( $oTipoPersonal->getDs_tipopersonal () ) );
		$xtpl->assign ( 'ds_tipopersonal_label', RYT_TIPOPERSONAL_DS_TIPOPERSONAL );
		
		
		
		

	}

	

}
