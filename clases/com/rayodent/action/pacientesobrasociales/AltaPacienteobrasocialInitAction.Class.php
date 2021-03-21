<?php 

/**
 * Acción para inicializar el contexto para dar de alta
 * un pacienteobrasocial.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class AltaPacienteobrasocialInitAction extends EditarPacienteobrasocialInitAction{

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Alta Pacienteobrasocial";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "alta_pacienteobrasocial";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}	
}
