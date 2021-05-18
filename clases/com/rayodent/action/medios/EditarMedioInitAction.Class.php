<?php

/**
 * Acci�n para inicializar el contexto para editar
 * un medio.
 *
 * @author modelBuilder
 * @since 18-05-2021
 *
 */
abstract class EditarMedioInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( RYT_TEMPLATE_EDITAR_MEDIO );
	}


	protected function getEntidad(){

		//se construye el medio a modificar.
		$oMedio = new Medio ( );


		$oMedio->setCd_medio ( FormatUtils::getParamPOST('cd_medio') );

		$oMedio->setDs_medio ( FormatUtils::getParamPOST('ds_medio') );


		return $oMedio;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oMedio = FormatUtils::ifEmpty($entidad, new Medio());


		$xtpl->assign ( 'cd_medio', stripslashes ( $oMedio->getCd_medio () ) );
		$xtpl->assign ( 'cd_medio_label', RYT_MEDIO_CD_MEDIO );

		$xtpl->assign ( 'ds_medio', stripslashes ( $oMedio->getDs_medio () ) );
		$xtpl->assign ( 'ds_medio_label', RYT_MEDIO_DS_MEDIO );





	}



}
