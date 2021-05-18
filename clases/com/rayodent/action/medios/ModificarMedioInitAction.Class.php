<?php

/**
 * Acci�n para inicializar el contexto para modificar
 * un medio.
 *
 * @author modelBuilder
 * @since 18-05-2021
 *
 */
class ModificarMedioInitAction extends EditarMedioInitAction{

	protected function getEntidad(){
		$oMedio = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');

			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_medio', $id, '=');

			$manager = new MedioManager();
			$oMedio = $manager->getMedio( $criterio );

		}else{

			$oMedio = parent::getEntidad();

		}
		return $oMedio ;
	}


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Medio";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_medio";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}

}
