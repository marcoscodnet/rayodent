<?php 

/**
 * Acción para modificar un ordenpractica.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ModificarOrdenpracticaAction extends EditarOrdenpracticaAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new OrdenpracticaManager();
		$manager->modificarOrdenpractica( $oEntidad );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'modificar_ordenpractica_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'modificar_ordenpractica_error';
	}
		

	public function getIdEntidad(){
		return FormatUtils::getParamPOST('id');
	}
	
	
	protected function getActionForwardFailure(){
		return 'modificar_ordenpractica_init';
	}
	
}
