<?php 

/**
 * Acción para inicializar el contexto para editar
 * un tipoDocumento.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
abstract class EditarTipoDocumentoInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( RYT_TEMPLATE_EDITAR_TIPODOCUMENTO );		
	}

	
	protected function getEntidad(){
		
		//se construye el tipoDocumento a modificar.
		$oTipoDocumento = new TipoDocumento ( );
	
				
		$oTipoDocumento->setCd_tipodocumento ( FormatUtils::getParamPOST('cd_tipodocumento') );	
				
		$oTipoDocumento->setDs_tipodocumento ( FormatUtils::getParamPOST('ds_tipodocumento') );	
		
		
		return $oTipoDocumento;
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oTipoDocumento = FormatUtils::ifEmpty($entidad, new TipoDocumento());

				
		$xtpl->assign ( 'cd_tipodocumento', stripslashes ( $oTipoDocumento->getCd_tipodocumento () ) );
		$xtpl->assign ( 'cd_tipodocumento_label', RYT_TIPODOCUMENTO_CD_TIPODOCUMENTO );
				
		$xtpl->assign ( 'ds_tipodocumento', stripslashes ( $oTipoDocumento->getDs_tipodocumento () ) );
		$xtpl->assign ( 'ds_tipodocumento_label', RYT_TIPODOCUMENTO_DS_TIPODOCUMENTO );
		
		
		
		

	}

	

}
