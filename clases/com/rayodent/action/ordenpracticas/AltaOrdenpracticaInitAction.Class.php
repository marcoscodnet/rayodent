<?php 

/**
 * Acción para inicializar el contexto para dar de alta
 * un ordenpractica.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class AltaOrdenpracticaInitAction extends EditarOrdenpracticaInitAction{

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Alta Ordenpractica";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "alta_ordenpractica";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}	
}
