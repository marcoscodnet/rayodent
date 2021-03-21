<?php 

/**
 * Acción para inicializar el contexto para dar de alta
 * un tipooperacion.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class AltaTipooperacionInitAction extends EditarTipooperacionInitAction{

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Alta Tipo de operaci&oacute;n";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "alta_tipooperacion";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}	
}
