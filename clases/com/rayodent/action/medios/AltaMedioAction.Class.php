<?php

/**
 * Acci�n para dar de alta un medio.
 *
 * @author modelBuilder
 * @since 18-05-2021
 *
 */
class AltaMedioAction extends EditarMedioAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new MedioManager();
		$manager->agregarMedio( $oEntidad );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'alta_medio_success';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_medio_error';
	}


	protected function getActionForwardFailure(){
		return 'alta_medio_init';
	}

}
