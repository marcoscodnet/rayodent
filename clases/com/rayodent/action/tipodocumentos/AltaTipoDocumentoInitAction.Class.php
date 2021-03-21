<?php 

/**
 * Acción para inicializar el contexto para dar de alta
 * un tipoDocumento.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class AltaTipoDocumentoInitAction extends EditarTipoDocumentoInitAction{

	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Alta Tipo de Documento";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "alta_tipodocumento";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return false;
	}	
}
