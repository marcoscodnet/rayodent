<?php 

/**
 * Acción para modificar un practicaobrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ModificarPracticaobrasocialAction extends EditarPracticaobrasocialAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new PracticaobrasocialManager();
		$manager->modificarRepeticionesDePracticaobrasocial( $oEntidad );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'modificar_practicaobrasocial_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'modificar_practicaobrasocial_error';
	}
		

	public function getIdEntidad(){
		return FormatUtils::getParamPOST('id');
	}
	
	
	protected function getActionForwardFailure(){
		return 'modificar_practicaobrasocial_init';
	}
	
}
