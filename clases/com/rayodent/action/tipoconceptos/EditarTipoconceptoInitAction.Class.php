<?php 

/**
 * Acción para inicializar el contexto para editar
 * un tipoconcepto.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
abstract class EditarTipoconceptoInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( RYT_TEMPLATE_EDITAR_TIPOCONCEPTO );		
	}

	
	protected function getEntidad(){
		
		//se construye el tipoconcepto a modificar.
		$oTipoconcepto = new Tipoconcepto ( );
	
				
		$oTipoconcepto->setCd_tipoconcepto ( FormatUtils::getParamPOST('cd_tipoconcepto') );	
				
		$oTipoconcepto->setDs_tipoconcepto ( FormatUtils::getParamPOST('ds_tipoconcepto') );	
		
		
		return $oTipoconcepto;
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oTipoconcepto = FormatUtils::ifEmpty($entidad, new Tipoconcepto());

				
		$xtpl->assign ( 'cd_tipoconcepto', stripslashes ( $oTipoconcepto->getCd_tipoconcepto () ) );
		$xtpl->assign ( 'cd_tipoconcepto_label', RYT_TIPOCONCEPTO_CD_TIPOCONCEPTO );
				
		$xtpl->assign ( 'ds_tipoconcepto', stripslashes ( $oTipoconcepto->getDs_tipoconcepto () ) );
		$xtpl->assign ( 'ds_tipoconcepto_label', RYT_TIPOCONCEPTO_DS_TIPOCONCEPTO );
		
		
		
		

	}

	

}
