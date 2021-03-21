<?php 

/**
 * Acción para inicializar el contexto para dar de alta
 * un tipoPersonal.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class AltaTipoPersonalInitAction extends EditarTipoPersonalInitAction{

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Alta de tipo de empleado";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "alta_tipopersonal";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}	
}
