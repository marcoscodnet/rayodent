<?php 

/**
 * Acción para dar de alta un empleado.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class AltaEmpleadoAction extends EditarEmpleadoAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new EmpleadoManager();
		$manager->agregarEmpleado( $oEntidad );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
	 */
	protected function getForwardSuccess(){
		return 'alta_empleado_success';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
	 */
	protected function getForwardError(){
		return 'alta_empleado_error';
	}
		

	protected function getActionForwardFailure(){
		return 'alta_empleado_init';
	}
	
}
