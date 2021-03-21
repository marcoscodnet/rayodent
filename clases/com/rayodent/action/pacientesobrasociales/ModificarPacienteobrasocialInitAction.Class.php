<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un pacienteobrasocial.
 *  
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class ModificarPacienteobrasocialInitAction extends EditarPacienteobrasocialInitAction{

	protected function getEntidad(){
		$oPacienteobrasocial = null;

		if (isset ( $_GET ['id'] )) {
			//recuperamos dado su identifidor.
			$id = FormatUtils::getParam('id');			
			
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('cd_pacienteobrasocial', $id, '=');
			
			$manager = new PacienteobrasocialManager();
			$oPacienteobrasocial = $manager->getPacienteobrasocial( $criterio );
			
		}else{
		
			$oPacienteobrasocial = parent::getEntidad();
		
		}
		return $oPacienteobrasocial ;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Pacienteobrasocial";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_pacienteobrasocial";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}	
		
}
