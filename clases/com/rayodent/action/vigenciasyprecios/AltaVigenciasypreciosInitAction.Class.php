<?php 

/**
 * Acción para inicializar el contexto para dar de alta
 * un practicaobrasocial.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class AltaVigenciasypreciosInitAction extends EditarVigenciasypreciosInitAction{

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Alta Nomenclador";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "alta_practicaobrasocial";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}	
}
