<?php 

/**
 * Acción para inicializar el contexto para editar
 * un tipooperacion.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
abstract class EditarTipooperacionInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( RYT_TEMPLATE_EDITAR_TIPOOPERACION );		
	}

	
	protected function getEntidad(){
		
		//se construye el tipooperacion a modificar.
		$oTipooperacion = new Tipooperacion ( );
	
				
		$oTipooperacion->setCd_tipooperacion ( FormatUtils::getParamPOST('cd_tipooperacion') );	
				
		$oTipooperacion->setDs_tipooperacion ( FormatUtils::getParamPOST('ds_tipooperacion') );	
		
		
		return $oTipooperacion;
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oTipooperacion = FormatUtils::ifEmpty($entidad, new Tipooperacion());

				
		$xtpl->assign ( 'cd_tipooperacion', stripslashes ( $oTipooperacion->getCd_tipooperacion () ) );
		$xtpl->assign ( 'cd_tipooperacion_label', RYT_TIPOOPERACION_CD_TIPOOPERACION );
				
		$xtpl->assign ( 'ds_tipooperacion', stripslashes ( $oTipooperacion->getDs_tipooperacion () ) );
		$xtpl->assign ( 'ds_tipooperacion_label', RYT_TIPOOPERACION_DS_TIPOOPERACION );
		
		
		
		

	}

	

}
