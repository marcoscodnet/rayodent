<?php

/**
 * Acci�n para modificar un medio.
 *
 * @author modelBuilder
 * @since 18-05-2021
 *
 */
class ModificarMedioAction extends EditarMedioAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new MedioManager();
		$manager->modificarMedio( $oEntidad );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'modificar_medio_success';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'modificar_medio_error';
	}


	public function getIdEntidad(){
		return FormatUtils::getParamPOST('id');
	}


	protected function getActionForwardFailure(){
		return 'modificar_medio_init';
	}

}
