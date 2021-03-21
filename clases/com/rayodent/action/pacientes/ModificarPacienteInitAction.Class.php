<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un paciente.
 *  
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class ModificarPacienteInitAction extends EditarPacienteInitAction{

	protected function getEntidad(){
		$oPaciente = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_paciente', $id, '=');
			
			$manager = new PacienteManager();
			$oPaciente = $manager->getPaciente( $criterio );
			
		}else{
		
			$oPaciente = parent::getEntidad();
		
		}
		return $oPaciente ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Paciente";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_paciente";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
