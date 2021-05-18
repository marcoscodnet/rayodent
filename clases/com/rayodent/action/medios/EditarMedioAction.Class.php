<?php

/**
 * Acci�n para editar un medio.
 *
 * @author modelBuilder
 * @since 18-05-2021
 *
 */
abstract class EditarMedioAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){

		//se construye el medio a modificar.
		$oMedio = new Medio ( );


		$oMedio->setCd_medio ( FormatUtils::getParamPOST('cd_medio') );

		$oMedio->setDs_medio ( FormatUtils::getParamPOST('ds_medio') );


		return $oMedio;
	}


}
