<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un empleado.
 *  
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class ModificarEmpleadoInitAction extends EditarEmpleadoInitAction{

	protected function getEntidad(){
		$oEmpleado = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_empleado', $id, '=');
			
			$manager = new EmpleadoManager();
			$oEmpleado = $manager->getEmpleado( $criterio );
			
		}else{
		
			$oEmpleado = parent::getEntidad();
		
		}
		return $oEmpleado ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Empleado";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_empleado";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
